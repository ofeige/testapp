<?php

namespace Opf\Mvc;

use Opf\Http\RequestInterface;
use Opf\Http\ResponseInterface;
use Opf\Template\View;

class Secure extends CommandAbstract
{
   public $isProtected = true;
   protected $secureRole = array('user', 'admin');

   public function main()
   {
      $view = new View('home');
      $view->render($this->request, $this->response);
   }

   public function info()
   {
      $view = new View('info');
      $view->render($this->request, $this->response);
   }
}
