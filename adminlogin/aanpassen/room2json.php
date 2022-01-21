<?php
session_start();
$_SESSION['DEBUG'] = False;
$today = date('Y-m-d');
if ($_SESSION['DEBUG']){
	echo '<p style="color: red">DEBUG on</p>';
	echo 'datum is: '.$today.'<br>';
}

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$servername = 'localhost';
$username = 'betterhotels';
$password = 'Csv9ZXepPVaeMVph';
$database = 'betterhotels';
$connect = [$servername, $username, $password, $database];
$_SESSION['connect'] = $connect;

if (isset($_POST['roomid'])) {
    $roomid = $_POST['roomid'];
    $roomname = getRoomName($roomid, $connect);
	
    $facilities = getRoomFacilities($roomid,$connect);

    $keysArray = array_merge(["uid","name","Roomname"], $facilities);
    $facilityArray = array_merge([$roomid,$roomname,$roomname], $facilities);

    $fullArray = array_combine($keysArray, $facilityArray);
	
    $file = fopen("room.json", "w");
    fwrite($file, json_encode($fullArray));
    fclose($file);
	
}

?>
Insert roomid
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <input type="number" name="roomid" value="roomid">
</form>

<?php


function getRoomName($id, $connect){
    $connectie = mysqli_connect($connect[0],$connect[1],$connect[2],$connect[3]);
    
    $query = 
            "SELECT naam
            FROM suitesrooms
            WHERE roomid=" . $id . "
            ";
    
    $result = mysqli_query($connectie, $query);
    
    $name = mysqli_fetch_assoc($result);

    return $name['naam'];

}

function getRoomFacilities($id, $connect){
    $connectie = mysqli_connect($connect[0],$connect[1],$connect[2],$connect[3]);
    
    $query = 
            "SELECT rft.facility_name
            FROM suitesrooms sr
            JOIN room_facility rf ON sr.roomid = rf.room_id
            JOIN room_facility_type rft ON rf.facility_id = rft.facility_id
            WHERE sr.roomid=" . $id . "
            AND rf.is_active=1
            ";
	
    $result = mysqli_query($connectie, $query);
    
    while ($row = mysqli_fetch_assoc($result)) {
        $facilities[] = $row['facility_name'];
    }
    
    if (!empty($facilities)) {
        return $facilities;
    }
}
?>