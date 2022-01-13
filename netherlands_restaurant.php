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

$restaurants = $json->elements;

echo count($restaurants);
//print_r($restaurants[0]);
  //die;

 $vals = "";  
 $id = "null";
 $lat = "null";
 $lon = "null";
 $type = "null";
 $name = "null";
 $street = "null";
 $housenumber = "null";
 $postcode = "null";
 $email = "null";
 $website = "null";
 $phone = "null";
 $cuisine = "null";
 $delivery = "null";
 $takeaway = "null";
foreach($restaurants as $key => $restaurant){    
            
    if($restaurant->tags->name){      
          
    $restauran_tags = $restaurant->tags;
    $id = isset($restaurant->id) ? $restaurant->id : null;

    $lat = "";    
    if(isset($restaurant->lat) && !empty($restaurant->lat)){
        $lat = "".$restaurant->lat."";
     } else {
        $lon = 'null';
     }; 

    $lon = "";
    if(isset($restaurant->lon) && !empty($restaurant->lon)){
        $lon = "".$restaurant->lon."";
     } else {
        $lon = 'null';
     }; 

    $type = "";
    if(isset($restaurant->tags->amenity) && !empty($restaurant->tags->amenity)){
        $type = "'".$restaurant->tags->amenity."'";
     } else {
        $type = 'null';
     }; 

    $name = "";
    
    if(isset($restaurant->tags->name) && !empty($restaurant->tags->name)){
        $name = "'".$restaurant->tags->name."'";
     } else {
        $name = 'null';
     }; 


    $street = "";
    foreach($restauran_tags as $key1 =>$val1){
        if($key1 == 'addr:street'){            
            $street = "'".$val1."'";
        }    
    }        
    if($street == ""){
        $street = "null";
    }  

    $housenumber = "";
    foreach($restauran_tags as $key1 =>$val1){
        if($key1 == 'addr:housenumber'){                   
            $housenumber = "'".$val1."'";
        }    
    }
    if($housenumber == ""){
        $housenumber = "null";
    }  
    

    $postcode = "";
    foreach($restauran_tags as $key1 =>$val1){
        if($key1 == 'addr:postcode'){                    
            $postcode = "'".$val1."'";
        }    
    }    
    if($postcode == ""){
        $postcode = "null";
    } 

    
    $email = "";
    if(isset($restaurant->tags->email) && !empty($restaurant->tags->email) ){
        $email = "'".$restaurant->tags->email."'";
        
     } else {
        $email = 'null';
     }; 

    $website = "";
    if(isset($restaurant->tags->website) && !empty($restaurant->tags->website)){
        $website = "'".$restaurant->tags->website."'";
     } else {
        $website = 'null';
     };  

    $phone = "";
     if(isset($restaurant->tags->phone) && !empty($restaurant->tags->phone)){
        $phone = "'".$restaurant->tags->phone."'";
     } else {
        $phone = 'null';
     };  

    $cuisine = "";
     if(isset($restaurant->tags->cuisine) && !empty($restaurant->tags->cuisine)){
        $cuisine = "'".$restaurant->tags->cuisine."'";
     } else {
        $cuisine = 'null';
     };  
     
    $delivery = "";
     if(isset($restaurant->tags->delivery) && !empty($restaurant->tags->delivery)){
        $delivery = "'".$restaurant->tags->delivery."'";
     } else {
        $delivery = 'null';
     };   

    $takeaway = "";
      if(isset($restaurant->tags->takeaway) && !empty($restaurant->tags->takeaway)){
        $takeaway = "'".$restaurant->tags->takeaway."'";
     } else {
        $takeaway = 'null';
     };      
       
     $vals .= "(".$id.",".$lat.",".$lon.",".$type.",".$name.",".$street.",".$housenumber.",".$postcode.",".$email.",".$website.",".$phone.",".$cuisine.",".$delivery.",".$takeaway.")";
     //echo $vals;
    
    
        
           
    }  
    if($key>50){
        break;
    } else {
        $vals .= ",";
    }
    
   }
 //echo $vals;
//die;

function insertIntoPoi(){
   global $db;      
   global $vals;
    
    $sql = "INSERT INTO `poi`(id,lat,lon,type,name,street,housenumber,postcode,email,website,phone,cuisine,delivery,takeaway) VALUES $vals";
       echo $vals;
     $stmt = $db->prepare($sql);
     $stmt->execute([
        
     ]);
    
}	
insertIntoPoi();
// die;


// //$insObjNum+1
// // $insObjNum = 0;
// // if(isset($_COOKIE['insObjNum'])){
// //     $insObjNum = $_COOKIE['insObjNum'];
// // }
// // setcookie('insObjNum',$insObjNum+10,time()+86400,"/");

// ?>


        <!-- <tr>
//             <th>index</th>
//             <th>id</th>
//             <th>lat</th>
//             <th>lon</th>
//             <th>type(restaurant)</th>
//             <th>name</th>
//             <th>street</th>
//             <th>housenumber</th>
//             <th>postcode</th>
//             <th>email</th>
//             <th>website</th>            
//             <th>phone</th>
//             <th>cuisine</th>
//             <th>delivery</th>   
//             <th>takeaway</th>      
//         </tr> -->
        <?php
        
//           ?> 
   
    
 </body>
 </html> 