<?php

require_once('../Lang/gettext.inc');

class SignupValidator extends Form
{
    private array $fields =
        ['phone', 'email', 'firstName',
            'lastName', 'password', 'rePassword', 'location'];
    private array $fieldsUpdate =
        ['phone', 'email', 'firstName',
            'lastName', 'location'];
    private bool $update;


    /**
     * SignupValidator constructor.
     * @param array $post $_POST
     * @param array $file $_FILES
     * @param bool $update true if it's for update profile else just signup
     */
    public function __construct(array $post, array $file, bool $update = false)
    {
        parent::__construct($post, $file);
        $this->update = $update;
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
        if ($this->checkImages() === false)
        {
            $_SESSION['valid'] = $this->valid;
            $_SESSION['error'] = $this->error;
            return;
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
        if (!empty($this->error))
        {
            $_SESSION['error'] = $this->error;
            $_SESSION['valid'] = $this->valid;
            return;
        }
        $this->addDatabase();
        $_SESSION['error'] = $this->error;
        $_SESSION['valid'] = $this->valid;
    }

    public function validateEmptyInputsUpdate(): void
    {
        foreach ($this->fieldsUpdate as $field)
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
        if ($this->checkImages() === false)
        {
            $_SESSION['valid'] = $this->valid;
            $_SESSION['error'] = $this->error;
            return;
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
        if (!empty($this->data['password']) && !empty($this->data['rePassword']))
            $this->validatePassword();
        if (!empty($this->error))
        {
            $_SESSION['error'] = $this->error;
            $_SESSION['valid'] = $this->valid;
            return;
        }
        $this->updateDatabase();
    }


    private function validateEmail(): void
    {
        $email = strtolower($this->data['email']);
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
        if ($this->data['password'] !== $this->data['rePassword'])
        {
            $passDif = _('the passwords are different');
            $this->addError($passDif, 'password');
        } elseif (strlen($this->data['password']) < 6)
        {
            $passShort = _('the password is too short');
            $this->addError($passShort, 'password');
        } else
        {
            $this->data['password'] = password_hash($this->data['password'], PASSWORD_ARGON2ID, ['cost' => 14]);
        }
    }

    private function updateDatabase(): void
    {
        $q = $this->dbManager->query('UPDATE SET firstName=:firstName, lastName =:lastName,email = :email,
         :phoneNumber from person where idPerson = :idPerson', [
            ':firstName' => $this->data['firstName'],
            ':lastName' => $this->data['lastName'],
            ':email' => strtolower($this->data['email']),
            ':phoneNumber' => filter_var($this->data['phone'], FILTER_SANITIZE_NUMBER_INT),
            ':password' => $this->data['password'],
            ':idPerson' => $_SESSION['id']
        ]);
    }

    private function addDatabase(): void
    {
        $uuid = DbManager::v4();
        $q = $this->dbManager->query('INSERT INTO person (firstName, lastName, email, phoneNumber, password, idPerson)
             VALUES (:firstName,:lastName,:email,:phoneNumber,:password,:idPerson)',
            [
                ':firstName' => $this->data['firstName'],
                ':lastName' => $this->data['lastName'],
                ':email' => strtolower($this->data['email']),
                ':phoneNumber' => filter_var($this->data['phone'], FILTER_SANITIZE_NUMBER_INT),
                ':password' => $this->data['password'],
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
		    $techErr = _('there is a technical problem try later');
		    $this->error['request'] = $techErr;
	    }
}
