<?php
require "connect_to_database.php";

$date = $_POST['date'];
$title = $_POST['title'];
$message = $_POST['message'];

$sql = "SELECT * FROM announcements_tbl WHERE date = '$date' AND title = '$title' AND message = '$message' LIMIT 1";
$query = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($query);
echo json_encode($row);
