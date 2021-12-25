<?php 

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

session_start();

if(!isset($db)){
    include './include/db.php';
    $db = getdb();
}

//include realpath(__DIR__ . '/..').'/server.php';
//$server    = new Server();

function getSuitesByUrl($name){

    global $db;

    $sql = " SELECT *  FROM `suites` WHERE `url` = :name" ;
    $stmt = $db->prepare($sql);

    $stmt->execute([
        "name"  => $name,
    ]);

    $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
   
    return $result;

}

if( !empty($_GET) && $_GET["name"] !== '' ){
    
    $name = str_replace('/', '', $_GET["name"]);
    $get = getSuitesByUrl($name);
    
}


$result_cookie = isset($_COOKIE['arrival']) ?  unserialize($_COOKIE['arrival']) : [];