<?php

try {
    require('func.php');

    // проверка метода запроса
    check_request_method("GET");

    // db connection
    $pdo_db = DBconnection();

// режим обработки ошибок. Все PDO ошибки будут генерировать PDOException
    $pdo_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // sql запрос
    $query = "
SELECT bank.bank_id as id, bank.title as title, owner.full_name as owner, banktype.type as `bank type`, city.title as city
FROM banksdb.bank
INNER JOIN banksdb.city
	ON bank.city_id = city.city_id
INNER JOIN banksdb.owner
	ON bank.owner_id = owner.owner_id
INNER JOIN banksdb.banktype
	ON bank.type_id = banktype.bankType_id
ORDER BY bank.bank_id;
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

