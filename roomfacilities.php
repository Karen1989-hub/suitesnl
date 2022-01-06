<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!isset($db)) {
    include './include/db.php';
    $db = getdb();
}

$room_id = isset($_GET['room_id']) ? $_GET['room_id'] : "";

function getRoom_FacilityByRoom_Id($id){
    global $db;

    $sql = "SELECT * FROM `room_facility` WHERE room_id=:id";

    $smtp = $db->prepare($sql);
    $smtp->execute([
        "id"  => $id,
    ]);
    $result = $smtp->fetchAll(\PDO::FETCH_ASSOC);
    return $result;

}

$room_facilities = getRoom_FacilityByRoom_Id($room_id);

function getRoom_facility_typeByFacility_id($facility_id){
    global $db;

    $sql = "SELECT * FROM `room_facility_type` WHERE facility_id=:facility_id";

    $smtp = $db->prepare($sql);
    $smtp->execute([
        "facility_id"  => $facility_id,
    ]);
    $result = $smtp->fetchAll(\PDO::FETCH_ASSOC);
    return $result;
}

?>

<h2>Room_facility</h2>

<?php foreach($room_facilities as $facility): ?>    
    <?php 
    $room_facility_type = getRoom_facility_typeByFacility_id($facility['facility_id']);  
    foreach($room_facility_type as $facility_name):
    ?>
    <p><?php print_r($facility_name['facility_name']); ?></p>
    <?php endforeach ?>    
<?php endforeach ?>     