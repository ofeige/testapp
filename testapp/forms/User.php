<?php

namespace testapp\forms;

use Opf\Form\Form;
use Opf\Http\RequestInterface;
use Opf\Form\Elements\Input;
use Opf\Form\Elements\FileUpload;
use Opf\Form\Elements\Button;
use Opf\Form\Elements\Password;
use Opf\Form\Rules\FileUploadSize;
use Opf\Form\Rules\FileUploadType;
use Opf\Form\Rules\EmailNotExists;
use Opf\Form\Rules\Min;
use Opf\Form\Rules\TwoFieldsEqual;

class User extends Form
{
    protected $user;

    public function __construct(\User $user, RequestInterface $request)
    {
        $this->user = $user;
        $this->request = $request;

        $this->addElement(new Input('email', 'Benutzer', 'Benutzername hier eingeben'))
             ->setRequired('Benutzername nicht vorhanden')
             ->addRule(new EmailNotExists('EMail Adresse existiert schon', 'User', 'email', $this->user->email));

        $this->addElement(new Password('password1', 'Passwort', 'Passwort hier eingeben'))
             ->addRule(new Min('Passwort ist zu kurz', 5))
             ->addRule(new TwoFieldsEqual('Passwörter stimmen nicht überein', 'password2'));

        $this->addElement(new Password('password2', 'Passwort Wiederholung', 'Passwort hier eingeben'));

        $this->addElement(new FileUpload('Foto', 'foto', 200000))
             ->addRule(new FileUploadSize('Datei ist zu gross, max 200 KB', 200000))
             ->addRule(new FileUploadType('Bitte nur JPG, PNG und GIF benutzen'));

        $this->addElement(new Button('Sign Up'));

        $this->setInitValues($this->request, $user->as_array());
    }
}
