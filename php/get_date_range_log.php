<?php
require "connect_to_database.php";

// fetch data
$startDate = $_POST['startDate'];
$endDate = $_POST['endDate'];
$sql = "

SELECT *
FROM logs_tbl
WHERE time BETWEEN '$startDate' AND '$endDate';

";

$query = mysqli_query($conn, $sql);
$result = mysqli_fetch_all($query, MYSQLI_ASSOC);
exit(json_encode($result));
