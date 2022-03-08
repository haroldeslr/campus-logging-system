<?php 
require "connect_to_database.php";

$date = $_POST['date'];
$title = $_POST['title'];
$message = $_POST['message'];
$id = $_POST['id'];

$sql = "UPDATE `announcements_tbl` SET `date`='$date', `title`='$title', `message`='$message' WHERE id='$id'";
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