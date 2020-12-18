<?php

    session_start();

    if(isset($_POST['submit']))
    {
        require_once("bdconnect.php");

        $brand = $_POST['brand'];
        $car_cost = $_POST['car_cost'];
        $release_date = $_POST['release_date'];

        //$good = $mysqli->query("INSERT INTO car (brand, car_cost, release_date) VALUES ($brand, $car_cost, $release_date)");
        
        $result_query_insert_orders = $mysqli->prepare("INSERT INTO car (brand, car_cost, release_date) VALUES (?, ?, ?)");
        $result_query_insert_orders->bind_param("sis", $brand, $car_cost, $release_date);
        $result_query_insert_orders->execute();
        $result_query_insert_orders->close();
        
        header("Location: ".$_SERVER["HTTP_REFERER"]);// Делаем реридект обратно
    }
    else
    {
        echo 'Переход по прямой ссылке запрещён!' . '<br>';
    }

?>