<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>Dashboard | Campus Logging System</title>

    <link href="vendor/bootstrap4/css/bootstrap.min.css" rel="stylesheet" />
    <link href="vendor/chartsjs/Chart.min.css" rel="stylesheet" />
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
            <a href="announcement.php"
              ><i class="fas fa-bullhorn"></i> Announcements</a
            >
          </li>
          <li>
            <a href="account-settings.php"
              ><i class="fas fa-user"></i> Account Settings</a
            >
          </li>
        </ul>
      </nav>
      <!-- sidebar navigation -->

      <div id="body" class="active">
        <!-- navbar -->
        <nav class="navbar navbar-expand-lg navbar-white bg-white">
          <button
            type="button"
            id="sidebarCollapse"
            class="btn btn-success default-secondary-menu"
          >
            <i class="fas fa-bars"></i><span></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="nav navbar-nav ml-auto">
              <li class="nav-item dropdown">
                <div class="nav-dropdown">
                  <a
                    href=""
                    class="nav-item nav-link dropdown-toggle text-secondary"
                    data-toggle="dropdown"
                    ><i class="fas fa-user"></i> <span>User</span>
                    <i style="font-size: 0.8em" class="fas fa-caret-down"></i
                  ></a>
                  <div class="dropdown-menu dropdown-menu-right nav-link-menu">
                    <ul class="nav-list">
                      <li>
                        <a href="" class="dropdown-item"
                          ><i class="fas fa-sign-out-alt"></i> Logout</a
                        >
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
              <h3>Dashboard</h3>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="card">
                  <div class="card-header">Daily Logs Chart</div>
                  <div class="card-body">
                    <p class="card-title"></p>
                    <div class="canvas-wrapper">
                      <canvas class="daily-logs-chart chart"></canvas>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-md-6">
                <div class="card">
                  <div class="card-header">Monthly Logs Chart</div>
                  <div class="card-body">
                    <p class="card-title"></p>
                    <div class="canvas-wrapper">
                      <canvas class="monthly-logs-chart chart"></canvas>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-md-6">
                <div class="card">
                  <div class="card-header">Yearly Logs Chart</div>
                  <div class="card-body">
                    <p class="card-title"></p>
                    <div class="canvas-wrapper">
                      <canvas class="yearly-logs-chart chart"></canvas>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <script src="vendor/jquery3/jquery.min.js"></script>
    <script src="vendor/bootstrap4/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/fontawesome5/solid.min.js"></script>
    <script src="vendor/fontawesome5/fontawesome.min.js"></script>
    <script src="vendor/chartsjs/Chart.min.js"></script>
    <script src="js/dashboard.js"></script>
    <script src="js/script.js"></script>
  </body>
</html>
