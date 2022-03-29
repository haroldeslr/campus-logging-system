<?php
// live database config
// $servername = "localhost";
// $username = "id18664230_admin";
// $password = "zZgW/4a]#[+tc~|=";
// $dbname = "id18664230_campus_logging_system";

// local database config
// $servername = "localhost";
// $username = "root";
// $password = "";
// $dbname = "campus_logging_system_db";

// use local database config for development and testing
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "camplog";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
