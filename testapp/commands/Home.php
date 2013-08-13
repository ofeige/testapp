<?php

namespace Opf\Mvc;

use Opf\Http\RequestInterface;
use Opf\Http\ResponseInterface;
use Opf\Template\View;

class Home extends CommandAbstract
{
   public $isProtected = false;

   public function main()
   {
      $view = new View('status');
      $view->render($this->request, $this->response);
   }

   public function info()
   {
      $view = new View('info');
      $view->render($this->request, $this->response);
   }

   public function signin()
   {
      $view = new View('signin');
      $view->assign('action', '/?app=secure');
      $view->render($this->request, $this->response);
   }
}