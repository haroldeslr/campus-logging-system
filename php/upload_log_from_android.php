<?php 
require "connect_to_database.php";

$fullNameValue = $_POST["full_name"];
$contactNumberValue = $_POST["contact_number"];
$addressValue = $_POST["address"];
$ageValue = $_POST["age"];
$temperatureValue = $_POST["temperature"];
$genderValue = $_POST["gender"];
$reasonValue = $_POST["reason"];
$timeValue = $_POST["time"];

$sql = "INSERT INTO logs_tbl (full_name, contact_number, address, age, temperature, gender, reason, time) VALUES ('$fullNameValue', '$contactNumberValue', '$addressValue', $ageValue, $temperatureValue, '$genderValue', '$reasonValue', '$timeValue');";

if ($conn->query($sql) === TRUE) {
  echo "New record created successfully";
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>