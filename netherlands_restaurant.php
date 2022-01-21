<h2>Insert parking 4</h2>
<?php
die;
if (!isset($db)) {
    include './include/db.php';
    $db = getdb();
}

$ch = curl_init("https://suites.nl/include/parking4.json");
curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);



$json2 = curl_exec($ch);
curl_close($ch);	

$json = json_decode($json2);

$restaurants = $json->elements;
////////////////////

 $allVals = "";
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
//die;
   //    echo count($restaurants);
      // echo "<pre>";
   
      // print_r($restaurants);
      
      //   die;
$insertStartNum = 0;
 if(isset($_COOKIE['insertStartNum'])){
    $insertStartNum = $_COOKIE['insertStartNum'];
 }
setcookie("insertStartNum",$insertStartNum+1,time()+86400,"/");
//$restaurants
echo "<h3>loading ".floor($insertStartNum/133)."%</h3>";

//die;
for($i=$insertStartNum;$i<$insertStartNum+1;$i++){    
   //$vals = "";  
   $vals2 = "";     
    if($restaurants[$i]->tags->name){      
          
    $restauran_tags = $restaurants[$i]->tags;
    $id = isset($restaurants[$i]->id) ? $restaurants[$i]->id : null;

    $lat = "";    
    if(isset($restaurants[$i]->lat) && !empty($restaurants[$i]->lat)){
        $lat = "".$restaurants[$i]->lat."";
     } else {
        $lat = 'null';
     }; 

    $lon = "";
    if(isset($restaurants[$i]->lon) && !empty($restaurants[$i]->lon)){
        $lon = "".$restaurants[$i]->lon."";
     } else {
        $lon = 'null';
     }; 

    $type = "";
    if(isset($restaurants[$i]->tags->amenity) && !empty($restaurants[$i]->tags->amenity)){
        $type = "'".$restaurants[$i]->tags->amenity."'";
     } else {
        $type = 'null';
     }; 

    $name = "";
    
    if(isset($restaurants[$i]->tags->name) && !empty($restaurants[$i]->tags->name)){
        $name = "'".$restaurants[$i]->tags->name."'";
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
    if(isset($restaurants[$i]->tags->email) && !empty($restaurants[$i]->tags->email) ){
        $email = "'".$restaurants[$i]->tags->email."'";        
     } else {
        $email = 'null';
     }; 

    $website = "";
    if(isset($restaurants[$i]->tags->website) && !empty($restaurants[$i]->tags->website)){
        $website = "'".$restaurants[$i]->tags->website."'";
     } else {
        $website = 'null';
     };  

    $phone = "";
     if(isset($restaurants[$i]->tags->phone) && !empty($restaurants[$i]->tags->phone)){
        $phone = "'".$restaurants[$i]->tags->phone."'";
     } else {
        $phone = 'null';
     };  

    $cuisine = "";
     if(isset($restaurants[$i]->tags->cuisine) && !empty($restaurants[$i]->tags->cuisine)){
        $cuisine = "'".$restaurants[$i]->tags->cuisine."'";
     } else {
        $cuisine = 'null';
     };  
     
    $delivery = "";
     if(isset($restaurants[$i]->tags->delivery) && !empty($restaurants[$i]->tags->delivery)){
        $delivery = "'".$restaurants[$i]->tags->delivery."'";
     } else {
        $delivery = 'null';
     };   

    $takeaway = "";
      if(isset($restaurants[$i]->tags->takeaway) && !empty($restaurants[$i]->tags->takeaway)){
        $takeaway = "'".$restaurants[$i]->tags->takeaway."'";
     } else {
        $takeaway = 'null';
     };      
       
     $vals = "(".$id.",".$lat.",".$lon.",".$type.",".$name.",".$street.",".$housenumber.",".$postcode.",".$email.",".$website.",".$phone.",".$cuisine.",".$delivery.",".$takeaway.")";
     //echo $vals;    
        
         // if($i==$insertStartNum){
         //    break;
         // } else {
         //    $vals .= ",";
         // }
         
    }  
   //  if($vals != "" ){
   //    $allVals .= $vals.",";
   //  }       
   //  if($id == 1257){
   //     echo "FINISH";
   //     die;
   //  }
   }
  //$allVals = substr($allVals,0,-1);
  
  //echo $vals;
 
   echo "<br>";
   echo "<br>";
   

if($vals != ""){
   function insertIntoPoi(){
      global $db;  
      global $vals;    
      global $allVals;
       
       $sql = "INSERT INTO `poi`(id,lat,lon,type,name,street,housenumber,postcode,email,website,phone,cuisine,delivery,takeaway) VALUES $vals";
          //echo $sql;
        $stmt = $db->prepare($sql);
        $stmt->execute([
           
        ]);    
   }	
   insertIntoPoi();
}
//echo "Karen";
header("Refresh:0");

// die;


