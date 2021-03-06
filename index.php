<?php
require "connect.php";
$title = "Результаты олимпиад";
$fullName = "";
$type = "";
$address = "";
$website = "";
$email = "";
$phone = "";

if(isset($_GET['id']) && $_GET['id'] != 'undefined' && $_GET['id'] != '') {
    //----------------------------MAIN INFO----------------------------
    $id = $_GET['id'];
    $query = "SELECT * FROM institutions WHERE global_id = '$id'";
    $result = mysqli_fetch_array(mysqli_query($link, $query));
    $title = $result['ShortName'];
    $fullName = $result['FullName'];
    $type = mb_strtoupper(mb_substr($result['OrgType'], 0, 1, 'UTF-8'), 'UTF-8').mb_substr($result['OrgType'], 1, null, 'UTF-8');
    $address = $result['LegalAddress'];
    $website = $result['WebSite'];
    $email = preg_replace('/(Email:)/iu', '', $result['Email']);
    $phone = preg_replace('/(PublicPhone:)/iu', '', $result['PublicPhone']);
    //-----------------------------------------------------------------

    //------------------------------SORT-------------------------------
    // Olympiad type
    $query = "SELECT DISTINCT OlympiadType FROM results;";
    $result = mysqli_query($link, $query);
    $olympiad_types = '';
    while ($res = mysqli_fetch_array($result)) {
        $olympiad_types .= '
        <option value="'.$res['OlympiadType'].'">'.$res['OlympiadType'].'</option>
        ';
    }
    // Subjects
    $query = "SELECT DISTINCT Subject FROM results WHERE ShortName = '$title' ORDER BY Subject ASC;";
    $result = mysqli_query($link, $query);
    $subjects = '';
    while ($res = mysqli_fetch_array($result)) {
        $subjects .= '
        <option value="'.$res['Subject'].'">'.$res['Subject'].'</option>
        ';
    }
    // Classes
    $query = "SELECT DISTINCT Class FROM results WHERE ShortName = '$title' ORDER BY Class ASC;";
    $result = mysqli_query($link, $query);
    $classes = '';
    while ($res = mysqli_fetch_array($result)) {
        $classes .= '
        <option value="'.$res['Class'].'">'.$res['Class'].'</option>
        ';
    }
    // Years
    $query = "SELECT DISTINCT Year FROM results WHERE ShortName = '$title' ORDER BY Year ASC;";
    $result = mysqli_query($link, $query);
    $years = '';
    while ($res = mysqli_fetch_array($result)) {
        $years .= '
        <option value="'.$res['Year'].'">'.$res['Year'].'</option>
        ';
    }
}

require "template.php";
?>