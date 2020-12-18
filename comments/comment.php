<?php
    session_start();
    
    require_once("censor/function.php");

    if(!isset($_SESSION['login'])&&!isset($_SESSION['password'])) // если ещё не авторизованы
    {
        header("Location: 404.php");
        exit();
    }

    /* Принимаем данные из формы */
    $name = $_SESSION['login'];
    $page_id = $_POST["page_id"];
    $text_comment = $_POST["text_comment"];

    if(!preg_match("/[а-яa-z0-9]/iu", $text_comment)) // если в сообщение нет ни одной буквы, значит не информативное это сообщение
    {
        $_SESSION['error_messages'] = "Сообщение малоинформативно, поэтому не будет отправлено";
        header("Location: index.php");// Делаем реридект обратно
        exit();
    }
  
    $text_comment = censor($text_comment); // цензурим что нужно

    $name = htmlspecialchars($name);// Преобразуем спецсимволы в HTML-сущности
    $text_comment = htmlspecialchars($text_comment);// Преобразуем спецсимволы в HTML-сущности
    $mysqli = new mysqli("localhost", "root", "", "users");// Подключается к базе данных
    $result = $mysqli->query("INSERT INTO comments (name_user, page_id, text_comment) VALUES ('$name', '$page_id',    '$text_comment')");// Добавляем комментарий в таблицу
  
    header("Location: ".$_SERVER["HTTP_REFERER"]);// Делаем реридект обратно
?>