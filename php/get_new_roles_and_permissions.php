<?php
require "connect_to_database.php";

$roleName = $_POST['role_name'];

$sql = "SELECT * FROM roles_tbl WHERE role_name = '$roleName' LIMIT 1";
$query = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($query);
echo json_encode($row);
