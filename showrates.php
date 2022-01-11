<?php
//es ejin dimelu orinak//https://suites.nl/showrates.php?room_id=1019&arrival=2022-04-28&departure=2022-04-30
?>


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
 
//$arrival    =  isset($cookie['arrival']) ? $cookie['arrival'] : "";
//$departure  =  isset($cookie['departure']) ? $cookie['departure'] : "";
$arrival = $_GET['arrival'];
$departure = $_GET['departure'];

$room_id = $_GET['room_id'];

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


 if(empty($propertyId)){
    echo "have not this room_id";die;
 }


 function getJsonAboutHotel($propertyId,$arrival,$departure){
    $type = 'hotel';

	$ch = curl_init("https://search-av.hotels.nl/?id=".$propertyId."&type=".$type."&arrival=".$arrival."&departure=".$departure);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);

	$json = curl_exec($ch);
	curl_close($ch);	

	$json = json_decode($json);
    return $json;
 } 

$getJsonAboutHotel = getJsonAboutHotel($propertyId,$arrival,$departure)->hotels[0]->room_ratetype;

if(!empty($getJsonAboutHotel)){
    foreach($getJsonAboutHotel as $key => $val){
        if($val->room_id != $room_id){
           unset($getJsonAboutHotel[$key]);
        }
    }
}

if(empty($getJsonAboutHotel)){
    echo "this room is not available on this date";die;
} 
?>
<hr>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
           .table_content{
                overflow-x: auto;
                max-width: 1200px;
                width: 100%;
            }
            table tbody tr td{
                border: 1px dashed silver; 
                padding: 5px;
                text-align:center;
		    }
            td img{
                max-width: 500px;
            }  
   
            table {
                width: 100%;
            }
  
    </style>
</head>
<body>

<h2>All rates for this room (xml)</h2>
<div style="width:100%; overflow:scroll;">


<table cellspacing=10>    
    <tr>
        <th>rate_type_id</th>
        <th>room_rate_type_id</th>     

        <th>min_price</th>
        <th>max_price</th>
        <th>min_stay_price</th>
        <th>min_numpersons</th>
        <th>max_persons</th>
        <th>min_stay</th>
        <th>additionalCostInfo</th>
        <th>citytax_included</th>    
        <th>citytax_type</th>
        <th>citytax</th>       
        <th>hasServiceCost</th>
        <!-- persons >> -->
        <th>total price</th>
        <th>total period price</th>
        <th>amount_of_rooms</th>
        <th>min_price_per_night</th>
        <th>raw_price</th>
        <th>days</th>   
        <!-- << persons -->     
        <th>rate_type_min_stay</th>
        <th>rate_type_max_stay</th>  
        <th>typeDescription</th>
        <th>actionDescription</th>        
        <th>cancellation_timestamp</th>
        <th>cancelation</th>
        <th>rate_type_name_default</th>
        <th>has_dinner</th>
        <th>breakfast_included</th>        
    </tr>
    <?php
        foreach($getJsonAboutHotel as $roomRateType):
    ?>
    <tr>
        <td><?php echo isset($roomRateType->rate_type_id)  ? $roomRateType->rate_type_id : ''; ?></td>
        <td><?php echo isset($roomRateType->room_rate_type_id)  ? $roomRateType->room_rate_type_id : '';?></td>
        <td><?php echo isset($roomRateType->min_price)  ? $roomRateType->min_price : ''; ?></td>
        <td><?php echo isset($roomRateType->max_price)  ? $roomRateType->max_price : ''; ?></td>
        <td><?php echo isset($roomRateType->min_stay_price)  ? $roomRateType->min_stay_price : ''; ?></td>
        <td><?php echo isset($roomRateType->min_numpersons)  ? $roomRateType->min_numpersons : ''; ?></td>
        <td><?php echo isset($roomRateType->max_persons)  ? $roomRateType->max_persons : ''; ?></td>
        <td><?php echo isset($roomRateType->min_stay)  ? $roomRateType->min_stay : ''; ?></td>
        <td><?php echo isset($roomRateType->additionalCostInfo)  ? $roomRateType->additionalCostInfo : ''; ?></td>
        <td><?php echo isset($roomRateType->citytax_included)  ? $roomRateType->citytax_included : ''; ?></td>
        <td><?php echo isset($roomRateType->citytax_type)  ? $roomRateType->citytax_type : ''; ?></td>
        <td><?php echo isset($roomRateType->citytax)  ? $roomRateType->citytax : ''; ?></td>
        <td><?php echo isset($roomRateType->hasServiceCost)  ? $roomRateType->hasServiceCost : ''; ?></td>      
        <td><?php   
            foreach($roomRateType->persons as $persons){       
                  echo isset($persons->total_price)  ? $persons->total_price : '';      
            } ?>
        </td>
        <td><?php  
            foreach($roomRateType->persons as $persons){       
                  echo isset($persons->total_period_price)  ? $persons->total_period_price : '';
            } ?>
        </td>
        <td><?php  
            foreach($roomRateType->persons as $persons){       
                  echo isset($persons->amount_of_rooms)  ? $persons->amount_of_rooms : '';
            } ?>
        </td>
        <td><?php  
            foreach($roomRateType->persons as $persons){       
                  echo isset($persons->min_price_per_night)  ? $persons->min_price_per_night : '';
            } ?>
        </td>
        <td><?php  
            foreach($roomRateType->persons as $persons){       
                  echo isset($persons->raw_price)  ? $persons->raw_price : '';
            } ?>
        </td>
        <td><?php  
            foreach($roomRateType->persons as $persons){       
                  echo isset($persons->days)  ? $persons->days : '';
            } ?>
        </td>
        <td><?php echo isset($roomRateType->rate_type_min_stay) ? $roomRateType->rate_type_min_stay : ''; ?></td>
        <td><?php echo isset($roomRateType->rate_type_max_stay) ? $roomRateType->rate_type_max_stay : ''; ?></td>        
        <td><?php echo isset($roomRateType->cancel_policy->typeDescription)  ? $roomRateType->cancel_policy->typeDescription : ''; ?></td>
        <td><?php echo isset($roomRateType->cancel_policy->actionDescription)  ? $roomRateType->cancel_policy->actionDescription : ''; ?></td>
        <td><?php echo isset($roomRateType->cancellation_timestamp)  ? $roomRateType->cancellation_timestamp : ''; ?></td>
        <td><?php echo isset($roomRateType->cancelation)  ? $roomRateType->cancelation : ''; ?></td>
        <td><?php echo isset($roomRateType->rate_type_name_default)  ? $roomRateType->rate_type_name_default : ''; ?></td>
        <td><?php echo isset($roomRateType->has_dinner)  ? $roomRateType->has_dinner : ''; ?></td>
        <td><?php echo isset($roomRateType->breakfast_included)  ? $roomRateType->breakfast_included : ''; ?></td>      
    </tr>
    <?php
        endforeach
    ?>
</table>
</div>
</body>
</html>




