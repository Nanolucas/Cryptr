$(function() {
	$.get('/level/', function(return_data) {
		$('#level_container').html(return_data.data.html);
		init();
	});
});

function init() {
	$('.message_symbol').click(function() {
		if ($(this).data('state') !== 1) {
			$(this)
				.css('background-color', '#E6FFE6')
				.data('state', 1);
		} else {
			$(this)
				.css('background-color', '#FFF')
				.data('state', 0);
		}

		show_rule_box();
	});

	$('#rule_add_tick').click(function() {
		add_rule();
	});

	$('#rule_replace_with').keyup(function(e) {
		var key_code = e.which;

		if ($('#rule_replace_with').val()) {
			$('#rule_add_tick').show();
		} else {
			$('#rule_add_tick').hide();
		}

		if (key_code == 13) {
			e.preventDefault();
			add_rule();
		}
	});

	$('#solution_tick').click(function() {
		check_solution();
	});

	$('#solution_box input').keyup(function(e) {
		var key_code = e.which;

		if ($('#solution_box input').val()) {
			$('#solution_tick').show();
		} else {
			$('#solution_tick').hide();
		}

		if (key_code == 13) {
			e.preventDefault();
			check_solution();
		}
	});
}

function show_rule_box() {
	var selected_symbols = get_selected_symbols();

	if (selected_symbols != '') {
		$('#rule_replace').html(selected_symbols);
		$('#rule_box').show();
		$('#rule_replace_with').focus();
	} else {
		$('#rule_box').hide();
	}
}

function get_selected_symbols() {
	var selected_symbols = '';

	$('.message_symbol').each(function() {
		if ($(this).data('state') === 1) {
			var symbol = decode_html($(this).html());
			selected_symbols += (symbol == ' ') ? '_' : symbol;
		}
	});

	return selected_symbols;
}

function decode_html(html) {
    var txt = document.createElement("textarea");
    txt.innerHTML = html;
    return txt.value;
}

function add_rule() {
	var rule_replace_with = $('#rule_replace_with').val().toUpperCase();

	if (rule_replace_with == '') {
		return;
	}

	var selected_symbols = get_selected_symbols(),
		matched_elements = [],
		list_shown = false;

	//loop through each symbol element
	$('.message_symbol').each(function() {
		var $current = $(this);
//selected_symbols = -...
alert('current: ' + $current.data('symbol'));
		//loop through each character in the rule
		for (var i = 0; i < selected_symbols.length; i++) {
			//if we're not looking at the first character of the rule, we need to check the next element
			if (i > 0) {
				$current = $current.next();
			}
alert('sequence symbol: ' + selected_symbols.charAt(i))
			//if it matches (and hasn't already been used for another rule), store the element to work with later
			if ($current.data('symbol') == selected_symbols.charAt(i) && $current.data('state') != 2) {
				alert('match');
				$current.data('replace_here', (i == 0) ? 1 : 0);
				matched_elements.push($current);
			} else {
				alert('NO match');
				//if it doesn't match this character in the rule, nothing gets changed
				matched_elements = [];
				break;
			}
		}

		for (var i = 0; i < matched_elements.length; i++) {
			//if it's the first character in the matching set, replace it with the 'replace with' rule
			if (matched_elements[i].data('replace_here')) {
				matched_elements[i]
					.css({color: 'red', backgroundColor: '#FFF'})
					.data('state', 2)
					.html(rule_replace_with);
			//if it's after the first character in the matching set, empty the box
			} else {
				matched_elements[i]
					.css('background-color', '#FFF')
					.data('state', 2)
					.html('');
			}

			//then add a line showing the 'matched characters' replaced with [input characters] rule
			if (!list_shown) {
				$('#rule_list').show();

				$('#submit_rules')
					.before('<div data-replace="' + selected_symbols + '">Replace <b>' + selected_symbols + '</b> with <b>' + rule_replace_with + '</b> <span class="rule_remove_cross">&#x2715;</span></div>');

				$('#rule_list .rule_remove_cross').last().click(function() {
					remove_rule($(this).parent().data('replace'));
				});

				$('#rule_replace_with').val('');
				$('#rule_box').hide();

				list_shown = true;
			}
		}
	});
}

function remove_rule(rule) {
	rule = rule + '';
	var matched_elements = [],
		list_hidden = false;

	//loop through each symbol element
	$('.message_symbol').each(function() {
		var $current = $(this);

		//loop through each character in the rule
		for (var i = 0; i < rule.length; i++) {
			//if we're not looking at the first character of the rule, we need to check the next element
			if (i > 0) {
				$current = $current.next();
			}

			//if it matches, store the element to work with later
			if ($current.data('symbol') == rule.charAt(i)) {
				matched_elements.push($current);
			} else {
				//if it doesn't match this character in the rule, nothing gets changed
				matched_elements = [];
			}
		}

		for (var i = 0; i < matched_elements.length; i++) {
			matched_elements[i]
				.css('color', '')
				.data('state', 0)
				.html(matched_elements[i].data('symbol'));

			if (!list_hidden) {
				$('#rule_list div').each(function() {
					if ($(this).data('replace') == rule) {
						$(this).remove();
					}

					if (!$('#rule_list div').length) {
						$('#rule_list').hide();
					}
				})
					

				list_hidden = true;
			}
		}
	});
}

function check_solution() {
	var proposed_solution = $('#solution_box input').val();

	if (proposed_solution == '') {
		return;
	}

	$.post('/solve/', { solution: proposed_solution }, function(return_data) {
	

		if (return_data.status) {
			$('#level_container').prepend('<div class="success">' + return_data.message + '</div>');

			setTimeout(function() {
				$.get('/level/', function(return_data) {
					$('#level_container').html(return_data.data.html);
					init();
				});
			}, 3000);
		} else {
			$('#level_container').prepend('<div class="error">' + return_data.message + '</div>');
		}
	});
}