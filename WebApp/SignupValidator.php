<?php
ini_set('error_log',1);
ini_set('display_errors',1);
require_once 'DbManager.php';
if (session_status() === PHP_SESSION_NONE)
{
    session_start();
}
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
                $this->addError("{$field} is empty", $field);
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
            $this->addError("your {$field} can only contain letters", $field);
            $this->valid[$field] = '';
        } else
        {
            $this->addValid($field);
        }

    }

    private function validateEmail(): void
    {
        $email =strtolower($this->data['email']);
        $q = $this->dbManager->getDb()->$this->dbManager->getDb()->prepare('SELECT email from person where email =:email') ;
        $q->execute([':email' => $email]);
        $res = $q->fetch();
        if (!filter_var($email, FILTER_VALIDATE_EMAIL))
        {
            $this->addError('the email must be valid                                                                                                         
            ', 'email');
            $this->valid['email'] = '';
        } elseif($res === false)
        {
            $this->addValid('email');
        }
        else
        {
            $this->addError('the email is already register', 'email');
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
            $this->addError('phone number is not valid', 'phone');
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
            $this->addError('the passwords are different', 'password');
        }
         elseif(strlen($this->data['password'])<6)
            $this->addError('the password is too short','password');
    }

	    private function addDatabase(): void
	    {
		$uuid = DbManager::v4();
            $q = $this->dbManager->prepare('INSERT INTO person (firstName, lastName, email, phoneNumber, password, idPerson)
             VALUES (:firstName,:lastName,:email,:phoneNumber,:password,:idPerson)');
            $res = $q->execute
            (
                [
                    ':firstName' => ucfirst($this->data['firstName']),
                    ':lastName' => ucfirst($this->data['lastName']),
                    ':email' => strtolower($this->data['email']),
                    ':phoneNumber' => filter_var($this->data['phone'], FILTER_SANITIZE_NUMBER_INT),
                    ':password' => password_hash($this->data['password'], PASSWORD_ARGON2ID, ['cost' => 14]),
                    ':idPerson' => $uuid
                ]
            );
		    if($res)
		    {
		        $this->valid['request'] = 'you are now registered';
		        $_SESSION['id'] =$uuid;
		        return;
		    }
		    $this->error['request'] = 'there is a technical problem try later';
	    }
}
