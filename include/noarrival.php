
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

    $sql = "SELECT `photo_id` from `room_photos` WHERE room_id=:roomId ORDER BY displayorder ASC";

    $smtp = $db->prepare($sql);
    $smtp->execute([
        "roomId"  => $roomId,
    ]);
    $result = $smtp->fetchAll(\PDO::FETCH_ASSOC);
    return $result;
}

if($propertyid !== 0){
    $data1 = getPropertyByPropertyid($propertyid);
} 
?>

<?php if(!empty($data1)): ?> 
    <table>
        <tr>
            <th>image</th>
            <th>propertyid</th>
            <th>naam</th>
            <th>description</th>
            <th>usp1</th>
            <th>usp2</th>
            <th>usp3</th>                
        </tr>       
        <?php foreach($data1 as $key => $val):?>
        <tr>          
            <?php $ollRoomPhotos = ollPhotosByRoomId($val['roomid']); ?>          
            <td style="width:37%">
            <?php if(!empty($ollRoomPhotos)): ?>
                <div class="slideshow-container">
					<?php foreach($ollRoomPhotos as $key1=>$val1): ?>
					<div class="mySlides fade roomsId_<?php echo $key; ?>" style="display:<?php if($key1==0):?>block<?php else: ?>none<?php endif ?>">
					<div class="numbertext"><?php echo $key1+1; ?> / <?php echo count($ollRoomPhotos); ?></div>
					<img src="https://www.hotels.nl/assets/images/rooms/<?php echo isset($val['roomid'])  ? $val['roomid'] : '';  ?>-<?= $val1["photo_id"] ?>.jpg">						
					</div>
					<?php endforeach ?>								
                    <input type="hidden" class="slid roomsNum<?php echo $key; ?>" value="<?php echo $key; ?>">
                    <input type="hidden" class="slid photoCount<?php echo $key; ?>" value="<?php echo count($ollRoomPhotos); ?>">
                    <input type="hidden" class="slid showPhotoIndex<?php echo $key; ?>" value="1">

					<a class="prev" data="<?php echo $key; ?>">&#10094;</a>
					<a class="next" data="<?php echo $key; ?>">&#10095;</a>
				</div>
            <?php endif ?>    
            </td>            
            <td><?php echo isset($val['propertyid'])  ? $val['propertyid'] : '';  ?></td>
            <td><?php echo isset($val['naam'])  ? $val['naam'] : '';  ?></td>
            <td><?php echo isset($val['description'])  ? $val['description'] : '';  ?></td>
            <td><?php echo isset($val['usp1'])  ? $val['usp1'] : '';  ?></td>
            <td><?php echo isset($val['usp2'])  ? $val['usp2'] : '';  ?></td>
            <td><?php echo isset($val['usp3'])  ? $val['usp3'] : '';  ?></td>
            <td>                
                <a href="update_suitesrooms.php?room_id=<?php echo $val['roomid']; ?>">Edit</a>
            </td>        
        </tr>      
		<?php endforeach; ?>        
    </table>   
<?php endif; ?>