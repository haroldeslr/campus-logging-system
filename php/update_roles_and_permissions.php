<?php
require "connect_to_database.php";

$id = $_POST['id'];
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
$oldRoleName = $_POST['old_role_name'];

$selectQuery = "SELECT * FROM roles_tbl WHERE role_name = '$roleName'";
$result = mysqli_query($conn, $selectQuery);

if (mysqli_num_rows($result) > 0) {
    if (strtolower($roleName) == strtolower($oldRoleName)) {
        $sql = "UPDATE roles_tbl SET role_name='$roleName', open_dashboard=$openDashboard, open_logbook=$openLogbook, edit_log=$editLog, delete_log=$deleteLog, open_announcement=$openAnnouncement, add_announcement=$addAnnouncement, edit_announcement=$editAnnouncement, delete_announcement=$deleteAnnouncement, open_users=$openUsers, add_users=$addUsers, edit_users=$editUsers, delete_users=$deleteUsers, open_roles_and_permissions=$openRolesAndPermissions, add_roles_and_permissions=$addRolesAndPermissions, edit_roles_and_permissions=$editRolesAndPermissions, delete_roles_and_permissions=$deleteRolesAndPermissions WHERE id=$id";
        $updateUserRoleSql = "UPDATE user_tbl SET role='$roleName' WHERE role='$oldRoleName'";

        $query = mysqli_query($conn, $sql);
        $updateUserRoleQuery = mysqli_query($conn, $updateUserRoleSql);

        if ($query == true && $updateUserRoleQuery == true) {
            $data = array(
                'status' => 'true',
            );
            echo json_encode($data);
        } else {
            $data = array(
                'status' => mysqli_error($conn),
            );
            echo json_encode($data);
        }
    } else {
        // role name already exist
        $data = array(
            'status' => 'false',
        );
        echo json_encode($data);
    }
} else {
    $sql = "UPDATE roles_tbl SET role_name='$roleName', open_dashboard=$openDashboard, open_logbook=$openLogbook, edit_log=$editLog, delete_log=$deleteLog, open_announcement=$openAnnouncement, add_announcement=$addAnnouncement, edit_announcement=$editAnnouncement, delete_announcement=$deleteAnnouncement, open_users=$openUsers, add_users=$addUsers, edit_users=$editUsers, delete_users=$deleteUsers, open_roles_and_permissions=$openRolesAndPermissions, add_roles_and_permissions=$addRolesAndPermissions, edit_roles_and_permissions=$editRolesAndPermissions, delete_roles_and_permissions=$deleteRolesAndPermissions WHERE id=$id";
    $updateUserRoleSql = "UPDATE user_tbl SET role='$roleName' WHERE role='$oldRoleName'";

    $query = mysqli_query($conn, $sql);
    $updateUserRoleQuery = mysqli_query($conn, $updateUserRoleSql);

    if ($query == true && $updateUserRoleQuery == true) {
        $data = array(
            'status' => 'true',
        );
        echo json_encode($data);
    } else {
        $data = array(
            'status' => mysqli_error($conn),
        );
        echo json_encode($data);
    }
}

$conn->close();
