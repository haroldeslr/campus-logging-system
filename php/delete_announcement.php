<?php 
require "connect_to_database.php";

$announcement_id = $_POST['id'];
$sql = "DELETE FROM announcements_tbl WHERE id = '$announcement_id'";

$delQuery = mysqli_query($conn, $sql);

if($delQuery == true) {
	$data = array(
        'status'=>'success',
    );
     echo json_encode($data);
} else {
    $data = array(
        'status'=>'failed',
    );
    echo json_encode($data);
} 
?>