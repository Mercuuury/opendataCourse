<?php
require "connect.php";

if (isset($_POST['search'])) {
    $searchShortName = $_POST['search'];
    $query = "SELECT ShortName, global_id FROM institutions WHERE ShortName LIKE '%$searchShortName%' LIMIT 5";
    $result = mysqli_query($link, $query);
    
    while ($row = mysqli_fetch_array($result)) {
        $shortName = $row['ShortName'];
        $highlighted = preg_replace('/('.$searchShortName.')/iu', '<strong>'.mb_strtoupper($searchShortName).'</strong>', $shortName);

        echo "
        <div onclick='fill(\"".$shortName."\")' data-id='".$row['global_id']."'>
            ".$highlighted."
        </div>
        ";
    }
}
?>
