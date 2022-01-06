<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!isset($db)) {
    include './include/db.php';
    $db = getdb();
}

$property_id = isset($_GET['property']) ? $_GET['property'] : "";
if(empty($property_id)){
    $property_id = isset($id) ? $id: $propertyid;
}

function getPropertyNameById($id){
     global $db;

     $sql = "SELECT `naam` from `property` WHERE id=:id";

     $smtp = $db->prepare($sql);
     $smtp->execute([
         "id"  => $id,
     ]);
     $result = $smtp->fetchAll(\PDO::FETCH_ASSOC);
     return $result;
}

$propertyName = getPropertyNameById($property_id);



function getPropertyByProperty_id($facilitiesTypes){

    global $db;

    $ids = [];

    foreach ($facilitiesTypes as $key => $value) {
       
       $ids[] = $value['facility_type_id'];
    }


    $ids = implode(', ',  $ids);


    $sql = "SELECT * FROM `facility_types` WHERE id IN ($ids)";

    $smtp = $db->prepare($sql);
    $smtp->execute([]);

    $result = $smtp->fetchAll(\PDO::FETCH_ASSOC);


    $facility_types = [];

    foreach ($facilitiesTypes as $key => $value) {
        
        foreach ($result as $key1 => $value1) {
            

            if ($value1['id'] == $value['facility_type_id'] ) {
                
               $facility_types[$value1['name_nl']][] = $value;
               break;

            }

        }

    }

    return $facility_types;

}

function getFacilitiesTypeByProporty_id($property_id){
    global $db;

    $sql = "SELECT `hotel_facilities`.id, `hotel_facilities`.`facility_id`, `facilities`.`facility_type_id`, `facilities`.`betterhotels_id`, `facilities`.name_nl  
            FROM `hotel_facilities` 
            JOIN `facilities` ON  `hotel_facilities`.`facility_id` = `facilities`.id
            WHERE `hotel_facilities`.`hotel_id` = :property_id ORDER BY `facilities`.facility_type_id";

    $smtp = $db->prepare($sql);
    $smtp->execute([
        "property_id"  => $property_id,
    ]);
    $result = $smtp->fetchAll(\PDO::FETCH_ASSOC);
    return $result;
}



$facilitiesTypes = getFacilitiesTypeByProporty_id($property_id);
$property = getPropertyByProperty_id($facilitiesTypes);


?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <?php
    //echo $propertyName[0]['naam'];
    ?>
    <style>
        .ind{
            text-indent:30px;
        }
    </style>    
    
    <?if(isset($_GET) && $_GET['property']!=""):?>
        <h1><?= $propertyName[0]['naam']; ?></h1> 


<?php foreach($property as $key => $val): ?>
    
    <div>
        <strong>
            <?= $key;?>
        </strong>
    </div>

    <?php foreach($val as $key2 => $val2): ?>

        <div class="ind">

            <?=$val2['name_nl']; ?>
                
        </div>

    <?php endforeach ?>

    <br>

<?php  endforeach ?>

<?endif?>
</body>
</html>



