<?php
session_start();

$connect = $_SESSION['connect'];
$connectie = new mysqli($connect[0],$connect[1],$connect[2],$connect[3]);

$_REQUEST["zoekterm"]  = preg_replace('/[^a-zA-Z0-9 -]/','', $_REQUEST['zoekterm']);

if(isset($_REQUEST["zoekterm"])){
	$query = 'SELECT * FROM suites WHERE naam LIKE ? order by naam asc';
	
	if($stmt = mysqli_prepare($connectie,$query)){
		$param_zoekterm = '%' . $_REQUEST["zoekterm"] . '%';
		mysqli_stmt_bind_param($stmt,"s", $param_zoekterm);
       
		if(mysqli_stmt_execute($stmt)){
			$result = mysqli_stmt_get_result($stmt);
			if(mysqli_num_rows($result) > 0){
				while($waarde = mysqli_fetch_array($result, MYSQLI_ASSOC)){
					echo '<p>' . $waarde["naam"] . ' -- ' . ucfirst(strtolower($waarde['id'])) . '</p>';
				}
			} 
		} 
	}
	mysqli_stmt_close($stmt);
}
mysqli_close($connectie);
?>
