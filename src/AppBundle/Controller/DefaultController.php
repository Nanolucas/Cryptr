<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Classes\Message;
use AppBundle\Classes\Language;
use AppBundle\Classes\Session;
use AppBundle\Classes\Ajax;

class DefaultController extends Controller {
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction() {
		$template_data = [
			'page_title' => 'Cryptr',
		];

        return $this->render('index.html.twig', $template_data);
    }

    /**
     * @Route("/level/", name="level")
     */
    public function levelAction() {
        Ajax::init();

        $level = Session::get('current_level');

        if (!$level) {
            $level = 1;
            Session::set('current_level', 1);
        }

        $level_data = $this->container->getParameter('level')[$level];

        $template_data = [
            'level_title' => $level_data['title'],
        ];

        $id = md5(serialize($level_data));

        $template_data['message_data'] = Message::set($level_data['message'])->encode($level_data['algorithm'], $level_data['difficulty'], $id)->output();

        if ($level_data['show_frequency']) {
            $template_data['letter_frequency'] = [
                'Encrypted Message' => Language::get_letter_frequency(implode($template_data['message_data'])),
                'English Letters' => Language::get_language_letter_frequency(Language::ENGLISH),
            ];
        } else {
            $template_data['letter_frequency'] = [];
        }

        echo Ajax::success(null, ['html' => $this->render('level.html.twig', $template_data)->getContent()]);
    }

    /**
     * @Route("/solve/", name="solve")
     */
    public function solveAction() {
		Ajax::init();

		if (Message::get()->check_answer($_POST['solution'])) {
            $level = Session::get('current_level');
            $next_level = $level + 1;

            if (array_key_exists($next_level, $this->container->getParameter('level'))) {
                $level_data = $this->container->getParameter('level')[$next_level];
                Message::set($level_data['message']);
                Session::set('current_level', $next_level);
            }

        	echo Ajax::success('Correct!');
		} else {
        	echo Ajax::error('Wrong :(');
		}
    }
}
