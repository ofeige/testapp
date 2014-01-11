<?php

namespace Opf\Mvc;

use Opf\Registry\Registry;
use Opf\Template\View;
use Opf\Template\ViewTwig;

class Secure extends CommandAbstract
{
   public $isProtected = true;
   protected $secureRole = array('user', 'admin');

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
}
