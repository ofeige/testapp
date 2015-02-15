<?php

namespace Opf\Mvc;

use Opf\Auth\AuthEventHandler;
use Opf\Bootstrap\Bootstrap;
use Opf\Template\ViewTwig;
use application\forms\User;


class Profile extends CommandAbstract
{
    protected $roles = array();

    public function main()
    {
        $user = \User::where('email', Bootstrap::getInstance()->getSession()->getParameter(AuthEventHandler::authName))
                     ->find_one();

        if (($pictures = \Pictures::where('user_id', $user->id)->find_one()) == false) {
            $pictures = \Pictures::create();
        }

        $form = new User($this->request, $user->id);
        $form->setData($this->request->getAllParameters());
        $data              = $user->as_array();
        $form->setInitValues($data);

        $msg = '';
        if ($form->isValid() == true) {
            $data = $form->getData();

            $user->email    = $data['email'];
            $user->nickname = $data['nickname'];

            if ($data['password1'] !== '') {
                $user->password = password_hash($data['password1'], PASSWORD_DEFAULT);
            }
            Bootstrap::getInstance()->getSession()->setParameter(AuthEventHandler::authName, $data['email']);
            $user->save();

            if ($data['picture']['error'] == UPLOAD_ERR_OK) {
                $pictures->data    = file_get_contents($data['picture']['tmp_name']);
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
        $view->assign('session', Bootstrap::getInstance()->getSession());
        $view->render($this->request, $this->response);
    }
}
