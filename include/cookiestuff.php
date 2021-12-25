<?php

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

if(!isset($db)){
    include './include/db.php';
    $db = getdb();
}

// include 'server.php';

// $server    = new Server();

function setpPopertyCookie($name,$arrival,$departure, $cookie_name = null){
    global $db;

    // $valdate = $this->validateDate($arrival, 'Y-m-d');
    // $valdate2 = $this->validateDate($departure, 'Y-m-d');

    $valdate = validateDate($arrival, 'Y-m-d');
    $valdate2 = validateDate($departure, 'Y-m-d');
 
     if($valdate == true && $valdate2 == true ){

 
         $sql = " SELECT *  FROM `property` WHERE `url` = :name" ;
         $stmt = $db->prepare($sql);
         $stmt->execute([
             "name"  => $name,
         ]);

         $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);

         if(isset($result) && !empty($result)){

             $url  = isset($result[0]['url']) ? $result[0]['url'] : "";
             $Name = isset($result[0]['naam']) ? $result[0]['naam'] : "";

                $array = [
                 "name" => $Name,
                 "url" =>  $url,
                 "arrival" =>  $arrival,
                 "departure" =>  $departure,
             ]; 
         
             setcookie($cookie_name, serialize($array), time() + (3600 * 24 *7 ), "/");
             $_COOKIE[$cookie_name] = serialize($array);
         }
         
     }

     return unserialize($_COOKIE[$cookie_name]);

 }

 function getPropertyByUrl($name){

    $sql = " SELECT *  FROM `property` WHERE `url` = :name" ;
    $stmt = $db->prepare($sql);

    $stmt->execute([
        "name"  => $name,
    ]);

    $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
   
    return $result;

}



if(!empty($_GET) &&  $_GET["name"] !== '' && isset($_GET["arrival"]) &&  isset($_GET["departure"])  ){

    $name      = str_replace('/', '', $_GET["name"]);
    $arrival   = $_GET["arrival"];
    $departure = $_GET["departure"];

    $result_cookies = setpPopertyCookie($name,$arrival,$departure);
}

if( !empty($_GET) && $_GET["name"] !== '' ){
    
    $name = str_replace('/', '', $_GET["name"]);
    $get = getPropertyByUrl($name);

}

$result_cookie = unserialize($_COOKIE['value2']);


?>
