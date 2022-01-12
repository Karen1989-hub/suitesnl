<h2>ALL restaurants </h2>
<?php
if (!isset($db)) {
    include './include/db.php';
    $db = getdb();
}




$ch = curl_init("https://suites.nl/include/restaurants.json");
curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);

$json = curl_exec($ch);
curl_close($ch);	

$json = json_decode($json);
$restaurants = $json;



//echo "<pre>";
//print_r($json->elements);die;
//print_r($json->elements[0]->tags);
$restaurants = $json->elements;

echo "<pre>";
print_r($restaurants);die;

//echo "<pre>";
//print_r($restaurants);

   


// echo "=================================================================================================<br>";
// $restauran_tags = $restaurants[2]->tags;
// foreach($restauran_tags as $key =>$val){
//     if($key == 'addr:street'){
//         echo $val."<br>";
//     }    
// }
//print_r($restaurants[0]->tags);
//echo "=================================================================================================<br>";
//die;

function insertIntoPoi($id,$lat,$lon,$type,$name,$street,$housenumber,$postcode,$email,$website,$phone,$cuisine,$delivery,$takeaway){
    global $db;      
    
    $sql = "INSERT INTO poi(id,lat,lon,type,name,street,housenumber,postcode,email,website,phone,cuisine,delivery,takeaway) 
    VALUE('$id','$lat','$lon','$type','$name','$street','$housenumber','$postcode','$email','$website','$phone','$cuisine','$delivery','$takeaway')";
    
    $stmt = $db->prepare($sql);
    $stmt->execute([                  
       
    ]);
    
}	
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
</head>
<body>
    <table>
        <tr>
            <th>id</th>
            <th>lat</th>
            <th>lon</th>
            <th>type(restaurant)</th>
            <th>name</th>
            <th>street</th>
            <th>housenumber</th>
            <th>postcode</th>
            <th>email</th>
            <th>website</th>            
            <th>phone</th>
            <th>cuisine</th>
            <th>delivery</th>   
            <th>takeaway</th>      
        </tr>
        <?php foreach($restaurants as $key => $restaurant): ?>
            <?php if($restaurant->tags->name): ?>
            <tr>
               <td><?php echo isset($restaurant->id) ? $restaurant->id : ''; ?></td>
               <td><?php echo isset($restaurant->lat) ? $restaurant->lat : ''; ?></td>
               <td><?php echo isset($restaurant->lon) ? $restaurant->lon : ''; ?></td>
               <td><?php echo isset($restaurant->tags->amenity) ? $restaurant->tags->amenity : ''; ?></td>
               <td><?php echo isset($restaurant->tags->name) ? $restaurant->tags->name : ''; ?></td>
               <td>
                   <?php
                    $restauran_tags = $restaurants[$key]->tags;
                    foreach($restauran_tags as $key1 =>$val1){
                        if($key1 == 'addr:street'){
                            echo $val1."<br>";
                            $street = $val1;
                        }    
                    }
                   ?>
               </td>
               <td>
                    <?php
                    $restauran_tags = $restaurants[$key]->tags;
                    foreach($restauran_tags as $key1 =>$val1){
                        if($key1 == 'addr:housenumber'){
                            echo $val1."<br>";
                            $housenumber = $val1;
                        }    
                    }
                    ?>
               </td>
               <td>
                   <?php
                   $restauran_tags = $restaurants[$key]->tags;
                   foreach($restauran_tags as $key1 =>$val1){
                       if($key1 == 'addr:postcode'){
                           echo $val1."<br>";
                           $postcode = $val1;
                       }    
                   }
                   ?>
                </td>
               <td><?php echo isset($restaurant->tags->email) ? $restaurant->tags->email : ''; ?></td>
               <td><?php echo isset($restaurant->tags->website) ? $restaurant->tags->website : ''; ?></td>
               <td><?php echo isset($restaurant->tags->phone) ? $restaurant->tags->phone : ''; ?></td>
               <td><?php echo isset($restaurant->tags->cuisine) ? $restaurant->tags->cuisine : ''; ?></td>
               <td><?php echo isset($restaurant->tags->delivery) ? $restaurant->tags->delivery : ''; ?></td>
               <td><?php echo isset($restaurant->tags->takeaway) ? $restaurant->tags->takeaway : ''; ?></td> 
            </tr>
            <?php
            ////insert into `poi`
            $id = isset($restaurant->id) ? $restaurant->id : '';
            $lat = isset($restaurant->lat) ? $restaurant->lat : '';
            $lon = isset($restaurant->lon) ? $restaurant->lon : '';
            $type = isset($restaurant->tags->amenity) ? $restaurant->tags->amenity : '';
            $name = isset($restaurant->tags->name) ? $restaurant->tags->name : '';
            ///$street = ;
            ///$housenumber = ;
            ///$postcode = ;
            $email = isset($restaurant->tags->email) ? $restaurant->tags->email : '';
            $website = isset($restaurant->tags->website) ? $restaurant->tags->website : '';
             $phone = isset($restaurant->tags->phone) ? $restaurant->tags->phone : '';
             $cuisine = isset($restaurant->tags->cuisine) ? $restaurant->tags->cuisine : '';
             $delivery = isset($restaurant->tags->delivery) ? $restaurant->tags->delivery : '';
             $takeaway = isset($restaurant->tags->takeaway) ? $restaurant->tags->takeaway : '';

            
            //insertIntoPoi($id,$lat,$lon,$type,$name,$street,$housenumber,$postcode,$email,$website,$phone,$cuisine,$delivery,$takeaway);
           
            ?>
            <?php endif;  ?>

        <?php endforeach ?>    
       
    </table>
    
</body>
</html>