<?php
require "connect_to_database.php";

$id = $_POST['id'];
$sql = "DELETE FROM user_tbl WHERE id = $id";

$delQuery = mysqli_query($conn, $sql);

if ($delQuery == true) {
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
