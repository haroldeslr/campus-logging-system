<?php
require "connect_to_database.php";

$id = $_POST['id'];
$roleName = $_POST['role_name'];

$sql = "DELETE FROM roles_tbl WHERE id = $id";
$updateSql = "UPDATE user_tbl SET role='None' WHERE role = '$roleName'";

$delQuery = mysqli_query($conn, $sql);
$updateQuery = mysqli_query($conn, $updateSql);

if ($delQuery == true && $updateQuery == true) {
    $data = array(
        'status' => 'success',
    );
    echo json_encode($data);
} else {
    $data = array(
        'status' => 'failed',
    );
    echo json_encode($data);
}
