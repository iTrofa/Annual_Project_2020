<?php
require_once 'config.php';
if (session_status() === PHP_SESSION_NONE)
{
    session_start();
}
class InputValidator
{
    private array $data;
    private array $error;
    private array $valid;
    private array $fields =
        ['phone', 'email', 'firstName',
        'lastName','password','rePassword'];
    private PDO $db;

    /**
     * InputValidator constructor.
     * @param array $post
     */
    public function __construct(array $post)
    {
        $this->data = $post;
        $this->valid = [];
        $this->error = [];
        try{

            $this->db = new PDO('mysql:host=localhost:3306;dbname=flashAssistance', 'admin', 'password');

        }
        catch (Exception $e)
        {
            // En cas d'erreur, on affiche un message et on arrête tout
            die('Erreur : ' . $e->getMessage());
        }
;
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
        $email =$this->data['email'];
        $q = $this->db->prepare('SELECT email from person where email =:email') ;
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
        $phone = filter_var($this->data['phone'], FILTER_SANITIZE_NUMBER_INT);
        $q = $this->db->prepare('SELECT phoneNumber from person where phoneNumber =:phone') ;
        $q->execute([':phone' => $phone]);
        $res = $q->fetch();
        if (!filter_var($this->data['phone'], FILTER_SANITIZE_NUMBER_INT))
        {
            $this->addError('phone number is not valid', 'phone');
            $this->valid['phone'] = '';

        } elseif($res === false)
        {
             $this->addValid('phone');
        }
        else
        {
            $this->addError('phone number is already register', 'phone');
            $this->valid['phone'] = '';

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
        $q = $this->db->prepare('INSERT INTO person (firstName, lastName, email, phoneNumber, password, idPerson) VALUES (:firstName,:lastName,:email,:phoneNumber,:password,:idPerson)');
        $q->execute
        (
          [
              ':firstName'=>ucfirst($this->data['firstName']),
              ':lastName'=>ucfirst($this->data['lastName']),
              ':email'=>$this->data['email'],
              ':phoneNumber'=>filter_var($this->data['phone'], FILTER_SANITIZE_NUMBER_INT),
              ':password'=>password_hash($this->data['password'],PASSWORD_ARGON2ID,['cost'=>14]),
              ':idPerson'=>v4()
          ]
        );
            if($q)
            {
                $this->valid['request'] = 'you are now register';
                return;
            }
            $this->error['request'] = 'there is a technical problem try later';
    }
}