<?php
ini_set('error_log',1);
ini_set('display_errors',1);
require_once 'DbManager.php';
if (session_status() === PHP_SESSION_NONE)
{
    session_start();
}
class AddServiceValidator
{
    private array $data;
    private array $error;
    private array $valid;
    private array $fields =
        ['category', 'service', 'image', 'price',
            'demo'];
    private DbManager $db;



    /**
     * SignupValidator constructor.
     * @param array $post
     */
    public function __construct(array $post)
    {
        $this->data = $post;
        $this->valid = [];
        $this->error = [];
        $this->db = new DbManager();

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
        $this->validateName('category');
        $this->validateName('service');
        $this->validateName('image');
        $this->validateName('price');
        $this->validateName('demo');
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

    private function addDatabase(): void
    {
        $q = $this->db->prepare('INSERT INTO service (category, service, price, image, demo)
             VALUES (:category,:service,:image,:demo)');
        $res = $q->execute
        (
            [
                ':category' => ucfirst($this->data['category']),
                ':service' => ucfirst($this->data['name']),
                ':price' => ucfirst($this->data['price']),
                ':image' => strtolower('images/' . $this->data['image']),
                ':demo' => ucfirst($this->data['demo'])
            ]
        );

        if($res)
        {
            $this->valid['request'] = 'Service Successfully Added';
            /*return;*/
        }
        $this->error['request'] = 'There is a technical problem try later';
    }
}
