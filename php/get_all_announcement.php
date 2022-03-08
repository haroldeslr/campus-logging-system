<?php
require "connect_to_database.php";

// fetch data
$sql = mysqli_query($conn, "SELECT * FROM announcements_tbl");

// store data in result variable
$result = mysqli_fetch_all($sql, MYSQLI_ASSOC);

exit(json_encode($result));
?>