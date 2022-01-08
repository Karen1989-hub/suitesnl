<h2>Show rates </h2>
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!isset($db)) {
    include './include/db.php';
    $db = getdb();
}

function GetCookie(){    
    $cookie2 = [];  
    $cookie  = isset($_COOKIE["arrival"]) ? $_COOKIE["arrival"] : []; 
    if(!empty($cookie)){ 
     $cookie2 = unserialize($cookie); 
    }   
    return $cookie2; 
 } 
$cookie = GetCookie();
 
$arrival    =  isset($cookie['arrival']) ? $cookie['arrival'] : "";
$departure  =  isset($cookie['departure']) ? $cookie['departure'] : "";
$room_id = $_GET['room_id'];

function getRatesByRoomId($room_id){
    global $db;

    $sql = "SELECT room_facility_type.* FROM `room_facility` INNER JOIN room_facility_type 
    ON room_facility.facility_id=room_facility_type.facility_id WHERE room_id=:room_id and room_facility_type.usp_order>0 
    ORDER BY room_facility_type.usp_order ASC";
    $smtp = $db->prepare($sql);
    $smtp->execute([
    "room_id"  => $room_id,
    ]);
    $result = $smtp->fetchAll(\PDO::FETCH_ASSOC);
    return $result;

}

//all rates
$rates = getRatesByRoomId($room_id);
if(!empty($rates)){
    echo "<pre>";
    print_r($rates);
}


function getPropertyIdByRoomId($room_id){
    global $db;

    $sql = "SELECT suitesrooms.propertyid FROM suitesrooms WHERE roomid=:room_id";
    $smtp = $db->prepare($sql);
    $smtp->execute([
    "room_id"  => $room_id,
    ]);
    $result = $smtp->fetchAll(\PDO::FETCH_ASSOC);
    return $result[0]['propertyid'];
}

//propertyId for this room
$propertyId = getPropertyIdByRoomId($room_id);
 //echo "<pre>";
 //print_r($propertyId);

 function getJsonAboutHotel($propertyId,$arrival,$departure){
    $type = 'hotel';

	$ch = curl_init("https://search-av.hotels.nl/?id=".$propertyId."&type=".$type."&arrival=".$arrival."&departure=".$departure);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);

	$json = curl_exec($ch);
	curl_close($ch);	

	$json = json_decode($json);
    return $json;
 }
 
//echo $arrival,$departure,$propertyId;
$getJsonAboutHotel = getJsonAboutHotel($propertyId,$arrival,$departure)->hotels[0]->room_ratetype;

if(!empty($getJsonAboutHotel)){
    foreach($getJsonAboutHotel as $key => $val){
        if($val->room_id != $room_id){
           unset($getJsonAboutHotel[$key]);
        }
    }
}
// echo "<pre>";
// print_r($getJsonAboutHotel);die;

$allApiRatesForThisRoom = [];
if(!empty($getJsonAboutHotel)){
    foreach($getJsonAboutHotel as $room){       
        array_push($allApiRatesForThisRoom,$room->persons); 
    }
}
 
//  echo "<pre>";
//  var_dump($allApiRatesForThisRoom);die;


?>
<h2>All rates for this room (xml)</h2>
<?php
foreach($allApiRatesForThisRoom as $value){           
   foreach($value as $val){
       echo "<pre>";
       print_r($val);
   }
}
 



?>


