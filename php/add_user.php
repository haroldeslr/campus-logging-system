<?php
require "connect_to_database.php";

$email = $_POST['email'];
$username = $_POST['username'];
$password = password_hash($_POST['password'], PASSWORD_BCRYPT);
$fullname = $_POST['fullname'];
$type = $_POST['type'];
$role = $_POST['role'];
$code = 0;
$status = "verified";

$selectQuery = "SELECT * FROM user_tbl WHERE username = '$username' OR email = '$email'";

$result = mysqli_query($conn, $selectQuery);
if (mysqli_num_rows($result) > 0) {
    $data = array(
        'status' => 'false',
    );
    echo json_encode($data);
} else {
    $sql = "INSERT INTO user_tbl (username, email, password, fullname, role, type, code, status) VALUES ('$username', '$email', '$password', '$fullname', '$role', '$type', $code, '$status');";

    if ($conn->query($sql) === TRUE) {
        $data = array(
            'status' => 'true',
        );
        echo json_encode($data);
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
