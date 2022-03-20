<?php
require_once "connect_to_database.php";

$username = mysqli_real_escape_string($conn, $_POST['username']);
$password = mysqli_real_escape_string($conn, $_POST['password']);
//query
$check_username = "SELECT * FROM user_tbl WHERE username = '$username'";
//check
$res = mysqli_query($conn, $check_username);
if (mysqli_num_rows($res) > 0) {
    $fetch = mysqli_fetch_assoc($res);
    $fetch_password = $fetch['password'];
    $email = $fetch['email'];
    if (password_verify($password, $fetch_password)) {
        echo "Login Success";
    } else {
        echo "Incorrect username or password";
    }
} else {
    echo "Incorrect username or password";
}
