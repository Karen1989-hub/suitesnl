 <?php

error_reporting(E_ERROR | E_WARNING | E_PARSE);

function getdb($host='localhost', $db='betterhotels', $user='betterhotels', $pass='Csv9ZXepPVaeMVph'){
	$options = [
		PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
		PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
		PDO::ATTR_EMULATE_PREPARES   => false,
	];

	$dsn = "mysql:host={$host};dbname={$db}";

	$pdo = new PDO($dsn, $user, $pass, $options);
	return $pdo;
}