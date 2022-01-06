<?php

function getSuitesroom($collection_id){
    global $db;   
     
     $sql = "SELECT suitesrooms.*,property.* FROM suitesrooms INNER JOIN property ON suitesrooms.propertyid=property.id JOIN suitescollection ON suitescollection.propertyid=property.id   WHERE suitescollection.suitesid=:collection_id";
     
     $stmt = $db->prepare($sql);
     $stmt->execute([
        'collection_id' => $collection_id
    	]);
    	$result = $stmt->fetchAll(\PDO::FETCH_ASSOC);   
    	return $result;

}

$property_rooms = getSuitesroom($collection_id);

function ollPhotosByRoomId($roomId){
    global $db;

    $sql = "SELECT `photo_id` from `room_photos` WHERE room_id=:roomId ORDER BY displayorder ASC";

    $smtp = $db->prepare($sql);
    $smtp->execute([
        "roomId"  => $roomId,
    ]);
    $result = $smtp->fetchAll(\PDO::FETCH_ASSOC);
    return $result;
}
function getRoom_FacilityByRoom_Id2($id){
    global $db;

    $sql = "SELECT * FROM `room_facility` WHERE room_id=:id";

    $smtp = $db->prepare($sql);
    $smtp->execute([
        "id"  => $id,
    ]);
    $result = $smtp->fetchAll(\PDO::FETCH_ASSOC);
    return $result;
}

function getRoom_facility_typeByFacility_id($facility_id){
    global $db;

    $sql = "SELECT * FROM `room_facility_type` WHERE `facility_id`=:facility_id";

    $smtp = $db->prepare($sql);
    $smtp->execute([
        "facility_id"  => $facility_id,
    ]);
    $result = $smtp->fetchAll(\PDO::FETCH_ASSOC);
    return $result;
}

function getBigestUSPforRoomByRoom_id($room_id){
    global $db;
    
    
    $room_facilities = getRoom_FacilityByRoom_Id2($room_id);
    
    
    
    
    // tvyal room-i hamar bolor hasaneli facilities-ner@
    $room_facilities_data = [];
    foreach($room_facilities as $facility){  
        $room_facility_type = getRoom_facility_typeByFacility_id($facility['facility_id']);    
        array_push($room_facilities_data,$room_facility_type[0]);
    }
   
    foreach($room_facilities_data as $key => $facility){
        if($facility['usp_order'] == 0){
            unset($room_facilities_data[$key]);
        }
    }
    usort($room_facilities_data,function($a,$b){
        return $b['usp_order'] <=> $a['usp_order'];
    });
    
    //tvyal room-i hamar 3 amenamec ['usp_order'] unecox facilities-neri ['usp']-ner@
    $room_facilities_data_filtr = [];
    for($i=0;$i<3;$i++){
        if(isset($room_facilities_data[$i])){
            array_push($room_facilities_data_filtr,$room_facilities_data[$i]['usp']);
        }
    }
    return $room_facilities_data_filtr;
}







?>

<div style="width:100%; overflow:scroll;">
<table cellpadding=10>
    <tr>
        <th>image</th>
        <th>roomid</th>
        <th>propertyid</th>
        <th>naam</th>
        <th>big usp</th>
        <th>description</th>
        <th>id</th>
        <th>url</th>
        <th>priority</th>
        <th>address</th>
        <th>house_number</th>
        <th>postal_code</th>
        <th>city</th>
        <th>province</th>
        <th>stars</th>
        <th>number_of_rooms</th>
        <th>checkinfrom</th>
        <th>checkintill</th>
        <th>checkoutfrom</th>
        <th>checkouttill</th>
        <th>titel</th>
        <th>usp1</th>
        <th>usp2</th>
        <th>usp3</th>  
        <th>hoteltext</th>        
    </tr>
    <?php 
       
    foreach($property_rooms as $key => $val): 
        
       
          
    ?>
    <tr>
        <?php		
			$ollRoomsPhoto = ollPhotosByRoomId($val['roomid']);  
                 
		?>		
       <td>
            <div class="slideshow-container">
				<?php foreach($ollRoomsPhoto as $key1=>$val1): ?>
				    <div class="mySlides fade roomsId_<?php echo $key; ?>" style="display:<?php if($key1==0):?>block<?php else: ?>none<?php endif ?>">
				        <div class="numbertext"><?php echo $key1+1; ?> / <?php echo count($ollRoomsPhoto); ?></div>
				        <img src="https://www.hotels.nl/assets/images/rooms/<?= $val['roomid']."-".$val1['photo_id'] ?>.jpg" alt="">							
				    </div>
				<?php endforeach ?>	
				<input type="hidden" class="slid roomsNum<?php echo $key; ?>" value="<?php echo $key; ?>">
                <input type="hidden" class="slid photoCount<?php echo $key; ?>" value="<?php echo count($ollRoomsPhoto); ?>">
                <input type="hidden" class="slid showPhotoIndex<?php echo $key; ?>" value="1">							

				<a class="prev" data="<?php echo $key; ?>">&#10094;</a>
				<a class="next" data="<?php echo $key; ?>">&#10095;</a>

			</div>
       </td>
       <td><?php echo isset($val['roomid']) ? $val['roomid'] : '';  ?></td>      
       <td><?php echo isset($val['propertyid']) ? $val['propertyid'] : ''; ?></td>     
       <td><a href="/<?php echo isset($val['url']) ? $val['url'] : ''; ?>/"><?php echo isset($val['naam']) ? $val['naam'] : ''; ?></a></td>       
       <td><?php                
                $room_facilities_data_filtr = getBigestUSPforRoomByRoom_id($val['roomid']);   
                ?>
                <ol>
                <?php                
                 foreach($room_facilities_data_filtr as $usp): ?>
                      <li><?= $usp ?></li>
                <?php endforeach ?>
                </ol>
                <?php
       ?></td>
       <td><?php echo isset($val['description']) ? $val['description'] : '';  ?></td>     
       <td><?php echo isset($val['id']) ? $val['id'] : '';  ?></td>     
       <td><?php echo isset($val['url']) ? $val['url'] : '';  ?></td>     
       <td><?php echo isset($val['priority']) ? $val['priority'] : '';  ?></td>     
       <td><?php echo isset($val['address']) ? $val['address'] : '';  ?></td>     
       <td><?php echo isset($val['house_number']) ? $val['house_number'] : '';  ?></td>     
       <td><?php echo isset($val['postal_code']) ? $val['postal_code'] : '';  ?></td>     
       <td><?php echo isset($val['city']) ? $val['city'] : '';  ?></td>     
       <td><?php echo isset($val['province']) ? $val['province'] : '';  ?></td>     
       <td><?php echo isset($val['stars']) ? $val['stars'] : '';  ?></td>     
       <td><?php echo isset($val['number_of_rooms']) ? $val['number_of_rooms'] : '';  ?></td>    
       <td><?php echo isset($val['checkinfrom']) ? $val['checkinfrom'] : '';  ?></td>     
       <td><?php echo isset($val['checkintill']) ? $val['checkintill'] : '';  ?></td>     
       <td><?php echo isset($val['checkoutfrom']) ? $val['checkoutfrom'] : '';  ?></td>   
       <td><?php echo isset($val['checkouttill']) ? $val['checkouttill'] : '';  ?></td> 
       <td><?php echo isset($val['titel']) ? $val['titel'] : '';  ?></td>     
       <td><?php echo isset($val['usp1']) ? $val['usp1'] : '';  ?></td>     
       <td><?php echo isset($val['usp2']) ? $val['usp2'] : '';  ?></td>     
       <td><?php echo isset($val['usp3']) ? $val['usp3'] : '';  ?></td>
       <td><?php echo isset($val['hoteltext']) ? $val['hoteltext'] : '';  ?></td>
           
    </tr>   
    <?php endforeach ?>
</table>
</div>