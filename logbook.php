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
    $_SESSION['open_logbook'] = 0;
  } else {
    $getRoleDataSql = "SELECT * FROM roles_tbl WHERE role_name = '$role'";
    $roleDataResult = mysqli_query($conn, $getRoleDataSql);

    if (mysqli_num_rows($roleDataResult) > 0) {
      $fetchRoleData = mysqli_fetch_assoc($roleDataResult);

      $_SESSION['open_logbook'] = $fetchRoleData['open_logbook'];
      $_SESSION['edit_log'] = $fetchRoleData['edit_log'];
      $_SESSION['delete_log'] = $fetchRoleData['delete_log'];
    }
  }
}

if ($_SESSION['open_logbook'] != 1) {
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

  <title>Logbook | Campus Logging System</title>

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
  <link rel="stylesheet" href="DataTables/datatables.min.css" />
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
  <link href="css/master.css" rel="stylesheet" />

  <!-- setup log permission -->
  <script type="text/javascript">
    let editLog = <?php echo $_SESSION['edit_log'] ?>;
    let deleteLog = <?php echo $_SESSION['delete_log'] ?>;
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
          <a href="roles-and-permissions.php"><i class="fas fa-user-shield"></i>Department Management</a>
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
              Logbook
              <!-- <a id="add-log-button" href="#" class="btn btn-sm btn-outline-primary float-right"><i class="fas fa-file-alt"></i> Add Log</a> -->
            </h3>
          </div>
          <div class="row mb-3">
            <div class="col-md-6">
              <h5>Date and Time Range Picker</h5>
              <div id="reportrange" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                <i class="fa fa-calendar"></i>&nbsp;
                <span></span> <i class="fa fa-caret-down"></i>
              </div>
            </div>
          </div>
          <div class="row mb-4">
            <div class="col-md-12 col-lg-12">
              <div class="card">
                <div class="card-header">Logbook Table</div>
                <div class="card-body">
                  <p class="card-title"></p>
                  <table class="table table-hover" id="logbook-table" width="100%">
                    <thead>
                      <tr>
                        <th>Log in</th>
                        <th>Full Name</th>
                        <th>Address</th>
                        <th>Age</th>
                        <th>Temperature</th>
                        <th>Gender</th>
                        <th>Purpose</th>
                        <th>Target Location</th>
                        <th>Contact Number</th>
                        <th>Log Out</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody></tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal for edit log record -->
  <div class="modal fade" id="edit-log-modal" tabindex="-1" aria-labelledby="edit-log-modalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit Log Record</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="d-flex justify-content-center">
            <!-- set ko na size dito sa html para kahit dito na iset -->
            <img id="selfie-img" src="php/imageupload/selfie_image.png" alt="Visitors Selfie" width="200" height="200" />
          </div>
          <form>
            <input id="edited-id" name="edited-id" type="hidden" />
            <input id="edited-time" name="edited-time" type="hidden" />
            <div class="form-group">
              <label for="fullname" class="col-form-label">Full Name</label>
              <input type="text" class="form-control" maxlength="70" name="edited-fullname" id="edited-fullname" />
            </div>
            <div class="form-group">
              <label for="Age" class="col-form-label">Age</label>
              <input type="number" class="form-control" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="2" id="edited-age" name="edited-age" />
            </div>
            <div class="form-group">
              <label for="Age" class="col-form-label">Gender</label>
              <select class="custom-select" aria-label=".form-select-lg example" name="edited-gender" id="edited-gender">
                <option value="Male">Male</option>
                <option value="Female">Female</option>
              </select>
            </div>
            <div class="form-group">
              <label for="Age" class="col-form-label">Address</label>
              <input type="text" class="form-control" maxlength="70" id="edited-address" name="edited-address" />
            </div>
            <div class="form-group">
              <label for="Age" class="col-form-label">Contact Number</label>
              <input type="number" class="form-control" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="12" id="edited-contactnumber" name="edited-contactnumber" />
            </div>
            <div class="form-group">
              <label for="Age" class="col-form-label">Temperature</label>
              <input type="number" class="form-control" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="5" id="edited-temp" name="edited-temp" />
            </div>
            <div class="form-group">
              <label for="Age" class="col-form-label">Purpose</label>
              <select class="custom-select" aria-label=".form-select-lg example" name="edited-reason" id="edited-reason">
                <option value="Inquire">Inquire</option>
                <option value="Modules">Modules</option>
                <option value="Tuition">Tuition</option>
                <option value="School Requirements">
                  School Requirements
                </option>
                <option value="Others">Others</option>
              </select>
            </div>
            <div class="form-group">
              <label for="Age" class="col-form-label">Target Location</label>
              <textarea class="form-control" id="edited-target-location" rows="3" disabled>
              </textarea>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary update-log-button">
            Update Log
          </button>
        </div>
      </div>
    </div>
  </div>
  <!-- Modal for edit log record -->

  <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.min.js" integrity="sha384-VHvPCCyXqtD5DqJeNxl2dtTyhF78xXNXdkwX1CZeRusQfRKp+tA7hAShOK/B/fQ2" crossorigin="anonymous"></script>
  <script src="DataTables/datatables.min.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/solid.min.js" integrity="sha512-+KCv9G3MmyWnFnFrd2+/ccSx5ejo1yED85HZOvNDhtyHu2tuLL8df5BtaLXqsiF68wGLgxxMb4yL5oUyXjqSgw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/fontawesome.min.js" integrity="sha512-ywaT8M9b+VnJ+jNG14UgRaKg+gf8yVBisU2ce+YJrlWwZa9BaZAE5GK5Yd7CBcP6UXoAnziRQl40/u/qwVZi4Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
  <script src="js/logbook.js"></script>
  <script src="js/script.js"></script>

  <!-- delete this later -->
  <!-- <script src="./test-files/add-log.js"></script> -->
</body>

</html>