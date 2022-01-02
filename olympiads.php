<?php
require "connect.php";

if(isset($_POST['id'])) {
    
    $id = $_POST['id'];
    $query = "SELECT * FROM institutions WHERE global_id = '$id'";
    $result = mysqli_fetch_array(mysqli_query($link, $query));
    $title = $result['ShortName'];
    //-------------------------OLYMPIADS INFO--------------------------
    $query = "SELECT * FROM results WHERE ShortName = '$title'";
    $result = mysqli_query($link, $query);
    $olympiadsArr = array();
    while ($res = mysqli_fetch_array($result)) {
        $olymp = array("OlympiadType" => $res['OlympiadType'],
        "Subject" => $res['Subject'],
        "Status" => $res['Status'],
        "Class" => $res['Class'],
        "Year" => $res['Year']
        );
        array_push($olympiadsArr, $olymp);
    }
    echo(json_encode($olympiadsArr));
    //-----------------------------------------------------------------
} else {
    echo('no id');
}
?>