<?php 
require "connect_to_database.php";

$date = $_POST['date'];
$title = $_POST['title'];
$message = $_POST['message'];

$sql = "INSERT INTO `announcements_tbl` (`date`, `title`, `message`) VALUES ('$date', '$title', '$message')";
$query = mysqli_query($conn, $sql);

if ($query == true) {
    $data = array(
        'status'=>'true',
    );
    echo json_encode($data);
} else {
    $data = array(
        'status'=>'false',
    );
    echo json_encode($data);
} 
?>