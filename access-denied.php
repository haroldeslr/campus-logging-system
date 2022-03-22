<?php
require_once "php/controllerUserData.php";

if ($_SESSION['userIsLogin'] == false) {
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>Access Denied | Campus Logging System</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <link href="css/master.css" rel="stylesheet" />
    <link href="css/access-denied.css" rel="stylesheet" />
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
                    <div class="page vertical-align text-center">
                        <div class="page-content vertical-align-middle">
                            <header>
                                <h1 class="animation-slide-top">403</h1>
                                <p>Access Denied !</p>
                            </header>
                            <p class="error-advise">Contact your system administrator to grant you permission.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
    unset($_SESSION['change-password-status']);
    ?>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.min.js" integrity="sha384-VHvPCCyXqtD5DqJeNxl2dtTyhF78xXNXdkwX1CZeRusQfRKp+tA7hAShOK/B/fQ2" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/solid.min.js" integrity="sha512-+KCv9G3MmyWnFnFrd2+/ccSx5ejo1yED85HZOvNDhtyHu2tuLL8df5BtaLXqsiF68wGLgxxMb4yL5oUyXjqSgw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/fontawesome.min.js" integrity="sha512-ywaT8M9b+VnJ+jNG14UgRaKg+gf8yVBisU2ce+YJrlWwZa9BaZAE5GK5Yd7CBcP6UXoAnziRQl40/u/qwVZi4Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="js/script.js"></script>
</body>

</html>