<?php
require "connect_to_database.php";

// fetch data
$year = $_POST['year'];
$sql = "

SELECT *
FROM logs_tbl
WHERE time BETWEEN '$year-01-01 00:00:00' AND '$year-12-31 23:59:00';

";

$query = mysqli_query($conn, $sql);
$result = mysqli_fetch_all($query, MYSQLI_ASSOC);
exit(json_encode($result));
?>