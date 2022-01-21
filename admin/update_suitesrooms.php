<?php
//tvyal ejin dimelu orinak//https://suites.nl/admin/update_suitesrooms.php?room_id=16987


ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

$room_id = $_GET['room_id'];
//echo $propertyid;

if(!isset($db)){
    include '../include/db.php';
    $db = getdb();
} 

$method = $_REQUEST['method'] ?? '';
if($method == 'updateSuitesrooms'){
    updateSuitesrooms($room_id); 
}

$data = [];

function getRoomNameByRoom_id($id){
    global $db;

    $sql = "SELECT `naam`,`roomsize`, `bedtype` FROM `suitesrooms` WHERE roomid=:id";

    $smtp = $db->prepare($sql);
    $smtp->execute([
        "id"  => $id,
    ]);
    $result = $smtp->fetchAll(\PDO::FETCH_ASSOC);
    return $result;
}

$room_name = getRoomNameByRoom_id($room_id)[0]['naam'];


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
$suitesrooms = getPropertyByPropertyid($room_id);

function updateSuitesrooms($id){
    global $db;
    
    // $usp1 = $_POST['usp1'];
    // $usp2 = $_POST['usp2'];
    // $usp3 = $_POST['usp3'];
    $description = $_POST['description'];      

    $sql = "UPDATE `suitesrooms` SET `description`= '$description'  WHERE `roomid` =  :id" ;

    $stmt = $db->prepare($sql); 
    $stmt->execute([
        "id"  => $id,
    ]);  
        
    $dataDable = $stmt->fetchAll(\PDO::FETCH_ASSOC);
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
$ollRoomPhotos = ollPhotosByRoomId($room_id);
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
* {box-sizing: border-box}
body {font-family: Verdana, sans-serif; margin:0}
.mySlides {display: none}
img {vertical-align: middle;}

/* Slideshow container */
.slideshow-container {
  max-width: 500px;
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
</style>
<style>
    .suitesroomsUpdateForm{
        width:30%;            
        margin:0 auto;
        text-align:center;
    }
    input{
        margin: 0 10px 10px 10px;
    }
       
</style>
<h2>Room name: <?= $room_name ?></h2>
<h2 style="text-align:center">Update suitesrooms</h2>
<form action="" class="suitesroomsUpdateForm" method="post">
    <input type="hidden" name="method" value="updateSuitesrooms" >       
        
    <label for="">description</label>  <br>     
    <textarea name="description" id="" cols="30" rows="10"><?php echo isset($suitesrooms[0]['description']) ? $suitesrooms[0]['description'] : ""; ?></textarea><br>
    <input type="submit" value="update"><br>
    <a href=""></a>
</form>

<?php if(!empty($ollRoomPhotos)): ?>   

    <div class="slideshow-container">
        <?php
        foreach($ollRoomPhotos as $key => $val):
        ?>
            <div class="mySlides fade">
            <div class="numbertext"><?php echo $key+1; ?> / <?php echo count($ollRoomPhotos) ?></div>
            <img src="https://www.hotels.nl/assets/images/rooms/<?php echo isset($room_id)  ? $room_id : '';  ?>-<?= $val['photo_id']; ?>.jpg" style="width:100%">
            </div>
        <?php
        endforeach
        ?>
        <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
        <a class="next" onclick="plusSlides(1)">&#10095;</a>

        </div>
        <br>
    <?php endif ?>  

    <?php
	echo 'roomsize ' . getRoomNameByRoom_id($room_id)[0]['roomsize'] . '<br>';
	echo 'bedtype ' . getRoomNameByRoom_id($room_id)[0]['bedtype'];
    include "../roomfacilities.php";
    ?>
    <script>
    var slideIndex = 1;
    showSlides(slideIndex);

    function plusSlides(n) {
    showSlides(slideIndex += n);
    }

    function currentSlide(n) {
     showSlides(slideIndex = n);
    }

    function showSlides(n) {
        var i;
        var slides = document.getElementsByClassName("mySlides");
        var dots = document.getElementsByClassName("dot");
        if (n > slides.length) {slideIndex = 1}    
        if (n < 1) {slideIndex = slides.length}
        for (i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";  
        }
        for (i = 0; i < dots.length; i++) {
            dots[i].className = dots[i].className.replace(" active", "");
        }
        slides[slideIndex-1].style.display = "block";  
        dots[slideIndex-1].className += " active";
        }
    </script>
</body>
</html>