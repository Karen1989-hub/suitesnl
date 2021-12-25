<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

class Server 
{
    /**
     * @var Server
     */
    private $db;

    public function __construct()
    {
        include 'include/db.php';
        $this->db = getdb();

    }
    public function getSuitesByCollectionId($suitesid){

        $sql = "SELECT * FROM property
         INNER JOIN suitescollection ON property.id = suitescollection.propertyid 
         WHERE suitescollection.suitesid = :suitesid";        

        $smtp = $this->db->prepare($sql);
        $smtp->execute([
            "suitesid"  => $suitesid,
        ]);
        $result = $smtp->fetchAll(\PDO::FETCH_ASSOC);
        return $result;

    }

    public function getSuitesById($id){

        $sql = "SELECT *  FROM `suites` WHERE `id` = $id" ;
        $stmt = $this->db->prepare($sql);
   
        $stmt->execute([
            "id"  => $id,
        ]);

        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return $result;
       
    }

    public function getSuitesByUrl($name){

        $sql = " SELECT *  FROM `suites` WHERE `url` = :name" ;
        $stmt = $this->db->prepare($sql);
   
        $stmt->execute([
            "name"  => $name,
        ]);

        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
       
        return $result;
    
    }

    public function getSuitesByName($name){

        $sql = " SELECT *  FROM `suites` WHERE `naam` = :name" ;
        $stmt = $this->db->prepare($sql);
   
        $stmt->execute([
            "name"  => $name,
        ]);

        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
       
        return $result;
    
    }

    public function getPropertyByUrl($name){

        $sql = " SELECT *  FROM `property` WHERE `url` = :name" ;
        $stmt = $this->db->prepare($sql);
   
        $stmt->execute([
            "name"  => $name,
        ]);

        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
       
        return $result;
    
    }

    public function getPropertyByName($name){

        $sql = " SELECT *  FROM `property` WHERE `naam` = :name" ;
        $stmt = $this->db->prepare($sql);
   
        $stmt->execute([
            "name"  => $name,
        ]);

        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
       
        return $result;
    
    }

    public function setArrivalDepartureCookie($name,$arrival,$departure){


       $valdate = $this->validateDate($arrival, 'Y-m-d');
       $valdate2 = $this->validateDate($departure, 'Y-m-d');
       if($valdate == true && $valdate2 == true ){

        $sql = " SELECT *  FROM `suites` WHERE `naam` = :name" ;
        $stmt = $this->db->prepare($sql);
        
        $stmt->execute([
            "name"  => $name,
        ]);

        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        if(isset($result) && !empty($result)){
            if(isset($result[0]['url'])){
                $url = $result[0]['url'];
            }else{
                $url  = "";
            }
            if(isset($result[0]['naam'])){
                $Name = $result[0]['naam'];
            }else{
                $Name  = "";
            }

        $array = [
              "name" => $Name,
              "url" =>  $url,
              "arrival" =>  $arrival,
              "departure" =>  $departure,
            ]; 
        
        setcookie("value", serialize($array), time() + (3600 * 24 *7 ), "/");
        $_COOKIE["value"] = serialize($array);
        }
    }
        return unserialize($_COOKIE['value']);

    }


    public function setpPopertyCookie($name,$arrival,$departure, $cookie_name = null){

       $valdate = $this->validateDate($arrival, 'Y-m-d');
       $valdate2 = $this->validateDate($departure, 'Y-m-d');
    
        if($valdate == true && $valdate2 == true ){

    
            $sql = " SELECT *  FROM `property` WHERE `url` = :name" ;
            $stmt = $this->db->prepare($sql);
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
    public function login(){

        $error = [];
        $username = $_POST['username'];
        $password = $_POST['password'];

        if(empty($username) || empty($password)){

            $_SESSION['error'] = 'The field is empry, please fill it';
            header("location:/adminlogin/index.php");exit();

        }else{

            $sql = "SELECT *  FROM `users` WHERE `username` = :username" ;

            $stmt = $this->db->prepare($sql);

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
    public function logout(){

        header("location:/adminlogin/index.php");  
        unset($_SESSION['users']);

    }

    public function getProperty(){
        
        $sql = "SELECT id, naam, url FROM `property` " ;

        $stmt = $this->db->prepare($sql); 
        $stmt->execute([]);
            
        $dataDable = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return $dataDable;
    }

    public function getPropertyById(){
        $id = $_GET['id'];
        $sql = "SELECT id, naam, url  FROM `property` where `id` = :id " ;

        $stmt = $this->db->prepare($sql); 
        $stmt->execute([
            "id"  => $id,
        ]);  
            
        $dataDable = $stmt->fetchAll(\PDO::FETCH_ASSOC);  

        return $dataDable;
    }
    public function getPropertyByUPId(){
        $id = $_GET['id'];
        $sql = "SELECT id, naam,usp1,usp2,usp3,hoteltext, url  FROM `property` where `id` = :id " ;

        $stmt = $this->db->prepare($sql); 
        $stmt->execute([
            "id"  => $id,
        ]);  
            
        $dataDable = $stmt->fetchAll(\PDO::FETCH_ASSOC);  

        return $dataDable;
    }
    public function updateProperty(){
        print_r($_POST);
        $usp1 = $_POST['usp1'];
        $usp2 = $_POST['usp2'];
        $usp3 = $_POST['usp3'];
        $id = $_POST['id'];
        $hoteltext = $_POST['hoteltext'];

        $sql = "UPDATE `property` SET `usp1`='$usp1',`usp2`='$usp2',`usp3`='$usp3',`hoteltext`= '$hoteltext'  WHERE `id` =  :id" ;

        $stmt = $this->db->prepare($sql); 
        $stmt->execute([
            "id"  => $id,
        ]);  
            
        $dataDable = $stmt->fetchAll(\PDO::FETCH_ASSOC);  
        
        header("location:/admin/admin-list.php?id=$id");

    }

    public function setpArrivelCookie($arrival,$departure){

        $valdate = $this->validateDate($arrival, 'Y-m-d');
        $valdate2 = $this->validateDate($departure, 'Y-m-d');
     
         if($valdate == true && $valdate2 == true ){

            $array = [
                "arrival" =>  $arrival,
                "departure" =>  $departure,
            ]; 
        
            setcookie('arrival', serialize($array), time() + (3600 * 24 *7 ), "/");
            $_COOKIE['arrival'] = serialize($array);

         }
 
         return unserialize($_COOKIE['arrival']);
 
     }    

    public function GetCookie(){
       $cookie2 = [];  

       $cookie  = $_COOKIE["arrival"];

       if(isset($cookie)){

        $cookie2 = unserialize($cookie);

       }
      
       return $cookie2;

    }

    public function setpSuitesCookie($name,$arrival,$departure, $cookie_name = null){

        $valdate = $this->validateDate($arrival, 'Y-m-d');
        $valdate2 = $this->validateDate($departure, 'Y-m-d');
 
         if($valdate == true && $valdate2 == true ){ 
     
             $sql = " SELECT *  FROM `suites` WHERE `url` = :name" ;
             $stmt = $this->db->prepare($sql);
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

    public function validateDate($date, $format = 'Y-m-d H:i:s'){
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }




   public function collectionCookie ($name,$arrival,$departure){
      
    $valdate = $this->validateDate($arrival, 'Y-m-d');
    $valdate2 = $this->validateDate($departure, 'Y-m-d');
     if($valdate == true && $valdate2 == true ){

        $sql = " SELECT *  FROM `suites` WHERE `naam` = :name" ;
        $stmt = $this->db->prepare($sql);
        
        $stmt->execute([
             "name"  => $name,
        ]);

        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        if(isset($result) && !empty($result)){
            if(isset($result[0]['url'])){
                 $url = $result[0]['url'];
            }else{
                $url  = "";
            }
            if(isset($result[0]['naam'])){
                 $Name = $result[0]['naam'];
            }else{
                 $Name  = "";
             }

            $array = [
             "name" => $Name,
             "url" =>  $url,
             "arrival" =>  $arrival,
             "departure" =>  $departure,
             ]; 
       
                    if(isset($_COOKIE['collections'])){
                
                        $data     = unserialize($_COOKIE['collections']);
                    
                        $key = array_search(intval($array), $data );
                        
                        if ($key !== false ){
                            unset($data[$key]);
                            setcookie("collections", serialize($data), time() + (3600), "/");
                            $_COOKIE["collections"] = serialize($data);
                            $count = count($data);
                    
                        }else{
                            $data[]  = $array;
                            setcookie("collections", serialize($data), time() + (3600), "/");
                            $_COOKIE["collections"] = serialize($data);
                            $count = count($data);
                        }
                    }else{
                    setcookie("collections", serialize([$array]), time() + (3600), "/");
                    $_COOKIE["collections"] = serialize($array);
                    $count = 1;
                    }
            }
        }
     }


}