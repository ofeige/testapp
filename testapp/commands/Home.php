<?php

namespace Opf\Mvc;

use Opf\Registry\Registry;
use Opf\Template\View;
use Opf\Template\ViewTwig;

class Home extends CommandAbstract
{
    public $isProtected = false;

    public function main()
    {
        $view = new ViewTwig('home');
        $view->assign('session', Registry::getInstance()->getSession());
        $view->render($this->request, $this->response);
    }

    public function info()
    {
        $view = new View('info');
        $view->render($this->request, $this->response);
    }
}