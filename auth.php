<?php

session_start();

require_once("bdconnect.php");

$_SESSION["error_messages"] = ''; //сообщения ошибок

//Если нажата кнопка
    if(isset($_POST['submit']))
    {
        if(empty($_POST['login'])){
            $_SESSION["error_messages"] = 'Сэр! Вы не ввели Логин.';
        }
        else if(empty($_POST['password'])){
            $_SESSION["error_messages"] = 'Сэр! Вы не ввели Пароль.';
        }
        else
        {   
             $sql = "SELECT *
                FROM user
                WHERE login = '{$_POST['login']}'";
            
            $result = mysqli_query($mysqli, $sql);
            
            if($row = mysqli_fetch_array($result))
            {
                if($row['password']==$_POST['password'])
                {
                    $_SESSION["login"] = $row['login']; // Логин запомним
                    $_SESSION["password"] = $row['password'];
                    $_SESSION["id"] = $row['id'];
                }
                else
                    $_SESSION["error_messages"] = 'Неверный пароль!';
            }
            else
                $_SESSION["error_messages"] = "Логин \"". $_POST['login'] ."\" не найден!";
        }

    }
    else
    {
        echo 'Переход по прямой ссылке запрещён<br>';
        exit();
    }
    
    if(!empty($_SESSION["error_messages"])) //если была ошибка, то возвращаем нас обратно в форму авторизации
    {
        header('Location: auth_form.php');
    }
    else
    {
        header("Location: index.php");
    }

?>