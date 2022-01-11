<?php 

 function setpArrivelCookie($arrival,$departure){

    $valdate  = validateDate($arrival, 'Y-m-d');
    $valdate2 = validateDate($departure, 'Y-m-d');
    
     if($valdate == true && $valdate2 == true ){         

        $array = [
            "arrival" =>  $arrival,
            "departure" =>  $departure,
        ]; 
    
        setcookie('arrival', serialize($array), time() + (3600 * 24 * 7 ), "/");
        $_COOKIE['arrival'] = serialize($array);
     }
     return unserialize($_COOKIE['arrival']);
 }    

function validateDate($date, $format = 'Y-m-d H:i:s'){
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) == $date;
}


if(!empty($_GET) && isset($_GET["arrival"]) &&  isset($_GET["departure"])){

    $arrival        = $_GET["arrival"];
    $departure      = $_GET["departure"];
    //echo $arrival." ".$departure.">>".date('Y-m-d');die;
    if($arrival<date('Y-m-d') || $departure<date('Y-m-d')){
        $arrival = "";
        $departure = "";
        setcookie('arrival', 'arival', time() - 1 , "/");
    } else {
        $result_cookies = setpArrivelCookie($arrival,$departure);
    }  
}

?>
