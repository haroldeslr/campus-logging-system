<?php 
require "connect_to_database.php";

$fullname = $_POST['fullname'];
$age = $_POST['age'];
$gender = $_POST['gender'];
$address = $_POST['address'];
$contactnumber = $_POST['contactnumber'];
$temperature = $_POST['temperature'];
$reason = $_POST['reason'];
$id = $_POST['id'];
$time = $_POST['time'];

$sql = "UPDATE `logs_tbl` SET `full_name`='$fullname', `contact_number`='$contactnumber', `address`='$address', `age`='$age', `temperature`='$temperature', `gender`='$gender', `reason`='$reason', `time`='$time' WHERE id='$id'";
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