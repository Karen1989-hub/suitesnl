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

# Hier defineer je je variabelen ( boven de includes )

$type = 'article';
$url = 'https://www.suites.nl';
$description = 'Omschrijving van de site';
$image = '/images/socialheader.jpg';

$title = 'Dit is de titel van de pagina'; #zie header file voor voorbeeld
$fbtype = 'PageView';

#include __DIR__ . '/include/header.php';

$cookie = GetCookie();

$arrival    =  isset($cookie['arrival']) ? $cookie['arrival'] : "";
$departure  =  isset($cookie['departure']) ? $cookie['departure'] : "";
$collection =  isset($_GET['name']) ? $_GET['name'] : "";

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

<?php

    $collectionid  = $get[0]['id'];
    include __DIR__.'/include/collectionhotels.php';

?>

        

<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
<script src="assets/scripts/main.js"></script>
</body>

</html>
