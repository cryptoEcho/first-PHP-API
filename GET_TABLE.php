<?php
// dsn, user and his password
try {
    $dsn = 'mysql:host=localhost;dbname=banksdb;charset=utf8';
    $username = 'defusr';
    $password = 'password';

// db connection
    $pdo_db = new PDO($dsn, $username, $password);

// режим обработки ошибок dev
//    $pdo_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// режим обработки ошибок prod
    $pdo_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT);
    if (isset($_GET['table'])) {
        if ($_GET['table'] === 'bank') {
            $query = "
SELECT bank.title as bank, city.title as city, owner.full_name as owner, banktype.type as `bank type`
FROM `bank`
INNER JOIN `city`
	ON bank.city_id = city.city_id
INNER JOIN `owner`
	ON bank.owner_id = owner.owner_id
INNER JOIN `bankType`
	ON bank.type_id = banktype.bankType_id
ORDER BY owner.full_name;
"; // end of sql request
        } elseif ($_GET['table'] === 'client') {
            $query = "
SELECT client.first_name as name, client.last_name as `last name`, city.title as city, bank.title as bank
FROM banksdb.client
INNER JOIN `city`
	ON client.city_id = city.city_id
INNER JOIN `bank_client`
	ON client.client_id = bank_client.client_id
INNER JOIN `bank`
	ON bank_client.bank_id = bank.bank_id
ORDER BY client.first_name;
"; // end of sql request
        } else {
            echo 'Bad Request'; // should be Error
            die();
        }
    }
    else {
        print 'Bad Request';
        die();
    }


//$query = "
//";
    $request = $pdo_db->prepare($query);
    $request->execute();
    $result = $request->fetchAll(PDO::FETCH_ASSOC);
//    var_dump($_GET);
//    var_dump($result);
    $json = json_encode($result); // ,JSON_PRETTY_PRINT)
    print $json;
} catch (PDOException $e) {
//    print "Error!: " . $e->getMessage() . "<br/>";
//    print_r($e);
//    $e->getTrace();
    die();
}

