<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

include __DIR__ . '/include/arrivalcookie.php';
include __DIR__ . '/include/hotels-include.php';


# Hier defineer je je variabelen ( boven de includes )

$type = 'article';
$url = 'https://www.suites.nl';
$description = 'Omschrijvin';
$image = '/images/socialheader.jpg';

$title = 'Dit is de titel van de pagina'; #zie header file voor voorbeeld
$fbtype = 'PageView';


#    include __DIR__ . '/include/header.php';

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

?>

<html lang="nl">
<head>
<meta charset="utf-8">
<title>Suites in <?php echo isset($get[0]['naam'])  ? $get[0]['naam'] : '';  ?>. Aanbiedingen in hotelsuites</title>
<meta name="description" content="Binnenkort kunt u op deze pagina de suites van <?php echo isset($get[0]['naam'])  ? $get[0]['naam'] : '';  ?> reserveren."/>
</head>
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

<div id="wrapper">
<h2>Binnenkort kunt u op deze pagina de suites van <?php echo isset($get[0]['naam'])  ? $get[0]['naam'] : '';  ?> reserveren.</h2>
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

    <?php else: ?>

        <p style='text-align:center;'>NO DATA</p> 

    <?php endif;?>
        <?php
        // echo "<pre>";
        // var_dump($get);
        
        ?>


    <?php if(isset($get) && !empty($get)): ?>

        <h1 style="text-align:center;margin-top:30px">result of property</h1>
        <table>
            <tr>
                <th>naam</th>
                <th>url</th>
                <th>titel</th>
            </tr>
            <tr>
                <td> <?php echo isset($get[0]['naam'])  ? $get[0]['naam'] : '';  ?></td>
                <td> <?php echo isset($get[0]['url'])   ? $get[0]['url'] : ''; ?></td>
                <td> <?php echo isset($get[0]['titel']) ? $get[0]['titel'] : ''; ?></td>
            </tr>

        </table>

    <?php else: ?>
        
        <p style='text-align:center; magrin-top:30px'>NO DATA</p>

    <?php endif;?>

</div>
 

<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
<script src="assets/scripts/main.js"></script>

    id = <?= $get[0]["id"] ?><br />
    <br />naam = <?= $get[0]["naam"] ?>
    <br />priority = <?= $get[0]["priority"] ?>
    <br />address = <?= $get[0]["address"] ?>
    <br />house_number = <?= $get[0]["house_number"] ?>
    <br />postal_code =<?= $get[0]["postal_code"] ?>
    <br />city = <?= $get[0]["city"] ?>
    <br />province = <?= $get[0]["province"] ?>
    <br />stars = <?= $get[0]["stars"] ?>
    <br />number of rooms = <?= $get[0]["number_of_rooms"] ?>
    <br />checkinfrom =<?= $get[0]["checkinfrom"] ?>
    <br />checkintill = <?= $get[0]["checkintill"] ?>
    <br />checkoutfrom = <?= $get[0]["checkoutfrom"] ?>
    <br />checkouttill = <?= $get[0]["checkouttill"] ?>
    <br />usp1 = <?= $get[0]["usp1"] ?>
    <br />usp2 = <?= $get[0]["usp2"] ?>
    <br />usp3 = <?= $get[0]["usp3"] ?>
    <br />hoteltext = <?= $get[0]["hoteltext"] ?>

    <?php

        if($arrival !== "" && $departure !== "") {

            include __DIR__ . '/include/havearrival.php';

        }else{

            // $propertyid = isset($get[0]["id"]) ? $get[0]["id"] : 0;
            // include __DIR__ . '/include/noarrival.php';
        }

        $propertyid = isset($get[0]["id"]) ? $get[0]["id"] : 0;
        
        include __DIR__ . '/include/noarrival.php';

        ?>  


    </body>
</html>
