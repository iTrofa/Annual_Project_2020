<?php

require_once 'DbManager.php';
class LoginValidator
{
    private array $data;
    private DbManager $db;

    public function __construct(array $post)
    {
        $this->data = $post;
        $this->db = new DbManager();
    }

    public function checkPassword(): array
    {
        if (isset($this->data['email']) && isset($this->data['password'])) {
            $q = $this->db->getDb()->prepare('SELECT firstName,email, password,idPerson from person where email= :email');
            $q->execute([':email' => $this->data['email']]);
            $res = $q->fetch(PDO::FETCH_ASSOC);
            if (password_verify($this->data['password'], $res['password'])) {
                $_SESSION['id'] = $res['idPerson'];
                $_SESSION['email'] = $res['email'];
                $_SESSION['firstName'] = $res['firstName'];
                return ['valid' => 'You are connected'];
            } else {
                return ['error' => 'Your identifiers are incorrect'];
            }
        } else {
            return ['error' => ''];
        }
    }
}