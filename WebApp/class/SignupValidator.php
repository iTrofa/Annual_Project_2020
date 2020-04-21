<?php

require_once('Lang/gettext.inc');

require 'autoload.php';


class SignupValidator
{
    private array $data;
    private array $error;
    private array $valid;
    private array $fields =
        ['phone', 'email', 'firstName',
        'lastName','password','rePassword'];
    private DbManager $dbManager;

    /**
     * SignupValidator constructor.
     * @param array $post
     */
    public function __construct(array $post)
    {
        global $db;
        $this->data = $post;
        $this->valid = [];
        $this->error = [];
        $this->dbManager = new  DbManager();

    }

    public function validateEmptyInputs(): void
    {
        foreach ($this->fields as $field)
        {
            if (empty($this->data[$field]))
            {
                $empty = _('is empty');
                $this->addError("{$field} $empty", $field);
            } else
            {
                $this->addValid($field);
            }
        }
        if (!empty($this->error))
        {
            $_SESSION['error'] = $this->error;
            $_SESSION['valid'] = $this->valid;
            return;
        }
        $this->validateName('firstName');
        $this->validateName('lastName');
        $this->validateEmail();
        $this->validatePhone();
        $this->validatePassword();
        if(!empty($this->error))
        {
            $_SESSION['error'] = $this->error;
            $_SESSION['valid'] = $this->valid;
            return;
        }
        $this->addDatabase();
            $_SESSION['error'] = $this->error;
            $_SESSION['valid'] = $this->valid;

        return;
    }

    /**
     * @param $field
     */
    private function validateName($field): void
    {
        $name = $this->data[$field];

        if (!ctype_alpha($name))
        {
            $your = _('your');
            $letters = _('can only contain letters');
            $this->addError("$your {$field} $letters", $field);
            $this->valid[$field] = '';
        } else
        {
            $this->addValid($field);
        }

    }

    private function validateEmail(): void
    {
        $email =strtolower($this->data['email']);
        $q = $this->dbManager->query('SELECT email from person where email =:email',
            [':email' => $email]);
        $res = $q->fetch();
        if (!filter_var($email, FILTER_VALIDATE_EMAIL))
        {
            $mailErr = _('the email must be valid');
            $this->addError($mailErr, 'email');
            $this->valid['email'] = '';
        } elseif($res === false)
        {
            $this->addValid('email');
        }
        else
        {
            $mailReg = _('the email is already registered');
            $this->addError($mailReg, 'email');
            $this->valid['email'] = '';
        }
    }

    /**
     * @param string $errorString
     * @param string $field
     */
    private function addError(string $errorString, string $field): void
    {
        $this->error[$field] = $errorString;
    }

    private function addValid(string $field): void
    {
        $this->valid[$field] = $this->data[$field];
    }

    private function validatePhone(): void
    {

        if (!filter_var($this->data['phone'], FILTER_SANITIZE_NUMBER_INT))
        {
            $phoneErr = _('phone number is not valid');
            $this->addError($phoneErr, 'phone');
            $this->valid['phone'] = '';

        }
        else
        {
             $this->addValid('phone');
        }
    }

    private function validatePassword(): void
    {
        if ($this->data['password']!== $this->data['rePassword'])
        {
            $passDif = _('the passwords are different');
            $this->addError($passDif, 'password');
        }
         elseif(strlen($this->data['password'])<6) {
             $passShort = _('the password is too short');
             $this->addError($passShort, 'password');
         }
    }

	    private function addDatabase(): void
	    {
		$uuid = DbManager::v4();
            $q = $this->dbManager->query('INSERT INTO person (firstName, lastName, email, phoneNumber, password, idPerson)
             VALUES (:firstName,:lastName,:email,:phoneNumber,:password,:idPerson)',
                [
                    ':firstName' => ucfirst($this->data['firstName']),
                    ':lastName' => ucfirst($this->data['lastName']),
                    ':email' => strtolower($this->data['email']),
                    ':phoneNumber' => filter_var($this->data['phone'], FILTER_SANITIZE_NUMBER_INT),
                    ':password' => password_hash($this->data['password'], PASSWORD_ARGON2ID, ['cost' => 14]),
                    ':idPerson' => $uuid
                ]);
		    if($q)
		    {
		        $validReq = _('you are now registered');
		        $this->valid['request'] = $validReq;
		        $_SESSION['id'] = $uuid;
                $_SESSION['firstName'] =  ucfirst($this->data['firstName']);
		        return;
		    }
		    $techErr = 'there is a technical problem try later';
		    $this->error['request'] = $techErr;
	    }
}
