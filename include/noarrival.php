
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
            <td><img src="https://www.hotels.nl/assets/images/rooms/<?php echo isset($val['roomid'])  ? $val['roomid'] : '';  ?>-1.jpg"></td>
            <td><?php echo isset($val['propertyid'])  ? $val['propertyid'] : '';  ?></td>
            <td><?php echo isset($val['naam'])  ? $val['naam'] : '';  ?></td>
            <td><?php echo isset($val['description'])  ? $val['description'] : '';  ?></td>
            
            
        </tr>        
				
        <?php endforeach; ?>        
    </table>
    
    
<?php endif; ?>