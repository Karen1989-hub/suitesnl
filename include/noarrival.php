
<?php

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);


//session_start();

if(!isset($db)){
    include 'include/db.php';
    $db = getdb();
} 

$data = [];

function getPropertyByPropertyid($propertyid){
    global $db;

    $sql = "SELECT suitesrooms.* FROM suitesrooms INNER JOIN property ON suitesrooms.propertyid = property.id WHERE suitesrooms.propertyid = :propertyid";

    $smtp = $db->prepare($sql);
    $smtp->execute([
        "propertyid"  => $propertyid,
    ]);
    $result = $smtp->fetchAll(\PDO::FETCH_ASSOC);
    return $result;
}

function ollPhotosByRoomId($roomId){
    global $db;

    $sql = "SELECT `photo_id` from `room_photos` WHERE room_id=:roomId";

    $smtp = $db->prepare($sql);
    $smtp->execute([
        "roomId"  => $roomId,
    ]);
    $result = $smtp->fetchAll(\PDO::FETCH_ASSOC);
    return $result;
}

if($propertyid !== 0){
    $data = getPropertyByPropertyid($propertyid);    
    // echo "<pre>";
    // print_r($data);          
    
} 


?>



<?php if(!empty($data)): ?>
    <table>
        <tr>
            <th>roomid</th>
            <th>propertyid</th>
            <th>naam</th>
            <th>description</th>
                
        </tr>
        <?php foreach($data as $val):?>
        <tr>
            <?php $ollRoomPhotos = ollPhotosByRoomId($val['roomid']); ?>
            <td>
                <?php
                    foreach($ollRoomPhotos as $val1){
                        //var_dump($val['roomid']);
                        ?>
                        <img src="https://www.hotels.nl/assets/images/rooms/<?php echo isset($val['roomid'])  ? $val['roomid'] : '';  ?>-<?= $val1["photo_id"] ?>.jpg">
                        <?php
                    }
                    
                ?>
            </td>
            
            <td><?php echo isset($val['propertyid'])  ? $val['propertyid'] : '';  ?></td>
            <td><?php echo isset($val['naam'])  ? $val['naam'] : '';  ?></td>
            <td><?php echo isset($val['description'])  ? $val['description'] : '';  ?></td>
            
            
        </tr>        
				
        <?php endforeach; ?>        
    </table>
    
    
<?php endif; ?>