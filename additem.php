<?php

//$dsn = 'mysql:host=localhost;dbname=banksdb;charset=utf8';
$dsn = 'mysql:host=localhost;dbname=pets;charset=utf8';
$username = 'defusr';
$password = 'password';
var_dump($_POST);
try {
    $pdo_db = new PDO($dsn, $username, $password);
//    $query = "
//INSERT INTO table
//FROM
//";
    $query = "
SELECT * FROM :table

";
    $request = $pdo_db->prepare($query);
//    $request->bindParam('table', $_POST['table']);
//    $request->bindParam('table', 'cats');
    $table = 'cats';
    $request->bindParam('table', $table);
//    $request->bindValue(':cats', 'cats', PDO::PARAM_STR);
//    $request->bindValue(':cats', 'cats', PDO::PARAM_STR);
    $request->execute();
    $result = $request->fetchAll(PDO::FETCH_ASSOC);
    $json = json_encode($result, JSON_PRETTY_PRINT);
    print $json;
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
//    print_r($e);
//    $e->getTrace();
    die();
}


