<?php

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

include './include/db.php';
$db = getdb();

include __DIR__ . '/include/arrivalcookie.php';
include __DIR__ . '/include/collection-include.php';


function GetCookie(){
    
   $cookie2 = [];  
   $cookie  = isset($_COOKIE["arrival"]) ? $_COOKIE["arrival"] : [];

   if(!empty($cookie)){

    $cookie2 = unserialize($cookie);

   }
  
   return $cookie2;

}


$cookie = GetCookie();

$arrival    =  isset($cookie['arrival']) ? $cookie['arrival'] : "";
$departure  =  isset($cookie['departure']) ? $cookie['departure'] : "";
$collection =  isset($_GET['name']) ? $_GET['name'] : "";

$collection_id = $get[0]['id'];


?>

 
<html lang="nl">
<head>
<meta charset="utf-8">
<title><?php echo isset($get[0]['titel']) ? $get[0]['titel'] : ''; ?></title>
<meta name="description" content="Binnenkort kunt u op deze pagina alle hotelsuites van <?php echo isset($get[0]['titel']) ? $get[0]['naam'] : ''; ?> reserveren."/>
</head>
<h2>Binnenkort kunt u via deze pagina alle hotelsuites in <?php echo isset($get[0]['titel']) ? $get[0]['naam'] : ''; ?> reserveren!</h2>
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

                max-width: 200px;
                
            }
            table {
                width: 100%;
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


<div id="wrapper">
<?php if(isset($result_cookie) && !empty($result_cookie)): ?>
    <h1 style="text-align:center;">result of cookie</h1>
    <table>
        <tr>
            <th>naam</th>
            <th>url</th>
            <th>arrival</th>
            <th>departure</th>
        </tr>
        <tr>

            <td><?php echo isset($result_cookie['name']) ? $result_cookie['name'] : '';  ?></td>
            <td><?php echo isset($result_cookie['url']) ? $result_cookie['url'] : ''; ?></td>
            <td><?php echo isset($result_cookie['arrival']) ? $result_cookie['arrival'] : ''; ?></td>
            <td><?php echo isset($result_cookie['departure']) ? $result_cookie['departure'] : ''; ?></td>
    
        </tr>

    </table>
    <?php else: echo "<p style='text-align:center;'>NO DATA</>" ?>
<?php endif;?>

    <?php if(isset($get) && !empty($get)): ?>
       
        <h1 style="text-align:center;margin-top:30px">result of suites</h1>
        <table>
            <tr>
                <th>naam</th>
                <th>url</th>
                <th>type</th>
                <th>titel</th>
                <th>beschrijving</th>
            </tr>
            <tr>
                <td><?php echo isset($get[0]['naam']) ? $get[0]['naam'] : '';  ?></td>
                <td><?php echo isset($get[0]['url']) ? $get[0]['url'] : ''; ?></td>
                <td><?php echo isset($get[0]['type']) ? $get[0]['type'] : ''; ?></td>
                <td><?php echo isset($get[0]['titel']) ? $get[0]['titel'] : ''; ?></td>
                <td><?php echo isset($get[0]['beschrijving']) ? $get[0]['beschrijving'] : ''; ?></td>
            </tr>

        </table>

    <?php else:?>

        <p style='text-align:center; magrin-top:30px'>NO DATA</p>

    <?php endif;?>

    <?php include 'cookie.php';?>

</div>

Cut here Vitaly

<?php 
if($arrival !== "" && $departure !== "") {+

    $collection_id = isset($get[0]["id"]) ? $get[0]["id"] : 0;
    include "include/havearrival_collection.php";

}else{
    $collection_id = isset($get[0]["id"]) ? $get[0]["id"] : 0;            
     include "include/noarrival_collection.php";
}

?>

CUT TILL HERE

<?php

    $collectionid  = $get[0]['id'];
    //include __DIR__.'/include/collectionhotels.php';

?>

        

<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
<script >
//slider for rooms photo
var slideIndex = 1;
let changeNum = 0;
let inpSlideHidden = document.getElementsByClassName('slid');
let inpSlideHiddenVal = 0;

let prev = document.getElementsByClassName('prev');
let next = document.getElementsByClassName('next');
for(let i=0;i<prev.length;i++){
    prev[i].addEventListener("click",function(){
        console.log('prev');
        changeNum = this.getAttribute('data');
        let photoCount = document.getElementsByClassName("photoCount"+changeNum)[0].value;
        let showPhotoIndex = document.getElementsByClassName("showPhotoIndex"+changeNum)[0].value;
        if(showPhotoIndex==1){
            showPhotoIndex = photoCount--;
            document.getElementsByClassName("showPhotoIndex"+changeNum)[0].value = showPhotoIndex;
            let thisdiv = document.getElementsByClassName('roomsId_'+changeNum);
            for(let t=0;t<thisdiv.length;t++){
                thisdiv[t].setAttribute('style','display:none');
            }
            thisdiv[showPhotoIndex-1].setAttribute('style','display:block');
        } else {
            showPhotoIndex--;
            document.getElementsByClassName("showPhotoIndex"+changeNum)[0].value = showPhotoIndex;
            let thisdiv = document.getElementsByClassName('roomsId_'+changeNum);
            for(let t=0;t<thisdiv.length;t++){
                thisdiv[t].setAttribute('style','display:none');
            }
            thisdiv[showPhotoIndex-1].setAttribute('style','display:block');
        }
        console.log(showPhotoIndex);       
        
    })
}
for(let i=0;i<next.length;i++){
    next[i].addEventListener("click",function(){
        console.log('next');
        changeNum = this.getAttribute('data');
        let photoCount = document.getElementsByClassName("photoCount"+changeNum)[0].value;
        let showPhotoIndex = document.getElementsByClassName("showPhotoIndex"+changeNum)[0].value;
        if(showPhotoIndex==photoCount){
            showPhotoIndex = 1;
            document.getElementsByClassName("showPhotoIndex"+changeNum)[0].value = showPhotoIndex;
            let thisdiv = document.getElementsByClassName('roomsId_'+changeNum);
            for(let t=0;t<thisdiv.length;t++){
                thisdiv[t].setAttribute('style','display:none');
            }
            thisdiv[showPhotoIndex-1].setAttribute('style','display:block');
        } else {
            showPhotoIndex++;
            document.getElementsByClassName("showPhotoIndex"+changeNum)[0].value = showPhotoIndex;
            let thisdiv = document.getElementsByClassName('roomsId_'+changeNum);
            for(let t=0;t<thisdiv.length;t++){
                thisdiv[t].setAttribute('style','display:none');
            }
            thisdiv[showPhotoIndex-1].setAttribute('style','display:block');
        }
        console.log(showPhotoIndex);       
        
    })
}
//end slider for rooms photo
</script>


</body>

</html>
