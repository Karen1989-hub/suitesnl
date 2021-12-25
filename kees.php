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
 
?>