// initialize datatable
$(document).ready(function () {
  getAllRolesAndPermissions();
});

function getAllRolesAndPermissions() {
  fetch("php/get_all_roles_and_permissions.php")
    .then((res) => res.json())
    .then((response) => {
      let rolesData = [];
      for (let i = 0; i < response.length; i++) {
        let data = {
          id: response[i].id,
          role_name: response[i].role_name,
        };
        rolesData.push(data);
      }
      initializeDatatable(rolesData);
    })
    .catch((error) => console.log(error));
}

function initializeDatatable(rolesData) {
  $("#roles-and-permissions-table").DataTable({
    data: rolesData,
    responsive: true,
    pageLength: 25,
    lengthChange: true,
    searching: true,
    ordering: true,
    columns: [
      { data: "role_name" },

      {
        data: "id",
        render: function (data, type, row, meta) {
          // check if role row is superadmin
          if (data == 1) {
            return "";
          } else {
            let editButton = ``;
            let deleteButton = ``;

            if (editRoles == 1) {
              editButton =
                `<a href="#" data-id='` +
                data +
                `' class='btn btn-outline-info btn-rounded mr-1 edit-roles-button'><i class="fas fa-toggle-on"></i></a>`;
            } else {
              editButton = ``;
            }

            if (deleteRoles == 1) {
              deleteButton =
                `<a href="#" data-id='` +
                data +
                `' class='btn btn-outline-danger btn-rounded delete-roles-button'><i class="fas fa-trash"></i></a>`;
            } else {
              deleteButton = ``;
            }

            let opening = `<div class="text-right">`;
            let closing = `</div>`;

            return opening + editButton + deleteButton + closing;
          }
        },
      },
    ],
  });
}
// initialize datatable

// add roles and permissions
$("#add-role-button").click(function () {
  let roleNameValue = $("#role-name-input").val();

  if (roleNameValue === "") {
    alert("Type role name before saving");
  } else {
    let rolesAndPermissionsData = getAddRolesAndPermissionsFormValue();
    addRolesAndPermissionsToDatabase(rolesAndPermissionsData);
  }
});

function addRolesAndPermissionsToDatabase(rolesAndPermissionsData) {
  $.ajax({
    url: "php/add_roles_permissions.php",
    data: {
      role_name: rolesAndPermissionsData.roleName,
      open_dashboard: rolesAndPermissionsData.openDashboard,
      open_loogbook: rolesAndPermissionsData.openLogbook,
      edit_log: rolesAndPermissionsData.editLog,
      delete_log: rolesAndPermissionsData.deleteLog,
      open_announcement: rolesAndPermissionsData.openAnnouncement,
      add_announcement: rolesAndPermissionsData.addAnnouncement,
      edit_announcement: rolesAndPermissionsData.editAnnouncement,
      delete_announcement: rolesAndPermissionsData.deleteAnnouncement,
      open_users: rolesAndPermissionsData.openUsers,
      add_users: rolesAndPermissionsData.addUsers,
      edit_users: rolesAndPermissionsData.editUsers,
      delete_users: rolesAndPermissionsData.deleteUsers,
      open_roles_and_permissions:
        rolesAndPermissionsData.openRolesAndPermissions,
      add_roles_and_permissions: rolesAndPermissionsData.addRolesAndPermissions,
      edit_roles_and_permissions:
        rolesAndPermissionsData.editRolesAndPermissions,
      delete_roles_and_permissions:
        rolesAndPermissionsData.deleteRolesAndPermissions,
    },
    type: "post",
    success: function (data) {
      let json = JSON.parse(data);
      let status = json.status;
      if (status == "true") {
        getNewRole(rolesAndPermissionsData);
        alert("Add roles and permissions success");
      } else {
        alert("Add roles and permissions failed");
      }

      // reset add roles form
      $("#add-roles-modal").modal("hide");
      $("#add-roles-and-permissions-form").trigger("reset");
    },
  });
}

function getNewRole(rolesAndPermissionsData) {
  $.ajax({
    url: "php/get_new_roles_and_permissions.php",
    data: {
      role_name: rolesAndPermissionsData.roleName,
    },
    type: "post",
    success: function (data) {
      let roleData = JSON.parse(data);
      addRoleToDatatable(roleData);
    },
  });
}

function addRoleToDatatable(roleData) {
  let rolesTable = $("#roles-and-permissions-table").DataTable();
  let rowNode = rolesTable.row
    .add({
      role_name: roleData.role_name,
      id: roleData.id,
    })
    .draw()
    .node();

  $(rowNode).css("color", "green").animate({ color: "black" });
}
// add roles and permissions

// setup add permissions toggle behavior
let openLogbookCheckbox = document.getElementById("open-logbook-checkbox");
openLogbookCheckbox.addEventListener("change", function () {
  if (this.checked) {
    $("#edit-log-checkbox").prop("disabled", false);
    $("#delete-log-checkbox").prop("disabled", false);
  } else {
    $("#edit-log-checkbox").prop("checked", false);
    $("#delete-log-checkbox").prop("checked", false);
    $("#edit-log-checkbox").prop("disabled", true);
    $("#delete-log-checkbox").prop("disabled", true);
  }
});

let openAnnouncementCheckbox = document.getElementById(
  "open-announcement-checkbox"
);
openAnnouncementCheckbox.addEventListener("change", function () {
  if (this.checked) {
    $("#add-announcement-checkbox").prop("disabled", false);
    $("#edit-announcement-checkbox").prop("disabled", false);
    $("#delete-announcement-checkbox").prop("disabled", false);
  } else {
    $("#add-announcement-checkbox").prop("checked", false);
    $("#edit-announcement-checkbox").prop("checked", false);
    $("#delete-announcement-checkbox").prop("checked", false);
    $("#add-announcement-checkbox").prop("disabled", true);
    $("#edit-announcement-checkbox").prop("disabled", true);
    $("#delete-announcement-checkbox").prop("disabled", true);
  }
});

let openUserCheckbox = document.getElementById("open-users-checkbox");
openUserCheckbox.addEventListener("change", function () {
  if (this.checked) {
    $("#add-users-checkbox").prop("disabled", false);
    $("#edit-users-checkbox").prop("disabled", false);
    $("#delete-users-checkbox").prop("disabled", false);
  } else {
    $("#add-users-checkbox").prop("checked", false);
    $("#edit-users-checkbox").prop("checked", false);
    $("#delete-users-checkbox").prop("checked", false);
    $("#add-users-checkbox").prop("disabled", true);
    $("#edit-users-checkbox").prop("disabled", true);
    $("#delete-users-checkbox").prop("disabled", true);
  }
});

let openRolesAndPermissionsCheckbox = document.getElementById(
  "open-roles-and-permissions-checkbox"
);
openRolesAndPermissionsCheckbox.addEventListener("change", function () {
  if (this.checked) {
    $("#add-roles-and-permissions-checkbox").prop("disabled", false);
    $("#edit-roles-and-permissions-checkbox").prop("disabled", false);
    $("#delete-roles-and-permissions-checkbox").prop("disabled", false);
  } else {
    $("#add-roles-and-permissions-checkbox").prop("checked", false);
    $("#edit-roles-and-permissions-checkbox").prop("checked", false);
    $("#delete-roles-and-permissions-checkbox").prop("checked", false);
    $("#add-roles-and-permissions-checkbox").prop("disabled", true);
    $("#edit-roles-and-permissions-checkbox").prop("disabled", true);
    $("#delete-roles-and-permissions-checkbox").prop("disabled", true);
  }
});

function getAddRolesAndPermissionsFormValue() {
  let roleNameValue = $("#role-name-input").val();
  let openDashboardIsCheck = true;
  let openLogbookIsCheck = true;
  let editLogIsCheck = false;
  let deleteLogIsCheck = false;
  let openAnnouncementIsCheck = true;
  let addAnnouncementIsCheck = false;
  let editAnnouncementIsCheck = false;
  let deleteAnnouncementIsCheck = false;
  let openUsersIsCheck = false;
  let addUsersIsCheck = false;
  let editUsersIsCheck = false;
  let deleteUsersIsCheck = false;
  let openRolesAndPermissionsIsCheck = false;
  let addRolesAndPermissionsIsCheck = false;
  let editRolesAndPermissionsIsCheck = false;
  let deleteRolesAndPermissionsIsCheck = false;

  let openDashboardToggle = document.getElementById("open-dashboard-checkbox");
  let openLogbookToggle = document.getElementById("open-logbook-checkbox");
  let editLogToggle = document.getElementById("edit-log-checkbox");
  let deleteLogToggle = document.getElementById("delete-log-checkbox");
  let openAnnouncementToggle = document.getElementById(
    "open-announcement-checkbox"
  );
  let addAnnouncementToggle = document.getElementById(
    "add-announcement-checkbox"
  );
  let editAnnouncementToggle = document.getElementById(
    "edit-announcement-checkbox"
  );
  let deleteAnnouncementToggle = document.getElementById(
    "delete-announcement-checkbox"
  );
  let openUsersToggle = document.getElementById("open-users-checkbox");
  let addUsersToggle = document.getElementById("add-users-checkbox");
  let editUsersToggle = document.getElementById("edit-users-checkbox");
  let deleteUsersToggle = document.getElementById("delete-users-checkbox");
  let openRolesAndPermissionsToggle = document.getElementById(
    "open-roles-and-permissions-checkbox"
  );
  let addRolesAndPermissionsToggle = document.getElementById(
    "add-roles-and-permissions-checkbox"
  );
  let editRolesAndPermissionsToggle = document.getElementById(
    "edit-roles-and-permissions-checkbox"
  );
  let deleteRolesAndPermissionsToggle = document.getElementById(
    "delete-roles-and-permissions-checkbox"
  );

  if (openDashboardToggle.checked) {
    openDashboardIsCheck = true;
  } else {
    openDashboardIsCheck = false;
  }

  if (openLogbookToggle.checked) {
    openLogbookIsCheck = true;
  } else {
    openLogbookIsCheck = false;
  }

  if (editLogToggle.checked) {
    editLogIsCheck = true;
  } else {
    editLogIsCheck = false;
  }

  if (deleteLogToggle.checked) {
    deleteLogIsCheck = true;
  } else {
    deleteLogIsCheck = false;
  }

  if (openAnnouncementToggle.checked) {
    openAnnouncementIsCheck = true;
  } else {
    openAnnouncementIsCheck = false;
  }

  if (addAnnouncementToggle.checked) {
    addAnnouncementIsCheck = true;
  } else {
    addAnnouncementIsCheck = false;
  }

  if (editAnnouncementToggle.checked) {
    editAnnouncementIsCheck = true;
  } else {
    editAnnouncementIsCheck = false;
  }

  if (deleteAnnouncementToggle.checked) {
    deleteAnnouncementIsCheck = true;
  } else {
    deleteAnnouncementIsCheck = false;
  }

  if (openUsersToggle.checked) {
    openUsersIsCheck = true;
  } else {
    openUsersIsCheck = false;
  }

  if (addUsersToggle.checked) {
    addUsersIsCheck = true;
  } else {
    addUsersIsCheck = false;
  }

  if (editUsersToggle.checked) {
    editUsersIsCheck = true;
  } else {
    editUsersIsCheck = false;
  }

  if (deleteUsersToggle.checked) {
    deleteUsersIsCheck = true;
  } else {
    deleteUsersIsCheck = false;
  }

  if (openRolesAndPermissionsToggle.checked) {
    openRolesAndPermissionsIsCheck = true;
  } else {
    openRolesAndPermissionsIsCheck = false;
  }

  if (addRolesAndPermissionsToggle.checked) {
    addRolesAndPermissionsIsCheck = true;
  } else {
    addRolesAndPermissionsIsCheck = false;
  }

  if (editRolesAndPermissionsToggle.checked) {
    editRolesAndPermissionsIsCheck = true;
  } else {
    editRolesAndPermissionsIsCheck = false;
  }

  if (deleteRolesAndPermissionsToggle.checked) {
    deleteRolesAndPermissionsIsCheck = true;
  } else {
    deleteRolesAndPermissionsIsCheck = false;
  }

  let rolesAndPersmissionsValue = {
    roleName: roleNameValue,
    openDashboard: openDashboardIsCheck,
    openLogbook: openLogbookIsCheck,
    editLog: editLogIsCheck,
    deleteLog: deleteLogIsCheck,
    openAnnouncement: openAnnouncementIsCheck,
    addAnnouncement: addAnnouncementIsCheck,
    editAnnouncement: editAnnouncementIsCheck,
    deleteAnnouncement: deleteAnnouncementIsCheck,
    openUsers: openUsersIsCheck,
    addUsers: addUsersIsCheck,
    editUsers: editUsersIsCheck,
    deleteUsers: deleteUsersIsCheck,
    openRolesAndPermissions: openRolesAndPermissionsIsCheck,
    addRolesAndPermissions: addRolesAndPermissionsIsCheck,
    editRolesAndPermissions: editRolesAndPermissionsIsCheck,
    deleteRolesAndPermissions: deleteRolesAndPermissionsIsCheck,
  };

  return rolesAndPersmissionsValue;
}
// setup add permissions toggle behavior

// edit roles and permissions
let selectedRowIndex = "";
let oldRoleName = "";

$(document).on("click", ".edit-roles-button", function () {
  let id = $(this).data("id");
  $("#edit-roles-modal").modal("show");

  $.ajax({
    url: "php/get_single_roles_and_permissions.php",
    data: { id: id },
    type: "post",
    success: function (data) {
      let rolesAndPermissionsData = JSON.parse(data);

      $("#edited-id").val(id);
      $("#edit-role-name-input").val(rolesAndPermissionsData.role_name);
      updateEditRolesFormValues(rolesAndPermissionsData);
      oldRoleName = rolesAndPermissionsData.role_name;
    },
  });

  selectedRowIndex = this;
});

function updateEditRolesFormValues(rolesAndPermissionsData) {
  $("#edit-open-dashboard-checkbox").prop(
    "checked",
    rolesAndPermissionsData.open_dashboard == 1
  );
  $("#edit-open-logbook-checkbox").prop(
    "checked",
    rolesAndPermissionsData.open_logbook == 1
  );
  $("#edit-edit-log-checkbox").prop(
    "checked",
    rolesAndPermissionsData.edit_log == 1
  );
  $("#edit-delete-log-checkbox").prop(
    "checked",
    rolesAndPermissionsData.delete_log == 1
  );
  $("#edit-open-announcement-checkbox").prop(
    "checked",
    rolesAndPermissionsData.open_announcement == 1
  );
  $("#edit-add-announcement-checkbox").prop(
    "checked",
    rolesAndPermissionsData.add_announcement == 1
  );
  $("#edit-edit-announcement-checkbox").prop(
    "checked",
    rolesAndPermissionsData.edit_announcement == 1
  );
  $("#edit-delete-announcement-checkbox").prop(
    "checked",
    rolesAndPermissionsData.delete_announcement == 1
  );
  $("#edit-open-users-checkbox").prop(
    "checked",
    rolesAndPermissionsData.open_users == 1
  );
  $("#edit-add-users-checkbox").prop(
    "checked",
    rolesAndPermissionsData.add_users == 1
  );
  $("#edit-edit-users-checkbox").prop(
    "checked",
    rolesAndPermissionsData.edit_users == 1
  );
  $("#edit-delete-users-checkbox").prop(
    "checked",
    rolesAndPermissionsData.delete_users == 1
  );
  $("#edit-open-roles-and-permissions-checkbox").prop(
    "checked",
    rolesAndPermissionsData.open_roles_and_permissions == 1
  );
  $("#edit-add-roles-and-permissions-checkbox").prop(
    "checked",
    rolesAndPermissionsData.add_roles_and_permissions == 1
  );
  $("#edit-edit-roles-and-permissions-checkbox").prop(
    "checked",
    rolesAndPermissionsData.edit_roles_and_permissions == 1
  );
  $("#edit-delete-roles-and-permissions-checkbox").prop(
    "checked",
    rolesAndPermissionsData.delete_roles_and_permissions == 1
  );

  if (rolesAndPermissionsData.open_logbook == 1) {
    $("#edit-edit-log-checkbox").prop("disabled", false);
    $("#edit-delete-log-checkbox").prop("disabled", false);
  } else {
    $("#edit-edit-log-checkbox").prop("disabled", true);
    $("#edit-delete-log-checkbox").prop("disabled", true);
  }

  if (rolesAndPermissionsData.open_announcement == 1) {
    $("#edit-add-announcement-checkbox").prop("disabled", false);
    $("#edit-edit-announcement-checkbox").prop("disabled", false);
    $("#edit-delete-announcement-checkbox").prop("disabled", false);
  } else {
    $("#edit-add-announcement-checkbox").prop("disabled", true);
    $("#edit-edit-announcement-checkbox").prop("disabled", true);
    $("#edit-delete-announcement-checkbox").prop("disabled", true);
  }

  if (rolesAndPermissionsData.open_users == 1) {
    $("#edit-add-users-checkbox").prop("disabled", false);
    $("#edit-edit-users-checkbox").prop("disabled", false);
    $("#edit-delete-users-checkbox").prop("disabled", false);
  } else {
    $("#edit-add-users-checkbox").prop("disabled", true);
    $("#edit-edit-users-checkbox").prop("disabled", true);
    $("#edit-delete-users-checkbox").prop("disabled", true);
  }

  if (rolesAndPermissionsData.open_roles_and_permissions == 1) {
    $("#edit-add-roles-and-permissions-checkbox").prop("disabled", false);
    $("#edit-edit-roles-and-permissions-checkbox").prop("disabled", false);
    $("#edit-delete-roles-and-permissions-checkbox").prop("disabled", false);
  } else {
    $("#edit-add-roles-and-permissions-checkbox").prop("disabled", true);
    $("#edit-edit-roles-and-permissions-checkbox").prop("disabled", true);
    $("#edit-delete-roles-and-permissions-checkbox").prop("disabled", true);
  }
}

$(document).on("click", "#edit-roles-modal-button", function () {
  let rolesAndPermissionsData = getEditRolesAndPermissionsFormValue();

  if (rolesAndPermissionsData.roleName != "") {
    updateEditRolesToDatabase(rolesAndPermissionsData);
  } else {
    alert("Fill up form before saving");
  }
});

function updateEditRolesToDatabase(rolesAndPermissionsData) {
  $.ajax({
    url: "php/update_roles_and_permissions.php",
    data: {
      id: rolesAndPermissionsData.id,
      role_name: rolesAndPermissionsData.roleName,
      open_dashboard: rolesAndPermissionsData.openDashboard,
      open_loogbook: rolesAndPermissionsData.openLogbook,
      edit_log: rolesAndPermissionsData.editLog,
      delete_log: rolesAndPermissionsData.deleteLog,
      open_announcement: rolesAndPermissionsData.openAnnouncement,
      add_announcement: rolesAndPermissionsData.addAnnouncement,
      edit_announcement: rolesAndPermissionsData.editAnnouncement,
      delete_announcement: rolesAndPermissionsData.deleteAnnouncement,
      open_users: rolesAndPermissionsData.openUsers,
      add_users: rolesAndPermissionsData.addUsers,
      edit_users: rolesAndPermissionsData.editUsers,
      delete_users: rolesAndPermissionsData.deleteUsers,
      open_roles_and_permissions:
        rolesAndPermissionsData.openRolesAndPermissions,
      add_roles_and_permissions: rolesAndPermissionsData.addRolesAndPermissions,
      edit_roles_and_permissions:
        rolesAndPermissionsData.editRolesAndPermissions,
      delete_roles_and_permissions:
        rolesAndPermissionsData.deleteRolesAndPermissions,
      old_role_name: oldRoleName,
    },
    type: "post",
    success: function (data) {
      let json = JSON.parse(data);
      let status = json.status;
      if (status == "true") {
        alert("Update role success");
        updateSingleRowInTable(rolesAndPermissionsData);
      } else {
        alert("Update role failed");
        selectedRowIndex = "";
        oldRoleName = "";
      }

      $("#edit-roles-modal").modal("hide");
    },
  });
}

function updateSingleRowInTable(rolesAndPermissionsData) {
  let table = $("#roles-and-permissions-table").DataTable();
  table.row($(selectedRowIndex).parents("tr")).remove().draw();

  table.row
    .add({
      role_name: rolesAndPermissionsData.roleName,
      id: rolesAndPermissionsData.id,
    })
    .draw();

  selectedRowIndex = "";
  oldRoleName = "";
}
// edit roles and permissions

// setup add permissions toggle behavior
let editOpenLogbookCheckbox = document.getElementById(
  "edit-open-logbook-checkbox"
);
editOpenLogbookCheckbox.addEventListener("change", function () {
  if (this.checked) {
    $("#edit-edit-log-checkbox").prop("disabled", false);
    $("#edit-delete-log-checkbox").prop("disabled", false);
  } else {
    $("#edit-edit-log-checkbox").prop("checked", false);
    $("#edit-delete-log-checkbox").prop("checked", false);
    $("#edit-edit-log-checkbox").prop("disabled", true);
    $("#edit-delete-log-checkbox").prop("disabled", true);
  }
});

let editOpenAnnouncementCheckbox = document.getElementById(
  "edit-open-announcement-checkbox"
);
editOpenAnnouncementCheckbox.addEventListener("change", function () {
  if (this.checked) {
    $("#edit-add-announcement-checkbox").prop("disabled", false);
    $("#edit-edit-announcement-checkbox").prop("disabled", false);
    $("#edit-delete-announcement-checkbox").prop("disabled", false);
  } else {
    $("#edit-add-announcement-checkbox").prop("checked", false);
    $("#edit-edit-announcement-checkbox").prop("checked", false);
    $("#edit-delete-announcement-checkbox").prop("checked", false);
    $("#edit-add-announcement-checkbox").prop("disabled", true);
    $("#edit-edit-announcement-checkbox").prop("disabled", true);
    $("#edit-delete-announcement-checkbox").prop("disabled", true);
  }
});

let editOpenUserCheckbox = document.getElementById("edit-open-users-checkbox");
editOpenUserCheckbox.addEventListener("change", function () {
  if (this.checked) {
    $("#edit-add-users-checkbox").prop("disabled", false);
    $("#edit-edit-users-checkbox").prop("disabled", false);
    $("#edit-delete-users-checkbox").prop("disabled", false);
  } else {
    $("#edit-add-users-checkbox").prop("checked", false);
    $("#edit-edit-users-checkbox").prop("checked", false);
    $("#edit-delete-users-checkbox").prop("checked", false);
    $("#edit-add-users-checkbox").prop("disabled", true);
    $("#edit-edit-users-checkbox").prop("disabled", true);
    $("#edit-delete-users-checkbox").prop("disabled", true);
  }
});

let editOpenRolesAndPermissionsCheckbox = document.getElementById(
  "edit-open-roles-and-permissions-checkbox"
);
editOpenRolesAndPermissionsCheckbox.addEventListener("change", function () {
  if (this.checked) {
    $("#edit-add-roles-and-permissions-checkbox").prop("disabled", false);
    $("#edit-edit-roles-and-permissions-checkbox").prop("disabled", false);
    $("#edit-delete-roles-and-permissions-checkbox").prop("disabled", false);
  } else {
    $("#edit-add-roles-and-permissions-checkbox").prop("checked", false);
    $("#edit-edit-roles-and-permissions-checkbox").prop("checked", false);
    $("#edit-delete-roles-and-permissions-checkbox").prop("checked", false);
    $("#edit-add-roles-and-permissions-checkbox").prop("disabled", true);
    $("#edit-edit-roles-and-permissions-checkbox").prop("disabled", true);
    $("#edit-delete-roles-and-permissions-checkbox").prop("disabled", true);
  }
});

function getEditRolesAndPermissionsFormValue() {
  let id = $("#edited-id").val();
  let roleNameValue = $("#edit-role-name-input").val();
  let openDashboardIsCheck = 0;
  let openLogbookIsCheck = 0;
  let editLogIsCheck = 0;
  let deleteLogIsCheck = 0;
  let openAnnouncementIsCheck = 0;
  let addAnnouncementIsCheck = 0;
  let editAnnouncementIsCheck = 0;
  let deleteAnnouncementIsCheck = 0;
  let openUsersIsCheck = 0;
  let addUsersIsCheck = 0;
  let editUsersIsCheck = 0;
  let deleteUsersIsCheck = 0;
  let openRolesAndPermissionsIsCheck = 0;
  let addRolesAndPermissionsIsCheck = 0;
  let editRolesAndPermissionsIsCheck = 0;
  let deleteRolesAndPermissionsIsCheck = 0;

  let openDashboardToggle = document.getElementById(
    "edit-open-dashboard-checkbox"
  );
  let openLogbookToggle = document.getElementById("edit-open-logbook-checkbox");
  let editLogToggle = document.getElementById("edit-edit-log-checkbox");
  let deleteLogToggle = document.getElementById("edit-delete-log-checkbox");
  let openAnnouncementToggle = document.getElementById(
    "edit-open-announcement-checkbox"
  );
  let addAnnouncementToggle = document.getElementById(
    "edit-add-announcement-checkbox"
  );
  let editAnnouncementToggle = document.getElementById(
    "edit-edit-announcement-checkbox"
  );
  let deleteAnnouncementToggle = document.getElementById(
    "edit-delete-announcement-checkbox"
  );
  let openUsersToggle = document.getElementById("edit-open-users-checkbox");
  let addUsersToggle = document.getElementById("edit-add-users-checkbox");
  let editUsersToggle = document.getElementById("edit-edit-users-checkbox");
  let deleteUsersToggle = document.getElementById("edit-delete-users-checkbox");
  let openRolesAndPermissionsToggle = document.getElementById(
    "edit-open-roles-and-permissions-checkbox"
  );
  let addRolesAndPermissionsToggle = document.getElementById(
    "edit-add-roles-and-permissions-checkbox"
  );
  let editRolesAndPermissionsToggle = document.getElementById(
    "edit-edit-roles-and-permissions-checkbox"
  );
  let deleteRolesAndPermissionsToggle = document.getElementById(
    "edit-delete-roles-and-permissions-checkbox"
  );

  if (openDashboardToggle.checked) {
    openDashboardIsCheck = 1;
  } else {
    openDashboardIsCheck = 0;
  }

  if (openLogbookToggle.checked) {
    openLogbookIsCheck = 1;
  } else {
    openLogbookIsCheck = 0;
  }

  if (editLogToggle.checked) {
    editLogIsCheck = 1;
  } else {
    editLogIsCheck = 0;
  }

  if (deleteLogToggle.checked) {
    deleteLogIsCheck = 1;
  } else {
    deleteLogIsCheck = 0;
  }

  if (openAnnouncementToggle.checked) {
    openAnnouncementIsCheck = 1;
  } else {
    openAnnouncementIsCheck = 0;
  }

  if (addAnnouncementToggle.checked) {
    addAnnouncementIsCheck = 1;
  } else {
    addAnnouncementIsCheck = 0;
  }

  if (editAnnouncementToggle.checked) {
    editAnnouncementIsCheck = 1;
  } else {
    editAnnouncementIsCheck = 0;
  }

  if (deleteAnnouncementToggle.checked) {
    deleteAnnouncementIsCheck = 1;
  } else {
    deleteAnnouncementIsCheck = 0;
  }

  if (openUsersToggle.checked) {
    openUsersIsCheck = 1;
  } else {
    openUsersIsCheck = 0;
  }

  if (addUsersToggle.checked) {
    addUsersIsCheck = 1;
  } else {
    addUsersIsCheck = 0;
  }

  if (editUsersToggle.checked) {
    editUsersIsCheck = 1;
  } else {
    editUsersIsCheck = 0;
  }

  if (deleteUsersToggle.checked) {
    deleteUsersIsCheck = 1;
  } else {
    deleteUsersIsCheck = 0;
  }

  if (openRolesAndPermissionsToggle.checked) {
    openRolesAndPermissionsIsCheck = 1;
  } else {
    openRolesAndPermissionsIsCheck = 0;
  }

  if (addRolesAndPermissionsToggle.checked) {
    addRolesAndPermissionsIsCheck = 1;
  } else {
    addRolesAndPermissionsIsCheck = 0;
  }

  if (editRolesAndPermissionsToggle.checked) {
    editRolesAndPermissionsIsCheck = 1;
  } else {
    editRolesAndPermissionsIsCheck = 0;
  }

  if (deleteRolesAndPermissionsToggle.checked) {
    deleteRolesAndPermissionsIsCheck = 1;
  } else {
    deleteRolesAndPermissionsIsCheck = 0;
  }

  let rolesAndPersmissionsValue = {
    id: id,
    roleName: roleNameValue,
    openDashboard: openDashboardIsCheck,
    openLogbook: openLogbookIsCheck,
    editLog: editLogIsCheck,
    deleteLog: deleteLogIsCheck,
    openAnnouncement: openAnnouncementIsCheck,
    addAnnouncement: addAnnouncementIsCheck,
    editAnnouncement: editAnnouncementIsCheck,
    deleteAnnouncement: deleteAnnouncementIsCheck,
    openUsers: openUsersIsCheck,
    addUsers: addUsersIsCheck,
    editUsers: editUsersIsCheck,
    deleteUsers: deleteUsersIsCheck,
    openRolesAndPermissions: openRolesAndPermissionsIsCheck,
    addRolesAndPermissions: addRolesAndPermissionsIsCheck,
    editRolesAndPermissions: editRolesAndPermissionsIsCheck,
    deleteRolesAndPermissions: deleteRolesAndPermissionsIsCheck,
  };

  return rolesAndPersmissionsValue;
}
// setup add permissions toggle behavior

// delete role
$(document).on("click", ".delete-roles-button", function () {
  let id = $(this).data("id");

  if (confirm("Are you sure want to delete this role ?")) {
    $.ajax({
      url: "php/get_single_roles_and_permissions.php",
      data: { id: id },
      type: "post",
      success: function (data) {
        let roleData = JSON.parse(data);

        $.ajax({
          url: "php/delete_roles_and_permissions.php",
          data: { id: roleData.id, role_name: roleData.role_name },
          type: "post",
          success: function (data) {
            let json = JSON.parse(data);
            let status = json.status;
            if (status == "failed") {
              alert("Delete Failed");
              return;
            }
          },
        });
      },
    });
    removeRowFromTable.call(this);
  } else {
    return null;
  }
});

let removeRowFromTable = function () {
  let table = $("#roles-and-permissions-table").DataTable();
  table.row($(this).parents("tr")).remove().draw();
};
// delete role
