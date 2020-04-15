<?php

require 'autoload.php';

class LoginValidator
{
    private array $data;
    private DbManager $db;
    public function __construct(array $post)
    {
        $this->data = $post;
        $this->db = App::getDb();
    }

    public function checkPassword():array
    {
        $q = $this->db->query('SELECT firstName,email, password,idPerson from person where email= :email',
            [':email'=>$this->data['email']]);
        $res = $q->fetch();
        if(password_verify($this->data['password'],$res['password']))
        {
            $_SESSION['id'] = $res['idPerson'];
            $_SESSION['email'] = $res['email'];
            $_SESSION['firstName'] = $res['firstName'];
            return ['valid'=>'You are connected'];
        }
            return ['error'=>'Your credentials are incorrect'];
    }
}