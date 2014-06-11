<?php

namespace Opf\Mvc;

use testapp\forms\User;
use Opf\Auth\AuthEventHandler;
use Opf\Registry\Registry;
use Opf\Template\ViewTwig;

class Home extends CommandAbstract
{
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
        $form = new User($this->request);
        $form->deleteElement('picture');

        $form->setData($this->request->getAllParameters());
        if ($isValid = $form->isValid()) {
            $data = $form->getData();

            $user                 = \Model::factory('User')->create();
            $user->email          = $data['email'];
            $user->nickname       = $data['nickname'];
            $user->password       = password_hash($data['password1'], PASSWORD_DEFAULT);
            $user->save();
        }

        $view = new ViewTwig('signup');
        $view->assign('session', Registry::getInstance()->getSession());
        $view->assign('form', (string)$form);
        $view->assign('isValid', $isValid);
        $view->assign('authUsername', AuthEventHandler::authName);
        $view->assign('authPassword', AuthEventHandler::authPassword);
        $view->render($this->request, $this->response);
    }

}
