<?php


class LoginValidator
{
    private array $data;
    private PDO $db;
    public function __construct(array $post)
    {
        $this->data = $post;
        $this->db = new PDO('mysql:host=localhost:3306;dbname=flashAssistance', 'admin', 'password');
    }

    public function checkPassword():array
    {
        $q = $this->db->prepare("SELECT password,idPerson from person where email= :email");

        $q->execute([':email'=>$this->data['email']]);
        $res = $q->fetch(PDO::FETCH_ASSOC);
        if(password_verify($this->data['password'],$res['password']))
        {
            $_SESSION['id'] = $res['idPerson'];
            return ['valid'=>'vous êtes bien connecté'];
        }
            return ['error'=>'vos identifiants sont incorrects'];
    }
}