<?php

try {
    require('func.php');
    ini_set('memory_limit', '256M');
    // проверка метода запроса
    check_request_method("GET");

    // db connection
    $pdo_db = DBconnection();

// режим обработки ошибок. Все PDO ошибки будут генерировать PDOException
    $pdo_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // sql запрос
    $query = "
SELECT client.client_id, client.first_name as name, client.last_name as `last name`, city.title as city, bank.title as bank
FROM banksdb.client
INNER JOIN banksdb.city
	ON client.city_id = city.city_id
INNER JOIN banksdb.bank_client
	ON client.client_id = bank_client.client_id
INNER JOIN banksdb.bank
	ON bank_client.bank_id = bank.bank_id
ORDER BY client.client_id;
"; // end of sql request

    // подготовка и выполнение запроса к БД
    $request = $pdo_db->prepare($query);
    $request->execute();
    $result = $request->fetchAll(PDO::FETCH_ASSOC);

    // возвращение результата
    $json = json_encode($result,JSON_PRETTY_PRINT);
    print $json;

    // закрытие подключения к БД
    $pdo_db = null;


}
catch (PDOException $e) {

    // ошибка подключения БД
    if ($e->getCode() === 2002 or $e->getCode() === 1049 or $e->getCode() === 1045) {
        print json_encode([]);
        logger(new PDOException('Database connection error', $e->getCode()));
        $pdo_db = null;
    }

    // неверный метод запроса
    elseif ($e->getCode() === 400) {
        http_response_code(400);
        logger($e);
    }
    else { // всё остальное
        print json_encode([], JSON_PRETTY_PRINT);
        logger($e);
    }

    $pdo_db = null;
}
catch (Error $e) {
    print json_encode([], JSON_PRETTY_PRINT);
    logger($e);
    $pdo_db = null;
}
