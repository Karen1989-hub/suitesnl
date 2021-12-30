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

$property_name = $get[0]['naam'];
function getSuitesroom($property_name){
    global $db;
    

     $sql = "SELECT property.*,suitesrooms.naam as suitesrooms_naam, suitesrooms.description as suitesrooms_description FROM property INNER JOIN suitesrooms ON property.id=suitesrooms.propertyid WHERE city=:property_name";
     $stmt = $db->prepare($sql);
     $stmt->execute([
        'property_name' => $property_name
    	]);
    	$result = $stmt->fetchAll(\PDO::FETCH_ASSOC);   
    	return $result;

}

$property_rooms = getSuitesroom($property_name);

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

// echo "<pre>";
// var_dump($property_rooms);

?>
<div style="width:100%; overflow:scroll;">


<table cellpadding=10>
    <tr>
        <th>id</th>
        <th>naam</th>
        <th>url</th>
        <th>priority</th>
        <th>address</th>
        <th>house_number</th>
        <th>postal_code</th>
        <th>city</th>
        <th>province</th>
        <th>stars</th>
        <th>number_of_rooms</th>
        <th>checkinfrom</th>
        <th>checkintill</th>
        <th>checkoutfrom</th>
        <th>checkouttill</th>
        <th>titel</th>
        <th>usp1</th>
        <th>usp2</th>
        <th>usp3</th>
        <th>hoteltext</th>
        <th>suitesrooms_naam</th>
        <th>suitesrooms_description</th>        
    </tr>
    <?php foreach($property_rooms as $val): ?>
    <tr>
       <td><?php echo isset($val['id']) ? $val['id'] : '';  ?></td>      
       <td><a href="/<?php echo isset($val['url']) ? $val['url'] : ''; ?>/"><?php echo isset($val['naam']) ? $val['naam'] : ''; ?></a></td>     
       <td><?php echo isset($val['url']) ? $val['url'] : '';  ?></td> 
       <td><?php echo isset($val['priority']) ? $val['priority'] : '';  ?></td>     
       <td><?php echo isset($val['address']) ? $val['address'] : '';  ?></td>     
       <td><?php echo isset($val['house_number']) ? $val['house_number'] : '';  ?></td>     
       <td><?php echo isset($val['postal_code']) ? $val['postal_code'] : '';  ?></td>     
       <td><?php echo isset($val['city']) ? $val['city'] : '';  ?></td>     
       <td><?php echo isset($val['province']) ? $val['province'] : '';  ?></td>     
       <td><?php echo isset($val['stars']) ? $val['stars'] : '';  ?></td>     
       <td><?php echo isset($val['number_of_rooms']) ? $val['number_of_rooms'] : '';  ?></td>     
       <td><?php echo isset($val['checkinfrom']) ? $val['checkinfrom'] : '';  ?></td>     
       <td><?php echo isset($val['checkintill']) ? $val['checkintill'] : '';  ?></td>     
       <td><?php echo isset($val['checkoutfrom']) ? $val['checkoutfrom'] : '';  ?></td>    
       <td><?php echo isset($val['checkouttill']) ? $val['checkouttill'] : '';  ?></td>     
       <td><?php echo isset($val['titel']) ? $val['titel'] : '';  ?></td>     
       <td><?php echo isset($val['usp1']) ? $val['usp1'] : '';  ?></td>     
       <td><?php echo isset($val['usp2']) ? $val['usp2'] : '';  ?></td>     
       <td><?php echo isset($val['usp3']) ? $val['usp3'] : '';  ?></td>     
       <td><?php echo isset($val['hoteltext']) ? $val['hoteltext'] : '';  ?></td>     
       <td><?php echo isset($val['suitesrooms_naam']) ? $val['suitesrooms_naam'] : '';  ?></td>
       <td><?php echo isset($val['suitesrooms_description']) ? $val['suitesrooms_description'] : '';  ?></td>        
    </tr>   
    <?php endforeach ?>
</table>
</div>


<?php

    $collectionid  = $get[0]['id'];
    //include __DIR__.'/include/collectionhotels.php';

?>

        

<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
<script src="assets/scripts/main.js"></script>
</body>

</html>
