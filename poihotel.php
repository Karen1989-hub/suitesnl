<!-- SELECT poi.id,
        poi.name,
        poi.lat, poi.lon,
        p.distance_unit
                 * DEGREES(ACOS(LEAST(1.0, COS(RADIANS(p.latpoint))
                 * COS(RADIANS(poi.lat))
                 * COS(RADIANS(p.longpoint) - RADIANS(poi.lon))
                 + SIN(RADIANS(p.latpoint))
                 * SIN(RADIANS(poi.lat))))) AS distance_in_km
  FROM poi
  JOIN (   /* these are the query parameters */
        SELECT  property.lat  AS latpoint,  property.lon AS longpoint,
                10.0 AS radius,      111.045 AS distance_unit
      FROM property
      WHERE property.id = 11
    ) AS p ON 1=1
  WHERE poi.lat
     BETWEEN p.latpoint  - (p.radius / p.distance_unit)
         AND p.latpoint  + (p.radius / p.distance_unit)
    AND poi.lon
     BETWEEN p.longpoint - (p.radius / (p.distance_unit * COS(RADIANS(p.latpoint))))
         AND p.longpoint + (p.radius / (p.distance_unit * COS(RADIANS(p.latpoint))))
    AND poi.type = 'restaurant'
  ORDER BY distance_in_km
  LIMIT 10 -->

<h2>insert poihotel</h2>
<?php
die;
if (!isset($db)) {
    include './include/db.php';
    $db = getdb();
}
//die;
//111.045
$types = ['restaurant','bar','cafe','fast_food','university','museum','arts_centre','atm','bicycle_rental','boat_rental','car_rental','casino',
'charging_station','cinema','conference_centre','hospital','marketplace','parking_entrance','theatre','attraction','gallery',
'theme_park','zoo','information','parking'];

function getPropertyEndPoiDistance($id,$type){
    global $db;

    $sql = "SELECT poi.id,
    poi.name,
    poi.lat, poi.lon,
    poi.type,
    p.distance_unit
             * DEGREES(ACOS(LEAST(1.0, COS(RADIANS(p.latpoint))
             * COS(RADIANS(poi.lat))
             * COS(RADIANS(p.longpoint) - RADIANS(poi.lon))
             + SIN(RADIANS(p.latpoint))
             * SIN(RADIANS(poi.lat))))) AS distance_in_km
FROM poi
JOIN (   /* these are the query parameters */
    SELECT  property.lat  AS latpoint,  property.lon AS longpoint,
            25.0 AS radius,      111.045 AS distance_unit
  FROM property
  WHERE property.id = :id
) AS p ON 1=1
WHERE poi.lat
 BETWEEN p.latpoint  - (p.radius / p.distance_unit)
     AND p.latpoint  + (p.radius / p.distance_unit)
AND poi.lon
 BETWEEN p.longpoint - (p.radius / (p.distance_unit * COS(RADIANS(p.latpoint))))
     AND p.longpoint + (p.radius / (p.distance_unit * COS(RADIANS(p.latpoint))))
AND poi.type = :type
ORDER BY distance_in_km
LIMIT 10";

$stmt = $db->prepare($sql);
$stmt->execute([
     "id" => $id,
    "type" => $type
]);
    	$result = $stmt->fetchAll(\PDO::FETCH_ASSOC);   
    	return $result;
}

// $poies =  getPropertyEndPoiDistance(11,'restaurant');

// echo "<pre>";
// print_r($poies);
// die;


function getAllProperty(){
    global $db;

    $sql = "SELECT * from `property`";

    $stmt = $db->prepare($sql);
    $stmt->execute([
   
    ]);
    	$result = $stmt->fetchAll(\PDO::FETCH_ASSOC);   
    	return $result;
}

$allPropertes = getAllProperty();

//echo "<pre>";
//print_r($allPropertes);
//die;

$insertStartNum = 0;
 if(isset($_COOKIE['insertStartNum'])){
    $insertStartNum = $_COOKIE['insertStartNum'];
 }
 
setcookie("insertStartNum",$insertStartNum+1,time()+86400,"/");
//die;
$property_id = $allPropertes[$insertStartNum]['id'];


function insertIntoPoiHotel($propertyid,$poiid,$distance,$poitype){
    global $db;     
    
     
     $sql = "INSERT INTO `poihotel`(propertyid,poiid,distance,poitype) VALUES('$propertyid','$poiid','$distance','$poitype')";
        //echo $sql;
      $stmt = $db->prepare($sql);
      $stmt->execute([
         
      ]);    
 }

 foreach($types as $type){
     //echo "<br>";
     //echo $type;
     
    $poiesNearProperty = getPropertyEndPoiDistance($property_id,$type);
    //echo "<pre>";
    //print_r($poiesNearProperty);

    foreach($poiesNearProperty as $val){
        $distance = (floor(($val['distance_in_km'])*100))/100;


       insertIntoPoiHotel($property_id,$val['id'],$distance,$val['type']);
    }
 }
 


if($insertStartNum<471){
     header("Refresh:0");
}




// foreach($allPropertes as $property){
//     echo "<br>";
//     //echo $property['id']."<br>";
//     $poiesNear = getPropertyEndPoiDistance($property['id']);
//     print_r($poiesNear);
    
// }