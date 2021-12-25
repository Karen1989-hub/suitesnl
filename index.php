<?php

session_start();
# Hier defineer je je variabelen ( boven de includes )

$type = 'article';
$url = 'https://www.suites.nl';
$description = 'Omschrijving van de site';
$image = '/images/socialheader.jpg';

$title = 'Dit is de titel van de pagina'; #zie header file voor voorbeeld
$fbtype = 'PageView';


#include __DIR__ . '/include/header.php';





?>

<html lang="nl">
<head>
<meta charset="utf-8">
<title>Hotelsuites via Suites.nl. Superluxe suites - Dagelijks wisselende aanbiedingen - Bubbelbad kamers.</title>
<meta name="description" content="Binnenkort kunt u op deze pagina alle hotelsuites van Nederland reserveren."/>
</head

<body>

<center><h2>Binnenkort kunt u op deze pagina alle hotelsuites van Nederland reserveren.</h2></center>

<br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />


<?php
  $servername = "localhost";
  $username = "betterhotels";
  $password = "Csv9ZXepPVaeMVph";
  $dbname = "betterhotels";

  # connect to the database
  $conn = new mysqli($servername, $username, $password, $dbname);
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }

  # execute a query and output its results
  $sql = "SELECT * FROM suites";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
      // output data of each row
      while($row = $result->fetch_assoc()) {
          echo "<a href='" . $row["url"]. "/'>" . $row["naam"]. "</a><br />";
      }
  } else {
      echo "0 results";
  }

  # execute a query and output its results
  $sql = "SELECT * FROM property";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
      // output data of each row
      while($row = $result->fetch_assoc()) {
          echo "<a href='" . $row["url"]. "/'>" . $row["naam"]. "</a><br />";
      }
  } else {
      echo "0 results";
  }





  $conn->close();

?>r


</body>
</html>