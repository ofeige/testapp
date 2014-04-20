<?php

namespace Opf\Mvc;

use Opf\Registry\Registry;
use Opf\Template\ViewTwig;

class Secure extends CommandAbstract
{
    protected $aclGroup = array();

    public function main()
    {
        $view = new ViewTwig('home');
        $view->assign('session', Registry::getInstance()->getSession());
        $view->render($this->request, $this->response);
    }

    public function info()
    {
        $view = new ViewTwig('info');
        $view->assign('session', Registry::getInstance()->getSession());

        $view->assign('iniget', ini_get_all());
        $view->render($this->request, $this->response);
    }

    public function admin()
    {
        $user = \Model::factory('User')->find_array();

        $view = new ViewTwig('admin_user');
        $view->assign('session', Registry::getInstance()->getSession());

        $view->assign('user', $user);
        $view->render($this->request, $this->response);
    }
}
