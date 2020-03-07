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

    public function checkPassword():array
    {
        $q = $this->db->prepare("SELECT password,idPerson from person where email= :email");

        $q->execute([':email'=>$this->data['email']]);
        $res = $q->fetch(PDO::FETCH_ASSOC);
        if(password_verify($this->data['password'],$res['password']))
        {
            $_SESSION['id'] = $res['idPerson'];
            return ['valid'=>'You are connected'];
        }
            return ['error'=>'Your identifiers are incorrect'];
    }
}