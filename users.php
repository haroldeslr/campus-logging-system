<?php
session_start();
require "php/connect_to_database.php";

if ($_SESSION['userIsLogin'] == false) {
    header('Location: index.php');
    exit();
}

$username = $_SESSION['username'];
$email = $_SESSION['email'];

$getUserRoleSql = "SELECT * FROM user_tbl WHERE username = '$username' AND email = '$email'";
$userDataResult = mysqli_query($conn, $getUserRoleSql);

if (mysqli_num_rows($userDataResult) > 0) {
    $fetchUserData = mysqli_fetch_assoc($userDataResult);
    $role = $fetchUserData['role'];
    $_SESSION['role'] = $role;

    if ($role == "None") {
        $_SESSION['open_users'] = 0;
    } else {
        $getRoleDataSql = "SELECT * FROM roles_tbl WHERE role_name = '$role'";
        $roleDataResult = mysqli_query($conn, $getRoleDataSql);

        if (mysqli_num_rows($roleDataResult) > 0) {
            $fetchRoleData = mysqli_fetch_assoc($roleDataResult);

            $_SESSION['open_users'] = $fetchRoleData['open_users'];
            $_SESSION['add_users'] = $fetchRoleData['add_users'];
            $_SESSION['edit_users'] = $fetchRoleData['edit_users'];
            $_SESSION['delete_users'] = $fetchRoleData['delete_users'];
        }
    }
}

if ($_SESSION['open_users'] != 1) {
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
    <link rel="icon" href="img/adminlogo.png">

    <title>Users | Campus Logging System</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <link rel="stylesheet" href="DataTables/datatables.min.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <link href="css/master.css" rel="stylesheet" />

    <!-- setup log permission -->
    <script type="text/javascript">
        let editUsers = <?php echo $_SESSION['edit_users'] ?>;
        let deleteUsers = <?php echo $_SESSION['delete_users'] ?>;
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
                            Users
                            <?php
                            if ($_SESSION['add_users'] == 1) {
                                echo '<a id="add-user-button" class="btn btn-sm btn-outline-primary float-right" data-toggle="modal" data-target="#add-user-modal"><i class="fas fa-users"></i> Add</a>';
                            }
                            ?>
                        </h3>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-12 col-lg-12">
                            <div class="box box-primary">
                                <div class="box-body">
                                    <table width="100%" class="table table-hover" id="users-table">
                                        <thead>
                                            <tr>
                                                <th>Full Name</th>
                                                <th>Username</th>
                                                <th>Email</th>
                                                <th>Role</th>
                                                <th>Type</th>
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

    <!-- add user modal -->
    <div class="modal fade" id="add-user-modal" tabindex="-1" aria-labelledby="add-user-modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="add-user-form" novalidate accept-charset="utf-8">
                        <div class="form-group">
                            <label for="email-input">Email</label>
                            <input type="email" class="form-control" name="email-input" id="email-input" placeholder="Email" required>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="username-input">Username</label>
                                <input type="text" class="form-control" name="username-input" id="username-input" placeholder="Username" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="password-input">Password</label>
                                <input type="password" class="form-control" name="password-input" id="password-input" placeholder="Password" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="fullname-input">Full Name</label>
                            <input type="text" class="form-control" id="fullname-input" placeholder="Full Name" required>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="type-input">Type</label>
                                <input type="text" class="form-control" name="type-input" id="type-input" placeholder="Type" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="role-select">Role</label>
                                <select name="role-select" class="form-control" id="role-select" required>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button id="add-user-modal-button" type="button" class="btn btn-primary">
                        <i class="fas fa-users"></i> Add
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- add user modal -->

    <!-- edit user modal -->
    <div class="modal fade" id="edit-user-modal" tabindex="-1" aria-labelledby="add-user-modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="edit-user-form" novalidate accept-charset="utf-8">
                        <input id="edited-id" type="hidden" />
                        <div class="form-group">
                            <label for="edit-username-input">Username</label>
                            <input type="text" class="form-control" id="edit-username-input" placeholder="Username" required>
                        </div>
                        <div class="form-group">
                            <label for="edit-fullname-input">Fullname</label>
                            <input type="text" class="form-control" id="edit-fullname-input" placeholder="Full Name" required>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="edit-type-input">Type</label>
                                <input type="text" class="form-control" id="edit-type-input" placeholder="Type" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="edit-role-select">Role</label>
                                <select class="form-control" id="edit-role-select" required>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button id="edit-user-modal-button" type="button" class="btn btn-primary">
                        <i class="fas fa-users"></i> Save
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- edit user modal -->

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.min.js" integrity="sha384-VHvPCCyXqtD5DqJeNxl2dtTyhF78xXNXdkwX1CZeRusQfRKp+tA7hAShOK/B/fQ2" crossorigin="anonymous"></script>
    <script src="DataTables/datatables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/solid.min.js" integrity="sha512-+KCv9G3MmyWnFnFrd2+/ccSx5ejo1yED85HZOvNDhtyHu2tuLL8df5BtaLXqsiF68wGLgxxMb4yL5oUyXjqSgw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/fontawesome.min.js" integrity="sha512-ywaT8M9b+VnJ+jNG14UgRaKg+gf8yVBisU2ce+YJrlWwZa9BaZAE5GK5Yd7CBcP6UXoAnziRQl40/u/qwVZi4Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="js/users.js"></script>
    <script src="js/script.js"></script>
</body>

</html>