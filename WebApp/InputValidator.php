<?php
session_start();

class InputValidator
{
    private array $data;
    private array $error;
    private array $valid;
    private array $fields = ['username', 'email', 'firstName', 'lastName'];

    /**
     * InputValidator constructor.
     * @param array $post
     */
    public function __construct(array $post)
    {
        $this->data = $post;
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
    }

    /**
     * @param $field
     */
    private function validateName($field): void
    {
        $name = trim($this->data[$field]);
        if (!preg_match('/^[a-zA-Z]$/', $name))
        {
            $this->addError('your {$field} can only contain letters', $field);
            $this->valid[$field] = '';
        } else
        {
            $this->addValid($field);
        }

    }

    private function validateEmail(): void
    {
        $email = trim($this->data['email']);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL))
        {
            $this->addError('the email must be valid                                                                                                         
            ', 'email');
            $this->valid['email'] = '';
        } else
        {
            $this->addValid('email');
        }
    }

    /**
     * @param string $errorString
     * @param string $field
     */
    private function addError(string $errorString, string $field): void
    {
        $error[$field] = $errorString;
    }

    private function addValid(string $field): void
    {
        $valid[$field] = $this->data[$field];
    }

    private function validatePhone(): void
    {
        if (filter_var($this->data['phone'], FILTER_SANITIZE_NUMBER_INT))
        {
            $this->addValid('phone');
        } else
        {
            $this->addError('phone number is not valid', 'phone');
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
}