<?php 
require "connect_to_database.php";

$time = $_POST['time'];
$sql = "SELECT * FROM logs_tbl WHERE time='$time' LIMIT 1";
$query = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($query);
echo json_encode($row);
?>