<?php

namespace Opf\Mvc;

use Opf\Auth\AuthEventHandler;
use Opf\Registry\Registry;
use Opf\Template\ViewTwig;
use testapp\forms\User;


class Profile extends CommandAbstract
{
    protected $roles = array();

    public function main()
    {
        $user = \User::where('email', Registry::getInstance()->getSession()->getParameter(AuthEventHandler::authName))
                     ->find_one();

        if (($pictures = \Pictures::where('user_id', $user->id)->find_one()) == false) {
            $pictures = \Pictures::create();
        }

        $form = new User($user, $this->request);

        $msg  = '';
        if ($form->isValid($this->request) == true) {
            $data = $form->getData();

            $user->email = $data['email'];
            if ($data['password1'] !== '') {
                $user->password = password_hash($data['password1'], PASSWORD_DEFAULT);
            }
            Registry::getInstance()->getSession()->setParameter(AuthEventHandler::authName, $data['email']);
            $user->save();

            if ($data['foto']['error'] == UPLOAD_ERR_OK) {
                $pictures->data    = file_get_contents($data['foto']['tmp_name']);
                $pictures->user_id = $user->id;
                $pictures->save();
            }

            $msg = 'Saved data successfully!';
        }

        $view = new ViewTwig('profile');
        $view->assign('form', (string)$form);
        $view->assign('header', 'Edit profile data');
        $view->assign('msg', $msg);
        $view->assign('img_id', $pictures->id);
        $view->assign('session', Registry::getInstance()->getSession());
        $view->render($this->request, $this->response);
    }
}
