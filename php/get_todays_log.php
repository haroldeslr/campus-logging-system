<?php
require "connect_to_database.php";

// fetch data
$currentDate = date("Y-m-d");
$sql = "

SELECT *
FROM logs_tbl
WHERE time BETWEEN '$currentDate 00:00:00' AND '$currentDate 23:59:00';

";

$query = mysqli_query($conn, $sql);
$result = mysqli_fetch_all($query, MYSQLI_ASSOC);
exit(json_encode($result));
