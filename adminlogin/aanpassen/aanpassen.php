<?php
session_start();
$_SESSION['DEBUG'] = false;
if ($_SESSION['DEBUG']){
	echo '<p style="color: red">DEBUG on</p>';
}

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$servername = 'localhost'; //201 dev, 89 master
$username = 'betterhotels';
$password = 'Csv9ZXepPVaeMVph';
$database = 'betterhotels';
$connect = [$servername, $username, $password, $database];
$_SESSION['connect'] = $connect;

include('help_functions.php');
?> 

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Suites aanpassen</title>
	<link sizes="16x16" rel="icon" type="image/jpg" href="/assets/images/png/favicon-192x192.png">
	<style type="text/css">
	<?php include('style.css');?>
	</style>
	<script src="jquery.js"></script>
	<script type="text/javascript">
	$(document).ready(function(){
		$('.search-box input[type="text"]').on("keyup", function(){

			var inputVal = $(this).val();
			var resultDropdown = $(this).siblings(".result");
			
			if(inputVal.length){
				$.get("entity_zoeken.php", {zoekterm: inputVal}).done(function(data){
					resultDropdown.html(data);
				});
			} else{
				resultDropdown.empty();
			}
		});
		
		$(document).on("click", ".result p", function(){
			$(this).parents(".search-box").find('input[type="text"]').val($(this).text());
			$(this).parent(".result").empty();
		});
		
		$('.search-box2 input[type="text"]').on("keyup", function(){

			var inputVal2 = $(this).val();
			var resultDropdown2 = $(this).siblings(".result2");

			if(inputVal2.length){
				$.get("type_zoeken.php", {zoekterm2: inputVal2}).done(function(data){
					resultDropdown2.html(data);
				});
			} else{
				resultDropdown2.empty();
			}
		});
		
		$(document).on("click", ".result2 p", function(){
			$(this).parents(".search-box2").find('input[type="text"]').val($(this).text());
			$(this).parent(".result2").empty();
		});
	});
	</script>

</head>
<?php
if (isset($_POST['entitySoort'])) {
	$entitySoort = $_POST['entitySoort'];
}
if (isset($_POST['type'])) {
	$type = $_POST['type'];
	$_SESSION['type'] = $_POST['type'];

	if ($entity == 'rateid'){
		$entity = 'rate';
		$entitySplit = explode(' -- ', $entitySoort, 2);
		$entitySoort = $entitySplit[1];
	}
	if ($entity == 'hotelid'){
		$entity = 'hotel';
		$entitySplit = explode(' -- ', $entitySoort, 2);
		$entitySoort = $entitySplit[1];
	}
}
if (isset($_POST['waarde'])) {
	$waarde = $_POST['waarde'];
}

if (isset($_POST['select'])){
	$entitysplit = explode(' -- ', $entitySoort);
	$id = $entitysplit[1];
	$waarde = $_POST['waarde'];	
	$waardesplit = explode(' -- ', $waarde);
	$type_id = $waardesplit[1];

	$insert = "INSERT INTO suitescollection
	VALUES ('".$type_id."','".$id."')";

	if (!empty($type_id) && !empty($id)){
		echo $waarde.' toegevoegd aan '.$entitySoort.'<br>';
		if (!$_SESSION['DEBUG']){
			dataAanpassen($insert);
		} else {
			echo $insert."<br>";
		}
	}
}
if (isset($_POST['delete'])){
	$delete = $_POST['delete'];
	$locid = explode(' ++ ', ($delete));
	
	$id = explode(' -- ', $entitySoort)[1];

	
	echo $locid[0].' verwijderd van '.$entitySoort.'<br>';
	$delete = "DELETE FROM suitescollection WHERE propertyid = '".$locid[1]."' AND suitesid = '".$id."'";
	if (!$_SESSION['DEBUG']){
		dataAanpassen($delete);
	} else {
		echo $delete.'<br>';
	}
}
if(((isset($_POST['submit']) || isset($_POST['select']) || isset($_POST['delete'])) && isset($_POST['entitySoort']))){
	$titel = $_POST['entitySoort'];
	$titelsplit = explode(' -- ', $titel);
	$titelid = $titelsplit[1];
	$collections = getSearchCollections($titelid);
	if ($collections) {
		$totaal = count($collections);
	} else {
		$totaal = 0;
	}
	for ($i = 0; $i<$totaal; $i++){
		$locations[$i] = getLocation($collections[$i]);
	}
	
	$tableGenerator = "";
	$iterator = 0;
	$tableRows = 0;
	if(!empty($locations)){
		if ((end($titelsplit)) == $titelid || $titelsplit[0] == $titelid){
			$tableGenerator .= "<caption>".$titel."</caption>";
		} else {
			$tableGenerator .= "<caption>".$titelid." - ".$titel."</caption>";
		}
		foreach ($locations as $location){
			if(!empty($location)){
				if (strpos($location[0], '\'') !== false ){
					$location[0] = substr($location[0], 1);
				}
				if (($tableRows % 3) == 0){
					if ($tableRows != 0){
						$tableGenerator .= "</tr>";
					}
					$tableGenerator .= "<tr>";
				}

				$tableGenerator .= "<td>".$location[0];
				if (!empty($location[1])){
					$tableGenerator .= "  (".$location[1].") ";
				}
				$tableGenerator .= "<button type='submit' ";
				$tableGenerator .= "name='delete' value='".$location[0]." ++ ";
				$tableGenerator .= $collections[$iterator]."'>Delete</button></td>";

				$iterator++;
				$tableRows++;
			}
		}
		$tableGenerator .= "</tr>";
	}
	else{
		if (!empty($titelid)){
			$tableGenerator .= "<th>".$titelid." - ".$titel."</th>";
		}
		$tableGenerator .= "<tr><td>geen locaties</td></tr>";
	}
}
?>

<h1>Zoek suites in</h1>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	<div class="search-box">
		<input name="entitySoort" type="text" autocomplete="off" placeholder=
		"Zoek property..." required/>
		<br><br>

		<input name="submit" type ="submit" value="selecteren">
		<div class="result">
		</div>
	</div>
</form>

<?php if ((isset($_POST['entitySoort']))){ ?>
<form method="post" onSubmit="return confirm('invoegen?')"
action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <input type="hidden" name="entitySoort" value="<?php echo $entitySoort; ?>"/>
	<input type="hidden" name="tableGenerator" value="<?php echo $tableGenerator; ?>"/>
	
	<table CELLSPACING=0 CELLPADDING=5>
		<?php if (isset($tableGenerator)) {echo $tableGenerator;}?>
	</table>
	<br>
	<div class="search-box2">
		<div class="result2">
		</div>
		<input  type="text" name="waarde" autocomplete="off" placeholder=
		"Zoek property..." />
		<br><br>
		<input type="submit" name ="select" value="invoegen">
	</div>
</form>

<?php } ?>

<br><hr><br>
<a href="aanpassen.php">Refresh</a><br><br>

</body>
</html>