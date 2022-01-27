<?php

// проверка метода запроса
function check_request_method(string $method): void {
    if (isset($_SERVER["REQUEST_METHOD"])){
        if ($_SERVER["REQUEST_METHOD"] !== $method)
            throw new PDOException('bad request method', 400);
    }
    else
        throw new PDOException('no request method', 406);
}

// соединение с БД
function DBconnection(): PDO {
    $dsn = 'mysql:host=localhost;dbname=banksdb;charset=utf8';
    $username = 'defusr';
    $password = 'password';

    return new PDO($dsn, $username, $password);
}


// логирование ошибок
function logger($e) {
    $log_file = '../../error.log'; // путь к файлу недоступен со стороны клиента
    // если не существует файла, создать его
    if (!file_exists($log_file)) {
        file_put_contents($log_file, '');
    }
//    var_dump($_SERVER);
    date_default_timezone_set('Europe/Moscow');
    $time = date('D d.m.y H:i:s', time());

    $uri = $_SERVER["PHP_SELF"];
    $contents = file_get_contents($log_file);

    $contents .= "[$time]\t$uri error ". $e->getCode() . "\t" . $e->getMessage() . "\r";
//    $contents .= "[$time]\terror $e->errorInfo()\r";

    file_put_contents($log_file, $contents);
}

// проверка наличия необходимого параметра
function isset_required_getparam(string $param): void {
    if (!isset($_GET[$param])) {
        throw new PDOException('get parameter wasn`t set', 10000);
    }
}


function developJSON(): void {
    if (isset($_SERVER['CONTENT_TYPE'])) {
        if ($_SERVER['CONTENT_TYPE'] == 'application/json') {
            function isValidJSON($str) {
                json_decode($str);
                return json_last_error() == JSON_ERROR_NONE;
            }

            $json_params = file_get_contents("php://input");

            if (strlen($json_params) > 0 && isValidJSON($json_params))
                $_POST = json_decode($json_params, true);
            else
                throw new PDOException('bad json');
        }
    }
}
//function catch_dev($e) {
//        print "Error!: " . $e->getMessage() . "<br/>";
//    print_r($e);
//    $e->getTrace();
//}
//
//
//function catch_prod($e, $action) {
//    if ($e->getCode() === 400) // неверный метод запроса
//        $answer = array(
//            "status" => 'error',
//            "code" => $e->getCode()
//        );
//    else
//        $answer = array(
//            "status" => 'error',
//            "code" => 400,
//            "message" => 'Failed to ' . $action . 'record'
//        );
//
//    $json = json_encode($answer, JSON_PRETTY_PRINT);
//    print $json;
//}

//function bad_bd_connection(PDOException $e): void {
//    if ($e->getCode() === 2002 or $e->getCode() === 1049 or $e->getCode() === 1045) {
//        print json_encode('[]');
//        logger(new PDOException('Database connection error', $e->getCode()));
//        $pdo_db = null;
//    }
//}
//
//function wrong_request_method(PDOException $e): void {
//    if ($e->getCode() === 400) { // неверный метод запроса
//        $answer = array(
//            "status" => 'error',
//            "code" => $e->getCode()
//        );
//        print json_encode($answer, JSON_PRETTY_PRINT);
//        logger($e);
//    }
//}
//
//function other_error(PDOException $e): void {
//    print json_encode('[]', JSON_PRETTY_PRINT);
//    logger($e);
//}

