<?php

namespace Opf\Mvc;

use Opf\Auth\AuthEventHandler;
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

    public function info()
    {
        $view = new ViewTwig('info');
        $view->assign('session', Registry::getInstance()->getSession());

        $view->assign('iniget', ini_get_all());
        $view->render($this->request, $this->response);
    }
}