<?php
require "connect_to_database.php";

$currentDate = date("Y-m-d");
$fullNameValue = $_POST["full_name"];
$contactNumberValue = $_POST["contact_number"];
$addressValue = $_POST["address"];
$ageValue = $_POST["age"];
$temperatureValue = $_POST["temperature"];
$genderValue = $_POST["gender"];
$reasonValue = $_POST["reason"];
$timeValue = $_POST["time"];

$selectQuery = "SELECT * FROM logs_tbl WHERE full_name = '$fullNameValue' AND contact_number = '$contactNumberValue' AND address = '$addressValue' AND age = $ageValue AND gender = '$genderValue' AND time BETWEEN '$currentDate 00:00:00' AND '$currentDate 23:59:00'";

$result = mysqli_query($conn, $selectQuery);
if (mysqli_num_rows($result) > 0) {
  echo "Log already exist today";
} else {
  $sql = "INSERT INTO logs_tbl (full_name, contact_number, address, age, temperature, gender, reason, time) VALUES ('$fullNameValue', '$contactNumberValue', '$addressValue', $ageValue, $temperatureValue, '$genderValue', '$reasonValue', '$timeValue');";

  if ($conn->query($sql) === TRUE) {
    echo "Add log success";
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
}

$conn->close();
