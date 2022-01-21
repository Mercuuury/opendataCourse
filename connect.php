<?php
    $db_host = '127.0.0.1';
    $db_user = 'root';
    $db_password = '';
    $database = 'course';
    $link = mysqli_connect($db_host, $db_user, $db_password, $database);
    if (!$link) {
        die("Cannot connect DB");
    }
?>