<?php 
// live database config
// $servername = "localhost";
// $username = "id18567046_admin1";
// $password = "9(8y6IUdW]RJ&DX1";
// $dbname = "id18567046_campus_logging_system_db";

// local database config
// $servername = "localhost";
// $username = "root";
// $password = "";
// $dbname = "campus_logging_system_db";

// use local database config for development and testing
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "campus_logging_system_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
