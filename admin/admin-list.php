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
<style>
* {box-sizing: border-box}
body {font-family: Verdana, sans-serif; margin:0}
.mySlides {display: none}
img {vertical-align: middle;}

/* Slideshow container */
.slideshow-container {
  max-width: 1000px;
  position: relative;
  margin: auto;
}

/* Next & previous buttons */
.prev, .next {
  cursor: pointer;
  position: absolute;
  top: 50%;
  width: auto;
  padding: 16px;
  margin-top: -22px;
  color: white;
  font-weight: bold;
  font-size: 18px;
  transition: 0.6s ease;
  border-radius: 0 3px 3px 0;
  user-select: none;
  background: #322d2c7d;
}

/* Position the "next button" to the right */
.next {
  right: 0;
  border-radius: 3px 0 0 3px;
}

/* On hover, add a black background color with a little bit see-through */
.prev:hover, .next:hover {
  background-color: rgba(0,0,0,0.8);
}
.prev{
    left:0;
}

/* Caption text */
.text {
  color: #f2f2f2;
  font-size: 15px;
  padding: 8px 12px;
  position: absolute;
  bottom: 8px;
  width: 100%;
  text-align: center;
  
}

/* Number text (1/3 etc) */
.numbertext {
  color: #f2f2f2;
  font-size: 12px;
  padding: 8px 12px;
  position: absolute;
  top: 0;
}

/* The dots/bullets/indicators */
.dot {
  cursor: pointer;
  height: 15px;
  width: 15px;
  margin: 0 2px;
  background-color: #bbb;
  border-radius: 50%;
  display: inline-block;
  transition: background-color 0.6s ease;
}

.active, .dot:hover {
  background-color: #717171;
}

/* Fading animation */
.fade {
  -webkit-animation-name: fade;
  -webkit-animation-duration: 1.5s;
  animation-name: fade;
  animation-duration: 1.5s;
}

@-webkit-keyframes fade {
  from {opacity: .4} 
  to {opacity: 1}
}

@keyframes fade {
  from {opacity: .4} 
  to {opacity: 1}
}

/* On smaller screens, decrease text size */
@media only screen and (max-width: 300px) {
  .prev, .next,.text {font-size: 11px}
}

.d1{
    width:80%;
}
</style>
<body>
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


<a href="https://www.google.nl/search?q=<?php echo $name ?>" target="blank"><?php echo $name ?></a>

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


   <?php
    $arrival    =  isset($cookie['arrival']) ? $cookie['arrival'] : "";
    $departure  =  isset($cookie['departure']) ? $cookie['departure'] : "";

    if($arrival !== "" && $departure !== "") {
    
    $hotel_id = $id ;
    include '../include/havearrival.php';

    }else{        
     $propertyid = $id ;            
    include '../include/noarrival.php';
    }   

    include "../facilities.php";
   ?>
    <script src="../assets/scripts/main.js"></script>
</body>
</html>