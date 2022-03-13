<?php 

// db configuration for live database
// $servername = "localhost";
// $username = "id18567046_admin1";
// $password = "9(8y6IUdW]RJ&DX1";
// $dbname = "id18567046_campus_logging_system_db";

// db configuration for local database / development and testing mode
// $servername = "localhost";
// $username = "root";
// $password = "";
// $dbname = "campus_logging_system_db

// use local database config for development and testing
// dont use db config of live database for testing
$servername = "localhost";
$username = "id18567046_admin1";
$password = "9(8y6IUdW]RJ&DX1";
$dbname = "id18567046_campus_logging_system_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
?>