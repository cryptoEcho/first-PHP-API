<?php


try {
    require('func.php');
    // проверка метода запроса
    check_request_method("GET");

    // db connection
    $pdo_db = DBconnection();

// режим обработки ошибок. Все PDO ошибки будут генерировать PDOException
    $pdo_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // проверка наличия необходимого параметра
    isset_required_getparam('bank_id');

    // sql запрос по основной сущности
    $query_bank = "SELECT bank.bank_id as id, bank.title as bank,
       owner.full_name as owner, banktype.type, city.title as city
FROM banksdb.bank
INNER JOIN banksdb.owner
ON bank.owner_id = owner.owner_id
INNER JOIN banksdb.banktype
ON bank.type_id = banktype.bankType_id
INNER JOIN banksdb.city
ON bank.city_id = city.city_id
WHERE bank.bank_id = :id
";

    $id = intval($_GET['bank_id']);
    $request_bank = $pdo_db->prepare($query_bank);
    $request_bank->bindValue(':id', $id, PDO::PARAM_INT);
    $request_bank->execute();
    $result_bank = $request_bank->fetchAll(PDO::FETCH_ASSOC);

    // sql запрос. связанные записи
    $query_clients = "
SELECT DISTINCT bank_client.client_id, client.first_name, client.last_name, client.capital, city.title as city
FROM banksdb.bank_client
INNER JOIN banksdb.client
ON bank_client.client_id = client.client_id
INNER JOIN banksdb.city
ON client.city_id = city.city_id
WHERE bank_client.bank_id = :id;
";

    $request_clients = $pdo_db->prepare($query_clients);
    $request_clients->bindValue('id', $id, PDO::PARAM_INT);
    $request_clients->execute();
    $result_clients = $request_clients->fetchAll(PDO::FETCH_ASSOC);

    // объединение двух результатов
    array_push($result_bank, $result_clients);
//    $result_bank["clients"] = $result_clients;
    $json = json_encode($result_bank, JSON_PRETTY_PRINT);
    print $json;
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


