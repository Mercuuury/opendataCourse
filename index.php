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

    //-------------------------OLYMPIADS INFO--------------------------
    $query = "SELECT * FROM results WHERE ShortName = '$title'";
    $result = mysqli_query($link, $query);
    $olympiads = "";
    $i = 0;
    $olympiadsArr = array();
    while ($res = mysqli_fetch_array($result)) {
        if ($i % 2 == 0) {
            $olympiads .= '<div class="row">';
        }
        $olymp = array("OlympiadType" => $res['OlympiadType'],
        "Subject" => $res['Subject'],
        "Status" => $res['Status'],
        "Class" => $res['Class'],
        "Year" => $res['Year']);
        array_push($olympiadsArr, $olymp);
        $olympiads .= '
        <div class="col-sm-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-center">'.$res['OlympiadType'].'</h5>
                    <ul class="list-group list-group-flush">';
        if ($res['Status'] == 'призёр') {
            $olympiads .= '<li class="list-group-item"><img src="source/podium.png" alt="Победитель"> Призер</li>';
        } else {
            $olympiads .= '<li class="list-group-item"><img src="source/trophy.png" alt="Победитель"> Победитель</li>';
        }
        $olympiads .= ' 
                        <li class="list-group-item"><img src="source/bookmark.png" alt="Предмет"> '.$res['Subject'].'</li>
                        <li class="list-group-item"><img src="source/graduated.png" alt="Класс"> '.$res['Class'].' класс</li>
                        <li class="list-group-item"><img src="source/calendar.png" alt="Год"> '.$res['Year'].'</li>
                    </ul>
                </div>
            </div>
        </div>
        ';

        if ($i % 2 != 0) {
            $olympiads .= '</div>';
        }
        $i++;
    }
    $json = json_encode($olympiadsArr);
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
<script>
    console.log(JSON.parse('<?php echo $json; ?>'));
</script>