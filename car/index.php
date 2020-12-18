<?php
    session_start();
?>

<!doctype html>
<html lang="en">
<link rel="stylesheet" href="add_car.css" type="text/css"/>

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
  <title>Авто</title>

    <script type="text/javascript">
        $(document).ready(function(){
            
            var button = $('input[name=submit]');
            button.attr('disabled', true); // сразу блокируем кнопку, т.к. мы ничего не написали
            
            var valid_brand = false; 
            var valid_car_cost = false; // т.к. поля ещё не введины - поля не валидны (в самом начале)
            var valid_release_date = false;
            
            
            var brand = $('input[name=brand]');
            var car_cost = $('input[name=car_cost]');
            var release_date = $('input[name=release_date]');
            
            brand.blur(function()
            {
                var message = $('#brand_message');
                
                if(brand.val() == '')
                {
                    message.text('Введите марку!');
                    button.attr('disabled', true);
                    
                    valid_brand = false;
                }
                else if(!brand.val().match(/[а-яa-z]/i))
                {
                    message.text('В строке нет особого смысла!');
                    button.attr('disabled', true);
                    
                    valid_brand = false;
                }
                else
                {
                    message.text('');
                    
                    valid_brand = true;
                    
                    // если все поля валидны - включаем кнопку
                    if(valid_brand && valid_car_cost && valid_release_date) 
                    {
                        button.attr('disabled', false);
                    }
                }
            });
            
            car_cost.blur(function()
            {
                var message = $('#car_cost_message');
                
                if(car_cost.val() == '')
                {
                    message.text('Введите цену!');
                    button.attr('disabled', true);
                    
                    valid_car_cost = false;
                }
                else if(car_cost.val().match(/[^0-9]/)) // если нашли лишние символы
                {
                    message.text('В этой строке должны быть только цифры!');
                    button.attr('disabled', true);
                    
                    valid_car_cost = false;
                }
                else
                {
                    message.text('');
                    
                    valid_car_cost = true;
                    
                     // если все поля валидны - включаем кнопку
                    if(valid_brand && valid_car_cost && valid_release_date) 
                    {
                        button.attr('disabled', false);
                    }
                }
            });
            
            release_date.blur(function()
            {
                var message = $('#release_date_message');
                
                if(release_date.val() == '')
                {
                    message.text('Введите дату!');
                    button.attr('disabled', true);
                    
                    valid_release_date = false;
                }                                   
                else if(!release_date.val().match(/^[0-9]{2}.[0-9]{2}.[0-9]{4}$/))
                {
                    message.text("Нарушен синтаксис 'ДД.ММ.ГГГГ'!");
                    button.attr('disabled', true);
                    
                    valid_release_date = false;
                }
                else
                {
                    var day = release_date.val().substr(0,2); // вырезаем день, месяц, год (для обработки)
                    var month = release_date.val().substr(3,2);
                    var year = release_date.val().substr(6,4);
                    
                    if(day < 1 || day > 31)
                    {
                        message.text('Недопустимая дата!');
                        button.attr('disabled', true);
                        
                        valid_release_date = false;
                    }
                    else if(month < 1 || month > 12)
                    {
                        message.text('Недопустимый месяц!');
                        button.attr('disabled', true);
                        
                        valid_release_date = false;
                    }
                    else if(year < 2000 || year > 2021)
                    {
                        message.text('Недопустимый год!');
                        button.attr('disabled', true);
                        
                        valid_release_date = false;
                    }
                    else
                    {
                        message.text('');
                        
                        valid_release_date = true;
                        
                         // если все поля валидны - включаем кнопку
                        if(valid_brand && valid_car_cost && valid_release_date) 
                        {
                            button.attr('disabled', false);
                        }
                    }
                }
            });
            
            
        });

    </script>
    
</head>
    
<body>
<?php
    if(isset($_SESSION['id']) && $_SESSION['id'] == 1) // если это определённый пользователь (т.е. админ), тогда даём ему возможность добавить форму
    {
?>
    <div class="form_car">
        <h2>Добавление в Базу Авто</h2>
        <form action="add_car.php" method="post">
            <table>
                <tr>
                    <th>Марка :</th>
                    <th><input name="brand" type="text" placeholder="Марка авто" maxlength="64"></th>
                    <th><span id="brand_message" class="error_mesage"></span></th>
                </tr>
                <tr>
                    <th>Цена :</th>
                    <th><input name="car_cost" type="text" placeholder="Стоимость авто" maxlength="11"></th>
                    <th><span id="car_cost_message" class="error_mesage"></span></th>
                </tr>
                <tr>
                    <th>Выпуск :</th>
                    <th><input name="release_date" type="text" placeholder="ДД.ММ.ГГГГ" maxlength="10"></th>
                    <th><span id="release_date_message" class="error_mesage"></span></th>
                </tr>
            </table>
            <p>
            <input name="submit" type="submit" value="Добавить авто">
            </p>
        </form>
    </div>
<?php
    }
?>
   
    
    <div class="table">
        <h2>База Доступных Автомобилей</h2>
        <table>
            <tr><th class="name_car">Марка</th><th class="name_car">Цена</th><th class="name_car">Год выпуска</th></tr>
            <?php
                require_once("bdconnect.php");

                $mysqli->set_charset('utf8');
                $result_set = $mysqli->query("SELECT * FROM `car`"); //Вытаскиваем все комментарии для данной страницы

                while ($row = $result_set->fetch_assoc())
                {
                    echo '<tr><th>' . $row['brand'] . '</th><th>' . $row['car_cost'] . '</th><th>' . $row['release_date'] . '</th></tr>';
                }
            ?>
        </table>
    </div>
    
</body>