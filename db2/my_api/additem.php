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

    // проверка наличия переданных параметров для добавления новой записи
    if (!isset($_POST['title'], $_POST['owner_id'], $_POST['type_id'], $_POST['city_id'])) {
        throw new PDOException('post parameters have not been set', 401);
    }


    // sql запрос
    $query_insert = "
INSERT INTO banksdb.bank (`bank_id`, `title`, `owner_id`, `type_id`, `city_id`)
VALUES (NULL, ?, ?, ?, ?)
";



    // присвоение переменных для последующего использования
    // помним, что они небезопасны
    $title = $_POST['title'];
    $owner_id = intval($_POST['owner_id']);
    $banktype_id = intval($_POST['type_id']);
    $city_id = intval($_POST['city_id']);

    // проверка на корректность введённых значений
    // проверка на корректность введённых значений
    // проверить существование id в соответствующей таблице
    $params = array(
        0 => 'owner_id',
        1 => 'banktype_id',
        2 => 'city_id'
    );

    foreach($params as $param) {
        $query_check = "
SELECT COUNT(*)
FROM " . str_replace('_id', '', $param) ."
WHERE " . $param ." = :param
"; // универсальный запрос с подстановкой полей таблиц из запроса

        $request_check = $pdo_db->prepare($query_check);
        $request_check->bindValue('param', ${$param}, PDO::PARAM_INT);
        $request_check->execute();
        // если count = 0, то такого значения id не существует => ошибка. Иначе count=1 выполнение программы продолжается
        if (!($request_check->fetchColumn())) {
            throw new PDOException('chosen id doesn`t exist', 404); // указанный параметр отсутствует в смежной таблице
        }
    }

    // подготовка и выполнение основного sql запроса
    $request = $pdo_db->prepare($query_insert);
    $request->execute([$title, $owner_id, $banktype_id, $city_id]);

    $answer = array(
        "status" => "success",
        "id" => $pdo_db->lastInsertId()
    );

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
    else { // всё остальное при попытке добавить
        $answer = array(
            "status" => 'error',
            "message" => 'Failed to add record'
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
