<?php
require "connect_to_database.php";

$fullname = $_POST['fullname'];
$age = $_POST['age'];
$gender = $_POST['gender'];
$address = $_POST['address'];
$contactnumber = $_POST['contactnumber'];
$temperature = $_POST['temperature'];
$reason = $_POST['reason'];
$selectedBuildings = $_POST['selectedbuildings'];
$imageName = "sampleI_image_name.jpg";
$time = $_POST['time'];

$sql = "INSERT INTO `logs_tbl` (`full_name`, `contact_number`, `address`, `age`, `temperature`, `gender`, `reason`, `selected_buildings`, `image_name`, `time`) VALUES ('$fullname', '$contactnumber', '$address', $age, $temperature, '$gender', '$reason', '$selectedBuildings', '$imageName', '$time')";
$query = mysqli_query($conn, $sql);

if ($query == true) {
    $data = array(
        'status' => 'true',
    );

    echo json_encode($data);
} else {
    $data = array(
        'status' => mysqli_error($conn),
    );

    echo json_encode($data);
}
