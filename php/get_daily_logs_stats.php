<?php
require "connect_to_database.php";

// fetch data
$date = $_POST['date'];
$month = $_POST['month'];
$sql = "

SELECT *
FROM logs_tbl
WHERE time BETWEEN '2022-$month-$date 00:00:00' AND '2022-$month-$date 23:59:00';

";

$query = mysqli_query($conn, $sql);
$result = mysqli_fetch_all($query, MYSQLI_ASSOC);
exit(json_encode($result));
?>