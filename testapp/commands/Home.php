<?php

namespace Opf\Mvc;

use Opf\Auth\AuthEventHandler;
use Opf\Form\Elements\Button;
use Opf\Form\Elements\Input;
use Opf\Form\Elements\Password;
use Opf\Form\Form;
use Opf\Form\Rules\Min;
use Opf\Registry\Registry;
use Opf\Template\ViewTwig;


class Home extends CommandAbstract
{
    public $isProtected = false;

    public function main()
    {
        $view = new ViewTwig('home');
        $view->assign('session', Registry::getInstance()->getSession());
        $view->assign('authUsername', AuthEventHandler::authName);
        $view->assign('authPassword', AuthEventHandler::authPassword);
        $view->render($this->request, $this->response);
    }

    public function signup()
    {
        $form = new Form();

        $input = new Input('user', 'Benutzer', 'Benutzername hier eingeben');
        $input->setRequired('Benutzername nicht vorhanden');

        $password1 = new Password('password1', 'Passwort', 'Passwort hier eingeben');
        $password1->setRequired('Passwort nicht vorhanden')->addRule(new Min('Passwort ist zu kurz', 5));

        $password2 = new Password('password2', 'Passwort Wiederholung', 'Passwort hier eingeben');
        $password2->setRequired('Passwort nicht vorhanden');

        $button = new Button('Sign Up');

        $form->addElement($input);
        $form->addElement($password1);
        $form->addElement($password2);
        $form->addElement($button);

        if($form->isValid($this->request)) {
            /** put code for saving data here */
            $html = '<p>save data</p>';
        }
        else {
            $html = (string) $form;
        }




        $view = new ViewTwig('signup');
        $view->assign('session', Registry::getInstance()->getSession());
        $view->assign('form', $html);
        $view->assign('authUsername', AuthEventHandler::authName);
        $view->assign('authPassword', AuthEventHandler::authPassword);
        $view->render($this->request, $this->response);
    }
}