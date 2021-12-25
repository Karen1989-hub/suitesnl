<?php

session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if(!isset($db)){
    include './include/db.php';
    $db = getdb();
}

//include 'server.php';

function login(){
    global $db;

    $error = [];
    $username = $_POST['username'];
    $password = $_POST['password'];

    if(empty($username) || empty($password)){

        $_SESSION['error'] = 'The field is empry, please fill it';
        header("location:/adminlogin/index.php");exit();

    }else{

        $sql = "SELECT *  FROM `users` WHERE `username` = :username" ;

        $stmt = $db->prepare($sql);

        $stmt->execute([
            "username"  => $username,
        ]);  

        $data = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        var_dump($data);

        if($data[0]['username'] != $username){

            $_SESSION['error'] = 'The username is worng';
            header("location:/adminlogin/index.php");exit();

        }else{
            if(password_verify($password,$data[0]["password"])){

                $_SESSION['users'] = $data; 

            }else{

                $_SESSION['error'] = 'The password is worng';
                header("location:/adminlogin/index.php");exit();

            }

        }
        
    }

    header("location:/admin/index.php");exit();

}

function logout(){

    header("location:/adminlogin/index.php");  
    unset($_SESSION['users']);

}

function updateProperty(){
    global $db;

    print_r($_POST);
    $usp1 = $_POST['usp1'];
    $usp2 = $_POST['usp2'];
    $usp3 = $_POST['usp3'];
    $id = $_POST['id'];
    $hoteltext = $_POST['hoteltext'];

    $sql = "UPDATE `property` SET `usp1`='$usp1',`usp2`='$usp2',`usp3`='$usp3',`hoteltext`= '$hoteltext'  WHERE `id` =  :id" ;

    $stmt = $db->prepare($sql); 
    $stmt->execute([
        "id"  => $id,
    ]);  
        
    $dataDable = $stmt->fetchAll(\PDO::FETCH_ASSOC);  
    
    header("location:/admin/admin-list.php?id=$id");

}

$method = $_REQUEST['method'] ?? '';
//$server = new Server();

if ($method === 'login') {
    login();
} 

if ($method === 'logout') { 
    logout();
}

if ($method === 'update') {
    updateProperty();
}


