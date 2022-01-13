<?php
$dsn = 'mysql:host=localhost;dbname=pets;charset=utf8';
$username = 'defusr';
$password = 'password';

// db connection
$pdo_db = new PDO($dsn, $username, $password);

/* Выполнение запроса с привязкой PHP-переменных */
$calories = 'Lennon';
$colour = 'Sandy';
$tableToUse = $_POST['table'];
$sth = $pdo_db->prepare('SELECT id, name, owner
    FROM ' . $tableToUse . '
    WHERE owner = :calories AND name = :colour');
$sth->bindParam('calories', $calories);
/* Имена также могут начинаться с двоеточия ":" (необязательно) */
$sth->bindParam(':colour', $colour);
$sth->execute();
$result = $sth->fetchAll(PDO::FETCH_ASSOC);
$json = json_encode($result, JSON_PRETTY_PRINT);
print $json;
