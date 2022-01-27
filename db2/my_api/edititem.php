<?php

try {
    require('func.php');
    // проверка метода запроса
    check_request_method("POST");

    // db connection
    $pdo_db = DBconnection();

    // режим обработки ошибок. Все PDO ошибки будут генерировать PDOException
    $pdo_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // проверка на передачу параметров при помощи JSON
    developJSON();

    // проверка наличия необходимого параметра
    if (!isset($_POST['bank_id'])) {
        throw new PDOException('required parameter wasn`t set', 401);
    }

    // sql запрос
    $query = "
UPDATE banksdb.bank
SET title = :title, owner_id = :owner_id, type_id = :type_id, city_id = :city_id
WHERE bank_id = :id;
";


    // массив необязательных параметров
    $params = array(
        0 => 'title',
        1 => 'owner_id',
        2 => 'type_id',
        3 => 'city_id'
    );

    //чистка sql запроса от незаданных параметров
    foreach($params as $param) {
        if(!isset($_POST[$param])) {
            if ($param == 'city_id')
                $query = str_replace(' '.$param . ' = :' . $param, '', $query);
            else
                $query = str_replace(' '.$param . ' = :' . $param . ',', '', $query);
        }
    }
    $query = str_replace(",\r", "\r", $query);
    $request = $pdo_db->prepare($query);

    // внесение заданных параметров в sql запрос
    foreach($params as $param) {
        if (isset($_POST[$param])) {
            ${$param} = $_POST[$param];
            if ($param === 'title')
                $request->bindValue($param, ${$param}, PDO::PARAM_STR);
            else
                $request->bindValue($param, ${$param}, PDO::PARAM_INT);
        }
    }

    // прячем попытки ввести некорректные данные в id
    $id = intval($_POST['bank_id']);
    // внесение id
    $request->bindValue('id', $id, PDO::PARAM_INT);

    $request->execute();

    // проверка успешности запроса. Если строки были изменены, то запрос успешен.
    if ($request->rowCount()) {
        $answer = array(
            "status" => 'success',
            "id" => $id
        );
    }
    else
        throw new PDOException('bad user input', 405);

    // возвращение результата в виде json
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
    else { // всё остальное при попытке изменить
        $answer = array(
            "status" => 'error',
            "message" => 'Failed to edit record'
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