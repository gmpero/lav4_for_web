<?php
    session_start();
    if(!isset($_SESSION['login'])&&!isset($_SESSION['password'])) // если ещё не авторизованы
    {
        header("Location: 404.php");
    }
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="coments.css">
</head>
    
<body>
<div class= "form">

    <?php
        if(isset($_SESSION['error_messages']))
        {
            echo '<p>'.$_SESSION['error_messages'].'</p>';
            unset($_SESSION['error_messages']);
        }
    ?>
    
    <form name="comment" action="comment.php" method="post">
        <p>
            <label>Вы отправляете от имени: "<?php echo $_SESSION['login'];?>"</label>
        </p>
        <p>
            <label>Комментарий:</label>
            <br/>
            <textarea name="text_comment" cols="100" rows="4" maxlength="200"></textarea>
        </p>
        <p>
            <input type="hidden" name="page_id" value="1"/>
            <input type="submit" name="submit" value="Отправить" />
        </p>
    </form>
    
   <?php
        if($_SESSION["id"] == 1)
        {
    ?>
        <form action="mat.php" method="post">
            <label>Введите матерные слова (через пробел, не более 200 символов): </label>
            <br>
            <input type="text" size="50" maxlength="200" name="mat">
            <p><input type="submit" name="submit" value="Отправить" /></p>
        </form>
    <?php
        }
    ?>
    
    <?php
        $page_id = 1;// Уникальный идентификатор страницы (статьи или поста)
        $mysqli = new mysqli("localhost", "root", "", "users");// Подключается к базе данных
        $mysqli->set_charset('utf8');
        $result_set = $mysqli->query("SELECT * FROM `comments` WHERE `page_id`='$page_id'"); //Вытаскиваем все комментарии для данной страницы

        while ($row = $result_set->fetch_assoc()) {
    ?>
        <div class="container">
            <div class = "coments">
                <div class = name>
                    <string>"<?php echo $row['name_user']; ?>"</string>
                </div>
                <div class="break"></div>
                <div class = "coment">
                    <string>
                    <?php echo str_replace("\r\n", "<br>", $row['text_comment']); ?>
                    </string>
                </div>
            </div>
        </div>
    <?php
      }
    ?>
</div>
</body>
</html>