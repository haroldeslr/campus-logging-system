<?php
session_start();

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

  <title>Logbook | Campus Logging System</title>

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
  <link rel="stylesheet" href="DataTables/datatables.min.css" />
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
  <link href="css/master.css" rel="stylesheet" />
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
          <a href="account-settings.php"><i class="fas fa-user"></i> Account Settings</a>
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
                <a href="" class="nav-item nav-link dropdown-toggle text-secondary" data-toggle="dropdown"><i class="fas fa-user"></i> <span>Admin</span>
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
              <!-- <a
                  id="add-log-button"
                  href="#"
                  class="btn btn-sm btn-outline-primary float-right"
                  ><i class="fas fa-file-alt"></i> Add Log</a
                > -->
            </h3>
          </div>
          <div class="row mb-3">
            <div class="col-md-12">
              <h5>Select start date and end date to show log</h5>
              <input type="text" name="daterange" size="25" />
            </div>
          </div>
          <div class="row">
            <div class="col-md-12 col-lg-12">
              <div class="card">
                <div class="card-header">Logbook Table</div>
                <div class="card-body">
                  <p class="card-title"></p>
                  <table class="table table-hover" id="logbook-table" width="100%">
                    <thead>
                      <tr>
                        <th>Time</th>
                        <th>Full Name</th>
                        <th>Address</th>
                        <th>Age</th>
                        <th>Temperature</th>
                        <th>Gender</th>
                        <th>Purpose</th>
                        <th>Contact Number</th>
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
          <form>
            <input id="edited-id" name="edited-id" type="hidden" />
            <input id="edited-time" name="edited-time" type="hidden" />
            <div class="form-group">
              <label for="fullname" class="col-form-label">Full Name</label>
              <input type="text" class="form-control" name="edited-fullname" id="edited-fullname" />
            </div>
            <div class="form-group">
              <label for="Age" class="col-form-label">Age</label>
              <input type="text" class="form-control" id="edited-age" name="edited-age" />
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
              <input type="text" class="form-control" id="edited-address" name="edited-address" />
            </div>
            <div class="form-group">
              <label for="Age" class="col-form-label">Contact Number</label>
              <input type="text" class="form-control" id="edited-contactnumber" name="edited-contactnumber" />
            </div>
            <div class="form-group">
              <label for="Age" class="col-form-label">Temperature</label>
              <input type="text" class="form-control" id="edited-temp" name="edited-temp" />
            </div>
            <div class="form-group">
              <label for="Age" class="col-form-label">Reason</label>
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