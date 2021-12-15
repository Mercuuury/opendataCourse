<?php
require "connect.php";
$title = "Курсовой проект";
$fullName = "";
$type = "";
$address = "";
$website = "";
$email = "";
$phone = "";

if(isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM institutions WHERE global_id = '$id'";
    $result = mysqli_fetch_array(mysqli_query($link, $query));
    $title = $result['ShortName'];
    $fullName = $result['FullName'];
    $type = $result['OrgType'];
    $address = $result['LegalAddress'];
    $website = $result['WebSite'];
    $email = $result['Email'];
    $phone = $result['PublicPhone'];
}

require "template.php";
?>