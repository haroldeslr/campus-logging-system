<?php 
require "connect_to_database.php";

$selectQuery = "SELECT * FROM roles_tbl";
$executeQuery = mysqli_query($conn, $selectQuery);
$result = mysqli_fetch_all($executeQuery, MYSQLI_ASSOC);
exit(json_encode($result));
