<?php
//Here we retrieve the relevant pois for an hotel to help writing the hotel descriptions

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!isset($db)) {
    include './include/db.php';
    $db = getdb();
}

$property_id = isset($_GET['property']) ? $_GET['property'] : "";
if(empty($property_id)){
    $property_id = isset($id) ? $id: $propertyid;
}


if (isset($property_id)){

	function getAllPoisByIdAndType($id, $type, $distance, $limit) {

		global $db;
		
		$sql = "SELECT poi.id,
			poi.name, poi.cuisine,
			poi.lat, poi.lon,
			ROUND (p.distance_unit
					 * DEGREES(ACOS(LEAST(1.0, COS(RADIANS(p.latpoint))
					 * COS(RADIANS(poi.lat))
					 * COS(RADIANS(p.longpoint) - RADIANS(poi.lon))
					 + SIN(RADIANS(p.latpoint))
					 * SIN(RADIANS(poi.lat))))), 2) AS distance_in_km
			FROM poi
			JOIN (   
				SELECT  property.lat  AS latpoint,  property.lon AS longpoint,
						:distance AS radius,      111.045 AS distance_unit
				FROM property
				WHERE property.id = :id
				) AS p ON 1=1
			WHERE poi.lat
				BETWEEN p.latpoint  - (p.radius / p.distance_unit)
					AND p.latpoint  + (p.radius / p.distance_unit)
			AND poi.lon
				 BETWEEN p.longpoint - (p.radius / (p.distance_unit * COS(RADIANS(p.latpoint))))
					 AND p.longpoint + (p.radius / (p.distance_unit * COS(RADIANS(p.latpoint))))
			AND poi.type = :type
			ORDER BY distance_in_km
			LIMIT :limit";
			
		$stmt = $db->prepare($sql); 
		$stmt->execute([
			"id"  => $id,
			"type" => $type,
			"distance" => $distance,
			"limit" => $limit,
		]);  
			
		$result = $stmt->fetchAll(\PDO::FETCH_ASSOC);  

		return $result;
			
	}

	$restaurants = getAllPoisByIdAndType($property_id, 'restaurant', 10.0, 10);
	if (!empty($restaurants)) {
		echo '<b>Restaurants nearby:<br></b>';
		foreach ($restaurants as $rest) {
			echo '- ' . $rest['distance_in_km'] . 'km' . ' ' . $rest['name'] . ' -- ' . $rest['cuisine'] . '<br>';
		}
		echo '<br>';
	}
	
	$musea = getAllPoisByIdAndType($property_id, 'museum', 25.0, 20);
	if (!empty($musea)) {
		echo '<b>Musea nearby:<br></b>';
		foreach ($musea as $museum) {
			echo '- ' . $museum['distance_in_km'] . 'km' . ' ' . $museum['name'] . '<br>';
		}
		echo '<br>';
	}
	
	$bars = getAllPoisByIdAndType($property_id, 'bar', 3.0, 20);
	if (!empty($bars)) {
		echo '<b>Bars nearby:<br></b>';
		foreach ($bars as $bar) {
			echo '- ' . $bar['distance_in_km'] . 'km' . ' ' . $bar['name'] . '<br>';
		}
		echo '<br>';
	}
	
	$cafes = getAllPoisByIdAndType($property_id, 'cafe', 3.0, 10);
	if (!empty($cafes)) {
		echo '<b>cafes nearby:<br></b>';
		foreach ($cafes as $cafe) {
			echo '- ' . $cafe['distance_in_km'] . 'km' . ' ' . $cafe['name'] . '<br>';
		}
		echo '<br>';
	}
	
	$casinos = getAllPoisByIdAndType($property_id, 'casino', 15.0, 3);
	if (!empty($casinos)) {
		echo '<b>Casinos nearby:<br></b>';
		foreach ($casinos as $casino) {
			echo '- ' . $casino['distance_in_km'] . 'km' . ' ' . $casino['name'] . '<br>';
		}
		echo '<br>';
	}
	
	$zoos = getAllPoisByIdAndType($property_id, 'zoo', 15.0, 3);
	if (!empty($zoos)) {
		echo '<b>Zoo nearby:<br></b>';
		foreach ($zoos as $zoo) {
			echo '- ' . $zoo['distance_in_km'] . 'km' . ' ' . $zoo['name'] . '<br>';
		}
		echo '<br>';
	}
	
	$parking = getAllPoisByIdAndType($property_id, 'parking_entrance', 1.0, 5);
	if (!empty($parking)) {
		echo '<b>Parking Garages nearby:<br></b>';
		foreach ($parking as $park) {
			echo '- ' . $park['distance_in_km'] . 'km' . ' ' . $park['name'] . '<br>';
		}
		echo '<br>';
	}
	
	$cinemas = getAllPoisByIdAndType($property_id, 'cinema', 5.0, 3);
	if (!empty($cinemas)) {
		echo '<b>Cinemas nearby:<br></b>';
		foreach ($cinemas as $cinema) {
			echo '- ' . $cinema['distance_in_km'] . 'km' . ' ' . $cinema['name'] . '<br>';
		}
		echo '<br>';
	}
	
	$theatres = getAllPoisByIdAndType($property_id, 'theatre', 3.0, 3);
	if (!empty($theatres)) {
		echo '<b>Theatres nearby:<br></b>';
		foreach ($theatres as $theatre) {
			echo '- ' . $theatre['distance_in_km'] . 'km' . ' ' . $theatre['name'] . '<br>';
		}
		echo '<br>';
	}
	
	$themeparks = getAllPoisByIdAndType($property_id, 'theme_park', 15.0, 3);
	if (!empty($themeparks)) {
		echo '<b>Theme parks nearby:<br></b>';
		foreach ($themeparks as $themepark) {
			echo '- ' . $themepark['distance_in_km'] . 'km' . ' ' . $themepark['name'] . '<br>';
		}
		echo '<br>';
	}
	
	$atms = getAllPoisByIdAndType($property_id, 'atm', 1.0, 2);
	if (!empty($atms)) {
		echo '<b>ATMs nearby:<br></b>';
		foreach ($atms as $atm) {
			echo '- ' . $atm['distance_in_km'] . 'km' . ' ' . $atm['name'] . '<br>';
		}
		echo '<br>';
	}

}
?>