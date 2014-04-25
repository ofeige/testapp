<?php

namespace Opf\Mvc;

use Opf\Auth\AuthEventHandler;
use Opf\Form\Elements\FileUpload;
use Opf\Form\Rules\FileUploadSize;
use Opf\Form\Rules\FileUploadType;
use Opf\Registry\Registry;
use Opf\Template\ViewTwig;
use Opf\Form\Elements\Button;
use Opf\Form\Elements\Input;
use Opf\Form\Elements\Password;
use Opf\Form\Form;
use Opf\Form\Rules\EmailNotExists;
use Opf\Form\Rules\Min;
use Opf\Form\Rules\TwoFieldsEqual;


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

        $form = new Form();

        $form->addElement(new Input('email', 'Benutzer', 'Benutzername hier eingeben'))
             ->setRequired('Benutzername nicht vorhanden')
             ->addRule(new EmailNotExists('EMail Adresse existiert schon', 'User', 'email', $user->email));
        $form->addElement(new Password('password1', 'Passwort', 'Passwort hier eingeben'))
             ->setRequired('Passwort nicht vorhanden')
             ->addRule(new Min('Passwort ist zu kurz', 5))
             ->addRule(new TwoFieldsEqual('Passwörter stimmen nicht überein', 'password2'));
        $form->addElement(new Password('password2', 'Passwort Wiederholung', 'Passwort hier eingeben'))
             ->setRequired('Passwort nicht vorhanden');
        $form->addElement(new FileUpload('Foto', 'foto', 200000))
             ->addRule(new FileUploadSize('Datei ist zu gross, max 200 KB', 200000))
             ->addRule(new FileUploadType('Bitte nur JPG, PNG und GIF benutzen'));
        $form->addElement(new Button('Sign Up'));
        $form->setInitValues($this->request, $user->as_array());

        $html = false;
        $msg  = '';
        if ($form->isValid($this->request) == true) {
            $data = $form->getData();

            $user->email    = $data['email'];
            $user->password = password_hash($data['password1'], PASSWORD_DEFAULT);
            $user->save();



            $pictures->data = file_get_contents($data['foto']['tmp_name']);
            $pictures->user_id = $user->id;
            $pictures->save();

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
