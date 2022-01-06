<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

$propertyid = $_GET['room_id'];
//echo $propertyid;

if(!isset($db)){
    include '../include/db.php';
    $db = getdb();
} 

$method = $_REQUEST['method'] ?? '';
if($method == 'updateSuitesrooms'){
    updateSuitesrooms($propertyid); 
}

$data = [];

function getPropertyByPropertyid($propertyid){
    global $db;

    $sql = "SELECT suitesrooms.* FROM suitesrooms INNER JOIN property ON suitesrooms.propertyid = property.id WHERE suitesrooms.roomid = :propertyid";

    $smtp = $db->prepare($sql);
    $smtp->execute([
        "propertyid"  => $propertyid,
    ]);
    $result = $smtp->fetchAll(\PDO::FETCH_ASSOC);
    return $result;
}
$suitesrooms = getPropertyByPropertyid($propertyid);

function updateSuitesrooms($id){
    global $db;
    
    $usp1 = $_POST['usp1'];
    $usp2 = $_POST['usp2'];
    $usp3 = $_POST['usp3'];
    $description = $_POST['description'];      

    $sql = "UPDATE `suitesrooms` SET `usp1`='$usp1',`usp2`='$usp2',`usp3`='$usp3',`description`= '$description'  WHERE `roomid` =  :id" ;

    $stmt = $db->prepare($sql); 
    $stmt->execute([
        "id"  => $id,
    ]);  
        
    $dataDable = $stmt->fetchAll(\PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <style>
        .suitesroomsUpdateForm{
            width:30%;            
            margin:0 auto;
            text-align:center;
        }
        input{
            margin: 0 10px 10px 10px;
        }
        h2{
            text-align:center;
        }
    </style>
    <h2>Update suitesrooms</h2>
    <form action="" class="suitesroomsUpdateForm" method="post">
        <input type="hidden" name="method" value="updateSuitesrooms" >
        <label for="">usp1</label><br>
        <input type="text" name="usp1" value="<?php echo isset($suitesrooms[0]['usp1']) ? $suitesrooms[0]['usp1'] : ""; ?>"><br>
        <label for="">usp2</label><br>
        <input type="text" name="usp2" value="<?php echo isset($suitesrooms[0]['usp2']) ? $suitesrooms[0]['usp2'] : ""; ?>"><br>
        <label for="">usp3</label><br>
        <input type="text" name="usp3" value="<?php echo isset($suitesrooms[0]['usp3']) ? $suitesrooms[0]['usp3'] : ""; ?>"><br> 
        <label for="">description</label>  <br>     
        <textarea name="description" id="" cols="30" rows="10"><?php echo isset($suitesrooms[0]['description']) ? $suitesrooms[0]['description'] : ""; ?></textarea><br>
        <input type="submit" value="update"><br>
        <a href=""></a>
    </form>
    
</body>
</html>