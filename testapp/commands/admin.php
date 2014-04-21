<?php

namespace Opf\Mvc;

use Opf\Template\ViewTwig;
use Opf\Registry\Registry;

class Admin extends CommandAbstract
{
    protected $roles = array('admin');

    public function main()
    {
        $user = \User::filter('withRoles')->find_array();

        $view = new ViewTwig('admin_overview');
        $view->assign('session', Registry::getInstance()->getSession());

        $view->assign('user', $user);
        $view->render($this->request, $this->response);
    }

    public function toggleAdmin()
    {
        $user        = \User::find_one($this->request->getParameter('id'));
        $userHasRole = $user->user_has_role()->find_one();

        if ($userHasRole === false) {
            $userHasRole          = \UserRole::create();
            $userHasRole->user_id = $this->request->getParameter('id');
            $userHasRole->role_id = \Role::admin;
            $userHasRole->save();
        } else {
            $userHasRole->delete();
        }
        header('Location: /?app=admin&cmd=main');
        exit;
    }

    public function info()
    {
        $view = new ViewTwig('info');
        $view->assign('session', Registry::getInstance()->getSession());

        $view->assign('iniget', ini_get_all());
        $view->render($this->request, $this->response);
    }
}
