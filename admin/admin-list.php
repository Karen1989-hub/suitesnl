<?php
// include realpath(__DIR__ . '/..').'/server.php';
// $server    = new Server();

if(!isset($db)){
    include '../include/db.php';
    $db = getdb();
}

function getPropertyByUPId(){
    global $db;

    $id = $_GET['id'];
    $sql = "SELECT id, naam,usp1,usp2,usp3,hoteltext, url  FROM `property` where `id` = :id " ;

    $stmt = $db->prepare($sql); 
    $stmt->execute([
        "id"  => $id,
    ]);  
        
    $dataDable = $stmt->fetchAll(\PDO::FETCH_ASSOC);  

    return $dataDable;
}


$data =  getPropertyByUPId();

$id = $data[0]['id'];
$name = $data[0]['naam'];
$url = $data[0]['url'];
$usp1 = $data[0]['usp1'];
$usp2 = $data[0]['usp2'];
$usp3 = $data[0]['usp3'];
$hoteltext = $data[0]['hoteltext'] ?? '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<style>
    form{
        max-width:500px;
        width: 100%;
        display:flex;
        flex-direction:column;
        margin:auto;
        align-items:center
    }

    form>input{
        margin-bottom: 15px;
    }

</style>
<body>

<?php echo $name ?>

    <form action="/request.php" method="post">
        <input type="hidden" name="method" value="update">
        <?php foreach($data as $key) :?>
            <input type="hidden"  name="id" value="<?php echo $id ?>">
            <input type="text" id="d1" name="usp1" value="<?php echo $usp1 ?>" placeholder="usp1">
            <input type="text" name="usp2" value="<?php echo $usp2 ?>" placeholder="usp2">
            <input type="text" name="usp3" value="<?php echo $usp3 ?>" placeholder="usp3">
            <textarea name="hoteltext"  cols="151" rows="30"><?php echo $hoteltext ?></textarea>
        <?php endforeach?>
        <button>Update</button>    
    </form>

    <script src="../assets/scripts/main.js"></script>
</body>
</html>