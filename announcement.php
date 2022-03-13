<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>Announcements | Campus Logging System</title>

    <link href="vendor/bootstrap4/css/bootstrap.min.css" rel="stylesheet" />
    <link href="vendor/DataTables/datatables.min.css" rel="stylesheet" />
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
              <h3>
                Announcements
                <a
                  href="#"
                  class="btn btn-sm btn-outline-primary float-right"
                  data-toggle="modal"
                  data-target="#add-announcement-modal"
                  ><i class="fas fa-bullhorn"></i> Add</a
                >
              </h3>
            </div>
            <div class="row">
              <div class="col-md-12 col-lg-12">
                <div class="card">
                  <div class="card-header">Announcements Table</div>
                  <div class="card-body">
                    <p class="card-title"></p>
                    <table
                      class="table table-hover"
                      id="announcement-table"
                      width="100%"
                    >
                      <thead>
                        <tr>
                          <th>Date</th>
                          <th>Title</th>
                          <th>Message</th>
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

    <!-- add announcement modal -->
    <div
      class="modal fade"
      id="add-announcement-modal"
      tabindex="-1"
      aria-labelledby="add-announcement-modalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Add Announcements</h5>
            <button
              type="button"
              class="close"
              data-dismiss="modal"
              aria-label="Close"
            >
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form>
              <div class="form-group">
                <label for="date-input" class="col-form-label">Date:</label>
                <input
                  id="date-input"
                  type="text"
                  class="form-control"
                  name="date-input"
                />
              </div>
              <div class="form-group">
                <label for="title-input" class="col-form-label">Title:</label>
                <input
                  id="title-input"
                  type="text"
                  class="form-control"
                  name="title-input"
                />
              </div>
              <div class="form-group">
                <label for="message-text-input" class="col-form-label"
                  >Message:</label
                >
                <textarea
                  class="form-control"
                  id="message-text-input"
                ></textarea>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button
              id="add-new-announcement-button"
              type="button"
              class="btn btn-primary"
            >
              Add
            </button>
          </div>
        </div>
      </div>
    </div>
    <!-- add announcement modal -->

    <!-- edit announcement modal -->
    <div
      class="modal fade"
      id="edit-announcement-modal"
      tabindex="-1"
      aria-labelledby="edit-announcement-modalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Edit Announcement</h5>
            <button
              type="button"
              class="close"
              data-dismiss="modal"
              aria-label="Close"
            >
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form>
              <input id="edited-id" name="edited-id" type="hidden" />
              <div class="form-group">
                <label for="edit-date-input" class="col-form-label"
                  >Date:</label
                >
                <input
                  id="edit-date-input"
                  type="text"
                  class="form-control"
                  name="edit-date-input"
                />
              </div>
              <div class="form-group">
                <label for="edit-title-input" class="col-form-label"
                  >Title:</label
                >
                <input
                  id="edit-title-input"
                  type="text"
                  class="form-control"
                  name="edit-title-input"
                />
              </div>
              <div class="form-group">
                <label for="edit-message-text-input" class="col-form-label"
                  >Message:</label
                >
                <textarea
                  class="form-control"
                  id="edit-message-text-input"
                ></textarea>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button
              type="button"
              class="btn btn-primary save-announcement-button"
            >
              Save
            </button>
          </div>
        </div>
      </div>
    </div>
    <!-- edit announcement modal -->

    <script src="vendor/jquery3/jquery.min.js"></script>
    <script src="vendor/bootstrap4/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/DataTables/datatables.min.js"></script>
    <script src="vendor/fontawesome5/solid.min.js"></script>
    <script src="vendor/fontawesome5/fontawesome.min.js"></script>
    <script src="./js/announcements.js"></script>
    <script src="js/script.js"></script>
  </body>
</html>
