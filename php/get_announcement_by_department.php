<?php
require "connect_to_database.php";

$department = $_POST['department'];

// fetch data
$sql = mysqli_query($conn, "SELECT * FROM announcements_tbl WHERE department = '$department'");

// store data in result variable
$result = mysqli_fetch_all($sql, MYSQLI_ASSOC);

exit(json_encode($result));
