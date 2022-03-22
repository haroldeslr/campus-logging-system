<?php
require "connect_to_database.php";

$username = $_POST['username'];
$email = $_POST['email'];

$sql = "SELECT * FROM user_tbl WHERE username = '$username' AND email = '$email' LIMIT 1";
$query = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($query);
echo json_encode($row);
