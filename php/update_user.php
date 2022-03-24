<?php
require "connect_to_database.php";

$id = $_POST['id'];
$username = $_POST['username'];
$fullname = $_POST['fullname'];
$type = $_POST['type'];
$role = $_POST['role'];
$oldUsername = $_POST['old_username'];

$selectQuery = "SELECT * FROM user_tbl WHERE username = '$username'";
$result = mysqli_query($conn, $selectQuery);

if (mysqli_num_rows($result) > 0) {
    if (strtolower($username) == strtolower($oldUsername)) {
        $sql = "UPDATE `user_tbl` SET `username`='$username', `fullname`='$fullname', `type`='$type', `role`='$role' WHERE id='$id'";
        $query = mysqli_query($conn, $sql);

        if ($query == true) {
            $data = array(
                'status' => 'true',
            );
            echo json_encode($data);
        } else {
            $data = array(
                'status' => 'false',
            );
            echo json_encode($data);
        }
    } else {
        // it mean username already exist in other accounts
        $data = array(
            'status' => 'false',
        );
        echo json_encode($data);
    }
} else {
    $sql = "UPDATE `user_tbl` SET `username`='$username', `fullname`='$fullname', `type`='$type', `role`='$role' WHERE id='$id'";
    $query = mysqli_query($conn, $sql);

    if ($query == true) {
        $data = array(
            'status' => 'true',
        );
        echo json_encode($data);
    } else {
        $data = array(
            'status' => 'false',
        );
        echo json_encode($data);
    }
}
