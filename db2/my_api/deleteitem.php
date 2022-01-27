<?php

try {
    require('func.php');
    // проверка метода запроса
    check_request_method("DELETE");

    // db connection
    $pdo_db = DBconnection();

    // режим обработки ошибок. Все PDO ошибки будут генерировать PDOException
    $pdo_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


    // если указаны оба параметра, то будет сгенерирована ошибка
    if (isset($_GET['bank_id'], $_GET['client_id']))
        throw new PDOException('both parameters were set', 402);


    // проверка наличия необходимого параметра и выбор соответствующего sql запроса
    if (isset($_GET['bank_id'])) {
        $id = intval($_GET['bank_id']);
        $query = "
DELETE FROM banksdb.bank
WHERE bank_id = :id;
";
    }
    elseif (isset($_GET['client_id'])) {
        $id = intval($_GET['client_id']);
        $query = "
DELETE FROM banksdb.client
WHERE client_id = :id;
";
    }
    else
        throw new PDOException('required parameter wasn`t set', 401);

    //подготовка и выполнение запроса
    $request = $pdo_db->prepare($query);
    $request->bindValue('id', $id, PDO::PARAM_INT);
    $request->execute();

    // проверка успешности запроса. Если строки были изменены, то запрос успешен.
    if ($request->rowCount()) {
        $answer = array(
            "status" => 'success',
        );
    }
    else
        throw new PDOException('bad user input', 405);

    // вывод ответа пользователю
    $json = json_encode($answer, JSON_PRETTY_PRINT);
    print $json;

    $pdo_db = null;
}
catch (PDOException $e) {
    // ошибка подключения БД
    if ($e->getCode() === 2002 or $e->getCode() === 1049 or $e->getCode() === 1045) {
        print json_encode([]);
        logger(new PDOException('Database connection error', $e->getCode()));
    }

    // неверный метод запроса
    elseif ($e->getCode() === 400) {
        http_response_code(400);
        logger($e);
    }

    // существует связь M-M
    elseif ($e->getCode() == 23000) {
        $answer = array(
            "status" => 'error',
            "message" => 'Failed to delete record'
        );
        http_response_code(400);
        print json_encode($answer, JSON_PRETTY_PRINT);
        logger(new PDOException('A many-to-many relationship exist', $e->getCode()));
    }
    else { // всё остальное при попытке удалить
        $answer = array(
            "status" => 'error',
            "message" => 'Failed to delete record'
        );
        http_response_code(400);
        print json_encode($answer, JSON_PRETTY_PRINT);
        logger($e);
    }

    $pdo_db = null;
}
catch (Error $e) {
    print json_encode([], JSON_PRETTY_PRINT);
    logger($e);
    $pdo_db = null;
}