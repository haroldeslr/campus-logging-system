<?php
require "connect_to_database.php";

// fetch data
$startDate = $_POST['startDate'];
$endDate = $_POST['endDate'];
$sql = "

SELECT *
FROM logs_tbl
WHERE time BETWEEN '$startDate 00:00:00' AND '$endDate 23:59:00';

";

$query = mysqli_query($conn, $sql);
$result = mysqli_fetch_all($query, MYSQLI_ASSOC);
exit(json_encode($result));
