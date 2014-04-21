<?php

namespace Opf\Mvc;

use Opf\Registry\Registry;
use Opf\Template\ViewTwig;

class Secure extends CommandAbstract
{
    protected $roles = array();

    public function main()
    {
        $view = new ViewTwig('secure_overview');
        $view->assign('session', Registry::getInstance()->getSession());
        $view->render($this->request, $this->response);
    }
}
