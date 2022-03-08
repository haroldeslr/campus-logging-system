<?php 

/*
Server: sql6.freemysqlhosting.net
Name: sql6477119
Username: sql6477119
Password: 2vCwuT3g4f
Port number: 3306
*/

$servername = "sql6.freemysqlhosting.net";
$username = "sql6477119";
$password = "2vCwuT3g4f";
$dbname = "sql6477119";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
?>