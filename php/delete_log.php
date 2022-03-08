<?php 
require "connect_to_database.php";

$log_id = $_POST['id'];
$sql = "DELETE FROM logs_tbl WHERE id = '$log_id'";
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