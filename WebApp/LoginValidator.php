<?php

require_once 'config.php';
class LoginValidator
{
    private array $data;
    private PDO $db;
    public function __construct(array $post)
    {
        global $db;
        $this->data = $post;
        $this->db = $db;
    }

    public function checkPassword():array
    {
        $q = $this->db->prepare("SELECT firstName, password,idPerson from person where email= :email");

        $q->execute([':email'=>$this->data['email']]);
        $res = $q->fetch(PDO::FETCH_ASSOC);
        if(password_verify($this->data['password'],$res['password']))
        {
            $_SESSION['id'] = $res['idPerson'];
            $_SESSION['firstName'] = $res['firstName'];
            return ['valid'=>'You are connected'];
        }
            return ['error'=>'Your identifiers are incorrect'];
    }
}