<?php

namespace application\forms;

use testapp\library\Form\Elements\DatePicker;
use testapp\library\Form\Elements\Select;
use testapp\library\Utils\Utils;
use testapp\library\Validator\IsLesserThan;
use Opf\Form\Elements\Radio;
use Opf\Form\Form;
use Opf\Form\Elements\Input;
use Opf\Form\Elements\FileUpload;
use Opf\Form\Elements\Button;
use Opf\Form\Elements\Password;
use Opf\Http\RequestInterface;
use Opf\Validator\DbRecordNotFound;
use Opf\Validator\EmailAddress;
use Opf\Validator\FileUploadType;
use Opf\Validator\IsEqualTo;
use Opf\Validator\NotEmpty;
use Opf\Validator\StringLength;

class User extends Form
{
    protected $user;

    public function __construct(RequestInterface $request, $userId = false)
    {
        /* test whether we create or edit a user */
        $exclude = array();
        if ($userId !== false) {
            $exclude = array('fieldName' => 'id', 'value' => $userId);
        }

        $this->addElement('email', new Input('E-Mail', 'insert e-mail address here'))
             ->addRule(new NotEmpty(NotEmpty::STRING))
             ->addRule(new DbRecordNotFound('User', 'email', $exclude))
             ->addRule(new EmailAddress());

        $this->addElement('nickname', new Input('Nickname', 'insert nickname here'))
             ->addRule(new NotEmpty(NotEmpty::STRING))
             ->addRule(new DbRecordNotFound('User', 'nickname', $exclude))
             ->addRule(new StringLength(64));

        $this->addElement('password1', new Password('Password', 'insert password here'))
             ->addRule(new StringLength(64, 5))
             ->addRule(new IsEqualTo('password2', $request->getAllParameters(), array(IsEqualTo::IS_EQUAL_TO => 'Passwords did not match. Please try again.')));

        $this->addElement('password2', new Password('Confirm Password', 'insert password here'));

        $this->addElement('picture', new FileUpload('Picture', 500))
             ->addRule(new FileUploadType(array('image/jpeg', 'image/png', 'image/gif', 'image/tiff')));

        /** when we add a user, the password must be set */
        if ($userId == false) {
            $this->getElement('password1')->addRule(new NotEmpty(NotEmpty::STRING));
            $this->getElement('password2')->addRule(new NotEmpty(NotEmpty::STRING));
        }

        if ($userId !== false) {
            $this->addElement('button', new Button('update'));
        } else {
            $this->addElement('button', new Button('Sign Up'));
        }
    }
}
