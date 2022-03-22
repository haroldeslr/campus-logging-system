<?php
require "connect_to_database.php";

$selectAllUsersQuery = "SELECT * FROM user_tbl";
$executeQuery = mysqli_query($conn, $selectAllUsersQuery);
$result = mysqli_fetch_all($executeQuery, MYSQLI_ASSOC);
exit(json_encode($result));
