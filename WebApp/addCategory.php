<?php
require_once 'session.php';
if (!empty($_POST)){
    $db = new DbManager();
    if (empty($_POST['categoryName']))
    {
        http_response_code(412);
        echo json_encode(['error' => 'input empty'], JSON_THROW_ON_ERROR, 512);
        exit;

    }
    $name = ucfirst(strtolower($_POST['categoryName']));
    $q = $db->getDb()->prepare("select nameCategory from categoryservice where nameCategory = ?");
    $q->execute([$name]);
    $res = $q->fetch();
    if (empty($res))
    {
        $q = $db->getDb()->prepare("INSERT INTO categoryservice (idCategory,nameCategory) VALUES(:id,:name)");
        $res = $q->execute([
            ':id' => DbManager::v4(),
            ':name' => $name,
        ]);
        if ($res){
            http_response_code(201);
            echo json_encode(['valid' => 'category successfully added'], JSON_THROW_ON_ERROR, 512);
            exit;
        }
    }
    http_response_code(409);
    echo json_encode(['error' => 'category already exist'], JSON_THROW_ON_ERROR, 512);
    exit;
}
