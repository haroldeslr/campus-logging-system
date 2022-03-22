<?php
require "connect_to_database.php";

$roleName = $_POST['role_name'];
$openDashboard = $_POST['open_dashboard'];
$openLogbook = $_POST['open_loogbook'];
$editLog = $_POST['edit_log'];
$deleteLog = $_POST['delete_log'];
$openAnnouncement = $_POST['open_announcement'];
$addAnnouncement = $_POST['add_announcement'];
$editAnnouncement = $_POST['edit_announcement'];
$deleteAnnouncement = $_POST['delete_announcement'];
$openUsers = $_POST['open_users'];
$addUsers = $_POST['add_users'];
$editUsers = $_POST['edit_users'];
$deleteUsers = $_POST['delete_users'];
$openRolesAndPermissions = $_POST['open_roles_and_permissions'];
$addRolesAndPermissions = $_POST['add_roles_and_permissions'];
$editRolesAndPermissions = $_POST['edit_roles_and_permissions'];
$deleteRolesAndPermissions = $_POST['delete_roles_and_permissions'];

$selectQuery = "SELECT * FROM roles_tbl WHERE role_name = '$roleName'";
$result = mysqli_query($conn, $selectQuery);

if (mysqli_num_rows($result) > 0) {
    $data = array(
        'status' => 'false',
    );
    echo json_encode($data);
} else {
    $insertQuery = "INSERT INTO roles_tbl (role_name, open_dashboard, open_logbook,	edit_log, delete_log, open_announcement, add_announcement, edit_announcement, delete_announcement, open_users, add_users, edit_users, delete_users,	open_roles_and_permissions, add_roles_and_permissions, edit_roles_and_permissions, delete_roles_and_permissions) VALUES ('$roleName', $openDashboard, $openLogbook, $editLog, $deleteLog, $openAnnouncement, $addAnnouncement, $editAnnouncement, $deleteAnnouncement, $openUsers, $addUsers, $editUsers, $deleteUsers, $openRolesAndPermissions, $addRolesAndPermissions, $editRolesAndPermissions, $deleteRolesAndPermissions);";

    if ($conn->query($insertQuery) === TRUE) {
        $data = array(
            'status' => 'true',
        );
        echo json_encode($data);
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
