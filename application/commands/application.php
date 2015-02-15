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

    public function img()
    {
        $picture = \Pictures::find_one($this->request->getParameter('id'));

       if($picture == false) {
            $this->response->addHeader('Content-type', 'image/svg+xml');
            $this->response->addHeader('Content-length', filesize(OPF_APPLICATION_PATH . '/../public/404.svg'));
            $this->response->write(file_get_contents(OPF_APPLICATION_PATH . '/../public/404.svg'));
        }
        else {
            $info = getimagesizefromstring($picture->data);
            $this->response->addHeader('Content-type', image_type_to_mime_type($info[2]));
            $this->response->addHeader('Content-length', strlen($picture->data));
            $this->response->write($picture->data);
        }
    }
}
