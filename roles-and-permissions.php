<?php
session_start();
require "php/connect_to_database.php";

if ($_SESSION['userIsLogin'] == false) {
    header('Location: index.php');
    exit();
}

$role = $_SESSION['role'];
if ($role == "None") {
    $_SESSION['open_roles_and_permissions'] = 0;
} else {
    $getRoleDataSql = "SELECT * FROM roles_tbl WHERE role_name = '$role'";
    $roleDataResult = mysqli_query($conn, $getRoleDataSql);

    if (mysqli_num_rows($roleDataResult) > 0) {
        $fetchRoleData = mysqli_fetch_assoc($roleDataResult);

        $_SESSION['open_roles_and_permissions'] = $fetchRoleData['open_roles_and_permissions'];
        $_SESSION['add_roles_and_permissions'] = $fetchRoleData['add_roles_and_permissions'];
        $_SESSION['edit_roles_and_permissions'] = $fetchRoleData['edit_roles_and_permissions'];
        $_SESSION['delete_roles_and_permissions'] = $fetchRoleData['delete_roles_and_permissions'];
    }
}

if ($_SESSION['open_roles_and_permissions'] != 1) {
    header('Location: access-denied.php');
    exit();
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>User Roles | Campus Logging System</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <link rel="stylesheet" href="DataTables/datatables.min.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <link href="css/master.css" rel="stylesheet" />

    <!-- setup log permission -->
    <script type="text/javascript">
        let editRoles = <?php echo $_SESSION['edit_roles_and_permissions'] ?>;
        let deleteRoles = <?php echo $_SESSION['delete_roles_and_permissions'] ?>;
    </script>
</head>

<body>
    <div class="wrapper">
        <!-- sidebar navigation -->
        <nav id="sidebar" class="active">
            <div class="sidebar-header">
                <img src="img/upang-logo.png" alt="upang-log logo" width="135" />
            </div>
            <ul class="list-unstyled components text-secondary">
                <li>
                    <a href="dashboard.php"><i class="fas fa-home"></i> Dashboard</a>
                </li>
                <li>
                    <a href="logbook.php"><i class="fas fa-file-alt"></i> Logbook</a>
                </li>
                <li>
                    <a href="announcement.php"><i class="fas fa-bullhorn"></i> Announcements</a>
                </li>
                <li>
                    <a href="users.php"><i class="fas fa-users"></i> Users</a>
                </li>
                <li>
                    <a href="roles-and-permissions.php"><i class="fas fa-user-shield"></i> Roles & Permissions</a>
                </li>
                <li>
                    <a href="account-profile.php"><i class="fas fa-user"></i> Account Profile</a>
                </li>
            </ul>
        </nav>
        <!-- sidebar navigation -->

        <div id="body" class="active">
            <!-- navbar -->
            <nav class="navbar navbar-expand-lg navbar-white bg-white">
                <button type="button" id="sidebarCollapse" class="btn btn-success default-secondary-menu">
                    <i class="fas fa-bars"></i><span></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="nav navbar-nav ml-auto">
                        <li class="nav-item dropdown">
                            <div class="nav-dropdown">
                                <a href="" class="nav-item nav-link dropdown-toggle text-secondary" data-toggle="dropdown"><i class="fas fa-user"></i> <span>
                                        <?php
                                        echo $_SESSION['username'];
                                        ?>
                                    </span>
                                    <i style="font-size: 0.8em" class="fas fa-caret-down"></i></a>
                                <div class="dropdown-menu dropdown-menu-right nav-link-menu">
                                    <ul class="nav-list">
                                        <li>
                                            <a href="php/logout.php" class="dropdown-item"><i class="fas fa-sign-out-alt"></i> Logout</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
            <!-- navbar -->

            <div class="content">
                <div class="container-fluid">
                    <div class="page-title">
                        <h3>
                            Roles and Permissions
                            <?php
                            if ($_SESSION['add_roles_and_permissions'] == 1) {
                                echo '<a href="roles.html" class="btn btn-sm btn-outline-primary float-right" data-toggle="modal" data-target="#add-roles-modal"><i class="fas fa-plus-circle"></i> Add</a>';
                            }
                            ?>
                        </h3>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-lg-12">
                            <div class="box box-primary">
                                <div class="box-body">
                                    <table width="100%" class="table table-hover" id="roles-and-permissions-table">
                                        <thead>
                                            <tr>
                                                <th>Role Name</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- add roles modal -->
    <div class="modal fade" id="add-roles-modal" tabindex="-1" aria-labelledby="add-roles-modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Role</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="add-roles-and-permissions-form">
                        <div class="form-group">
                            <label for="role-name-input" class="col-form-label">Role Name:</label>
                            <input id="role-name-input" type="text" class="form-control" name="role-name-input" />
                        </div>
                        <div class="form-group">
                            <label class="text-uppercase"><small>Dashboard</small></label>
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="open-dashboard-checkbox" checked />
                                <label class="custom-control-label" for="open-dashboard-checkbox">Open dashboard page</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="text-uppercase"><small>Logbook</small></label>
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="open-logbook-checkbox" checked />
                                <label class="custom-control-label" for="open-logbook-checkbox">Open Logbook Page</label>
                            </div>
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="edit-log-checkbox" />
                                <label class="custom-control-label" for="edit-log-checkbox">Edit Log</label>
                            </div>
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="delete-log-checkbox" />
                                <label class="custom-control-label" for="delete-log-checkbox">Delete Log</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="text-uppercase"><small>Announcement</small></label>
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="open-announcement-checkbox" checked />
                                <label class="custom-control-label" for="open-announcement-checkbox">Open Announcement Page</label>
                            </div>
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="add-announcement-checkbox" />
                                <label class="custom-control-label" for="add-announcement-checkbox">Add Announcement</label>
                            </div>
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="edit-announcement-checkbox" />
                                <label class="custom-control-label" for="edit-announcement-checkbox">Edit Announcement</label>
                            </div>
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="delete-announcement-checkbox" />
                                <label class="custom-control-label" for="delete-announcement-checkbox">Delete Announcement</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="text-uppercase"><small>Users</small></label>
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="open-users-checkbox">
                                <label class="custom-control-label" for="open-users-checkbox">Open Users Page</label>
                            </div>
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="add-users-checkbox" disabled>
                                <label class="custom-control-label" for="add-users-checkbox">Add User</label>
                            </div>
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="edit-users-checkbox" disabled>
                                <label class="custom-control-label" for="edit-users-checkbox">Edit User</label>
                            </div>
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="delete-users-checkbox" disabled>
                                <label class="custom-control-label" for="delete-users-checkbox">Delete User</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="text-uppercase"><small>Roles & Permissions</small></label>
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="open-roles-and-permissions-checkbox">
                                <label class="custom-control-label" for="open-roles-and-permissions-checkbox">Open Roles and Permissions Page</label>
                            </div>
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="add-roles-and-permissions-checkbox" disabled>
                                <label class="custom-control-label" for="add-roles-and-permissions-checkbox">Add Roles</label>
                            </div>
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="edit-roles-and-permissions-checkbox" disabled>
                                <label class="custom-control-label" for="edit-roles-and-permissions-checkbox">Edit Roles</label>
                            </div>
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="delete-roles-and-permissions-checkbox" disabled>
                                <label class="custom-control-label" for="delete-roles-and-permissions-checkbox">Delete Roles</label>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button id="add-role-button" class="btn btn-success"><i class="fas fa-check"></i> Add</button>
                    <a class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Cancel</a>
                </div>
            </div>
        </div>
    </div>
    <!-- add roles modal -->

    <!-- edit roles modal -->
    <div class="modal fade" id="edit-roles-modal" tabindex="-1" aria-labelledby="add-roles-modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Role</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="edit-roles-and-permissions-form">
                        <input id="edited-id" type="hidden" />
                        <div class="form-group">
                            <label for="edit-role-name-input" class="col-form-label">Role Name:</label>
                            <input id="edit-role-name-input" type="text" class="form-control" />
                        </div>
                        <div class="form-group">
                            <label class="text-uppercase"><small>Dashboard</small></label>
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="edit-open-dashboard-checkbox" />
                                <label class="custom-control-label" for="edit-open-dashboard-checkbox">Open dashboard page</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="text-uppercase"><small>Logbook</small></label>
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="edit-open-logbook-checkbox" />
                                <label class="custom-control-label" for="edit-open-logbook-checkbox">Open Logbook Page</label>
                            </div>
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="edit-edit-log-checkbox" />
                                <label class="custom-control-label" for="edit-edit-log-checkbox">Edit Log</label>
                            </div>
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="edit-delete-log-checkbox" />
                                <label class="custom-control-label" for="edit-delete-log-checkbox">Delete Log</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="text-uppercase"><small>Announcement</small></label>
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="edit-open-announcement-checkbox" />
                                <label class="custom-control-label" for="edit-open-announcement-checkbox">Open Announcement Page</label>
                            </div>
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="edit-add-announcement-checkbox" />
                                <label class="custom-control-label" for="edit-add-announcement-checkbox">Add Announcement</label>
                            </div>
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="edit-edit-announcement-checkbox" />
                                <label class="custom-control-label" for="edit-edit-announcement-checkbox">Edit Announcement</label>
                            </div>
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="edit-delete-announcement-checkbox" />
                                <label class="custom-control-label" for="edit-delete-announcement-checkbox">Delete Announcement</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="text-uppercase"><small>Users</small></label>
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="edit-open-users-checkbox">
                                <label class="custom-control-label" for="edit-open-users-checkbox">Open Users Page</label>
                            </div>
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="edit-add-users-checkbox">
                                <label class="custom-control-label" for="edit-add-users-checkbox">Add User</label>
                            </div>
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="edit-edit-users-checkbox">
                                <label class="custom-control-label" for="edit-edit-users-checkbox">Edit User</label>
                            </div>
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="edit-delete-users-checkbox">
                                <label class="custom-control-label" for="edit-delete-users-checkbox">Delete User</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="text-uppercase"><small>Roles & Permissions</small></label>
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="edit-open-roles-and-permissions-checkbox">
                                <label class="custom-control-label" for="edit-open-roles-and-permissions-checkbox">Open Roles and Permissions Page</label>
                            </div>
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="edit-add-roles-and-permissions-checkbox">
                                <label class="custom-control-label" for="edit-add-roles-and-permissions-checkbox">Add Roles</label>
                            </div>
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="edit-edit-roles-and-permissions-checkbox">
                                <label class="custom-control-label" for="edit-edit-roles-and-permissions-checkbox">Edit Roles</label>
                            </div>
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="edit-delete-roles-and-permissions-checkbox">
                                <label class="custom-control-label" for="edit-delete-roles-and-permissions-checkbox">Delete Roles</label>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button id="edit-roles-modal-button" class="btn btn-success"><i class="fas fa-check"></i> Edit</button>
                    <a class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Cancel</a>
                </div>
            </div>
        </div>
    </div>
    <!-- edit roles modal -->

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.min.js" integrity="sha384-VHvPCCyXqtD5DqJeNxl2dtTyhF78xXNXdkwX1CZeRusQfRKp+tA7hAShOK/B/fQ2" crossorigin="anonymous"></script>
    <script src="DataTables/datatables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/solid.min.js" integrity="sha512-+KCv9G3MmyWnFnFrd2+/ccSx5ejo1yED85HZOvNDhtyHu2tuLL8df5BtaLXqsiF68wGLgxxMb4yL5oUyXjqSgw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/fontawesome.min.js" integrity="sha512-ywaT8M9b+VnJ+jNG14UgRaKg+gf8yVBisU2ce+YJrlWwZa9BaZAE5GK5Yd7CBcP6UXoAnziRQl40/u/qwVZi4Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="js/roles-and-permissions.js"></script>
    <script src="js/script.js"></script>
</body>

</html>