<?php
//--------------------------Настройки подключения к БД-----------------------
$db_host = '127.0.0.1';
$db_user = 'root'; //имя пользователя 
$db_password = ''; //пароль
$database = 'course'; //имя БД
$link = mysqli_connect($db_host, $db_user, $db_password, $database);
if ($link == False) {
    die("Cannot connect DB");
}
?>