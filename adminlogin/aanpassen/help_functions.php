<?php
$connectie = mysqli_connect($connect[0],$connect[1],$connect[2],$connect[3]);

function testConnection() {
	global $servername, $username, $password, $database, $connectie;

	$query = "SELECT * FROM property WHERE id = 11";
	
	if ($_SESSION['DEBUG']){
		echo 'query is:<br>';
		echo $query.'<br>';
	}

	$result = mysqli_query($connectie, $query);
	
	while ($row = mysqli_fetch_assoc($result)) {
		return $row['naam'];
	}
}

function getHotelId($hotelname, $hotelcity){
	global $servername, $username, $password, $database, $connectie;
	$hotelname = preg_replace('/[\x00-\x1F\x7F-\xFF]/', '%', $hotelname);
	$hotelcity = preg_replace('/[\x00-\x1F\x7F-\xFF]/', '%', $hotelcity);
	$query = "SELECT * FROM hotel WHERE naam LIKE \"%".trim($hotelname)."%\" AND plaats LIKE \"%".trim($hotelcity)."%\"";
	
	if ($_SESSION['DEBUG']){
		echo 'query is:<br>';
		echo $query.'<br>';
	}

	$result = mysqli_query($connectie, $query);
	
	while ($row = mysqli_fetch_assoc($result)) {
		return $row['c'];
	}
}

function getHotelName($hotelid){
	global $servername, $username, $password, $database, $connectie;
	$query = "SELECT * FROM hotel WHERE c = '".$hotelid."'";
	
	if ($_SESSION['DEBUG']){
		echo 'query is:<br>';
		echo $query.'<br>';
	}
	
	$result = mysqli_query($connectie, $query);
	
	while ($row = mysqli_fetch_assoc($result)) {
		return array($row['naam']);
	}
}

function hotelIdFromDeals($rateTypeId){
	global $servername, $username, $password, $database, $connectie;
	$query = "SELECT * FROM specialdeal WHERE rate_type_id = '".$rateTypeId."'";
	
	if ($_SESSION['DEBUG']){
		echo 'query is:<br>';
		echo $query.'<br>';
	}
	
	$result = mysqli_query($connectie, $query);
	
	while ($row = mysqli_fetch_assoc($result)) {
		return array($row['hotel_id']);
	}
}

function getSearchCollections($id){
	global $servername, $username, $password, $database, $connectie;
	$query = "SELECT * FROM suitescollection WHERE suitesid = '".$id."'";
	
	if ($_SESSION['DEBUG']){
		echo 'query is:<br>';
		echo $query.'<br>';
	}
	
	$result = mysqli_query($connectie, $query);
	
	while ($row = mysqli_fetch_assoc($result)) {
		$collections[]=$row['propertyid'];
	}
	if(!empty($collections)){
		return $collections;
	}
}

function reverseSearchCollections($collection){
	global $servername, $username, $password, $database, $connectie;
	$query = "SELECT * FROM search_collection WHERE collection = '".$collection."' ORDER BY id ASC";
	
	if ($_SESSION['DEBUG']){
		echo 'query is:<br>';
		echo $query.'<br>';
	}
	
	$result = mysqli_query($connectie, $query);
	
	while ($row = mysqli_fetch_assoc($result)) {
		$ids[]=$row['id'];
	}
	if(!empty($ids)){
		return $ids;
	}
}

function getLocation($collectionid){
	global $servername, $username, $password, $database, $connectie;
	$query = "SELECT * FROM property WHERE id = ".$collectionid."";
	
	if ($_SESSION['DEBUG']){
		echo 'query is:<br>';
		echo $query.'<br>';
	}
	
	$result = mysqli_query($connectie, $query);
	
	while ($row = mysqli_fetch_assoc($result)) {
		$property[] = $row['naam'];
	}
	return $property;
}

function getDeal($id){
	global $servername, $username, $password, $database, $connectie;
	$query = "SELECT * FROM specialdeal WHERE rate_type_id = ".$id."";
	
	if ($_SESSION['DEBUG']){
		echo 'query is:<br>';
		echo $query.'<br>';
	}
	
	$result = mysqli_query($connectie, $query);
	
	while ($row = mysqli_fetch_assoc($result)) {
		return array($row['title'], $row['rate_type_id']);
	}
}

function getDealId($title){
	global $servername, $username, $password, $database, $connectie;
	$query = "SELECT * FROM specialdeal WHERE title LIKE '%".$title."%'";
	
	if ($_SESSION['DEBUG']){
		echo 'query is:<br>';
		echo $query.'<br>';
	}
	
	$result = mysqli_query($connectie, $query);
	
	while ($row = mysqli_fetch_assoc($result)) {
		return $row['rate_type_id'];
	}
}

function getCollectionId($entity, $type, $name){
	global $servername, $username, $password, $database, $connectie;
	if (strlen($name) < 2){
		return;
	}
	$name = preg_replace('/[\x00-\x1F\x7F-\xFF]/', '%', $name);

	if (is_null($entity)){
		$query = "SELECT * FROM collection
		WHERE type = \"".$type."\" AND name = \"".$name."\"";
	} else {
		$query = "SELECT * FROM collection
		WHERE entity = \"".$entity."\" AND type = \"".$type."\" AND name LIKE \"%".$name."%\"";
	}
	
	if ($_SESSION['DEBUG']){
		echo 'query is:<br>';
		echo $query.'<br>';
	}
	
	$result = mysqli_query($connectie, $query);
	
	while ($row = mysqli_fetch_assoc($result)) {
		return $row['id'];
	}
}

function getRateId($title){
	global $servername, $username, $password, $database, $connectie;
	$query = "SELECT * FROM specialdeal WHERE title LIKE \"%".trim($title)."%\"";
	
	if ($_SESSION['DEBUG']){
		echo 'query is:<br>';
		echo $query.'<br>';
	}
	
	$result = mysqli_query($connectie, $query);
	
	while ($row = mysqli_fetch_assoc($result)) {
		return $row['rate_type_id'];
	}
}

function dataAanpassen($query){
	global $servername, $username, $password, $database, $connectie;

	
	if (mysqli_query($connectie, $query)) {
	  //echo "Data aangepast<br>";
	} else {
	  echo "Error: " . $query . "<br>" . mysqli_error($connectie);
	}
}
?>