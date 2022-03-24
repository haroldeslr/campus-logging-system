$(document).ready(function () {
  getAllUsers();
});

function getAllUsers() {
  fetch("php/get_all_users.php")
    .then((res) => res.json())
    .then((response) => {
      let usersData = [];
      for (let i = 0; i < response.length; i++) {
        let data = {
          id: response[i].id,
          username: response[i].username,
          email: response[i].email,
          fullname: response[i].fullname,
          role: response[i].role,
          type: response[i].type,
        };
        usersData.push(data);
      }
      initializeDatatable(usersData);
    })
    .catch((error) => console.log(error));
}

function initializeDatatable(usersData) {
  $("#users-table").DataTable({
    data: usersData,
    responsive: true,
    pageLength: 25,
    lengthChange: true,
    searching: true,
    ordering: true,
    columns: [
      { data: "fullname" },
      { data: "username" },
      { data: "email" },
      { data: "role" },
      { data: "type" },

      {
        data: "id",
        render: function (data, type, row, meta) {
          // check if row is superadmin account
          if (data == 1) {
            return "";
          } else {
            let editButton = ``;
            let deleteButton = ``;

            if (editUsers == 1) {
              editButton =
                `<a href="#" data-id='` +
                data +
                `' class='btn btn-outline-info btn-rounded mr-1 edit-user-button'><i class="fas fa-pen"></i></a>`;
            } else {
              editButton = ``;
            }

            if (deleteUsers == 1) {
              deleteButton =
                `<a href="#" data-id='` +
                data +
                `' class='btn btn-outline-danger btn-rounded delete-user-button'><i class="fas fa-trash"></i></a>`;
            } else {
              deleteButton = ``;
            }

            return editButton + deleteButton;
          }
        },
      },
    ],
  });
}

// add user
$("#add-user-button").click(function () {
  updateRoleSelectOption();
});

function updateRoleSelectOption() {
  fetch("php/get_all_roles_and_permissions.php")
    .then((res) => res.json())
    .then((response) => {
      $("#role-select").empty();
      for (let i = 0; i < response.length; i++) {
        $("#role-select").append(
          new Option(response[i].role_name, response[i].role_name)
        );
      }
    })
    .catch((error) => console.log(error));
}

$("#add-user-modal-button").click(function () {
  let addUserFormValue = getAddUserFormValues();
  let addUserFormIsValid = validateAddUserForm(addUserFormValue);

  if (addUserFormIsValid) {
    saveUserToDatabase(addUserFormValue);
  } else {
    alert("Fill up the form properly before saving");
  }
});

function getAddUserFormValues() {
  let email = $("#email-input").val();
  let username = $("#username-input").val();
  let password = $("#password-input").val();
  let fullname = $("#fullname-input").val();
  let type = $("#type-input").val();
  let role = $("#role-select").val();

  let addUserFormValue = {
    email: email,
    username: username,
    password: password,
    fullname: fullname,
    type: type,
    role: role,
  };

  return addUserFormValue;
}

function validateAddUserForm(addUserFormValue) {
  let addUserFormIsValid;

  if (
    addUserFormValue.email === "" ||
    !addUserFormValue.email.includes("@") ||
    addUserFormValue.username === "" ||
    addUserFormValue.password === "" ||
    addUserFormValue.fullname === "" ||
    addUserFormValue.type === "" ||
    addUserFormValue.role === ""
  ) {
    addUserFormIsValid = false;
  } else {
    addUserFormIsValid = true;
  }

  return addUserFormIsValid;
}

function saveUserToDatabase(addUserFormValue) {
  $.ajax({
    url: "php/add_user.php",
    data: {
      username: addUserFormValue.username,
      email: addUserFormValue.email,
      password: addUserFormValue.password,
      fullname: addUserFormValue.fullname,
      role: addUserFormValue.role,
      type: addUserFormValue.type,
    },
    type: "post",
    success: function (data) {
      let json = JSON.parse(data);
      let status = json.status;

      if (status == "true") {
        alert("Add user Success");
        getNewUser(addUserFormValue);
      } else {
        alert("Add user Failed");
      }

      $("#add-user-modal").modal("hide");
      $("#add-user-form").trigger("reset");
      $("#role-select").empty();
    },
  });
}

function getNewUser(addUserFormValue) {
  $.ajax({
    url: "php/get_new_user.php",
    data: {
      username: addUserFormValue.username,
      email: addUserFormValue.email,
    },
    type: "post",
    success: function (data) {
      let userData = JSON.parse(data);
      addUserToDatatable(userData);
    },
  });
}

function addUserToDatatable(userData) {
  let usersTable = $("#users-table").DataTable();
  let rowNode = usersTable.row
    .add({
      fullname: userData.fullname,
      username: userData.username,
      email: userData.email,
      role: userData.role,
      type: userData.type,
      id: userData.id,
    })
    .draw()
    .node();

  $(rowNode).css("color", "green").animate({ color: "black" });
}
// add user

// edit user
let selectedRowIndex = "";
let oldUsername = "";
let email = "";

$(document).on("click", ".edit-user-button", function () {
  let id = $(this).data("id");
  $("#edit-user-modal").modal("show");

  $.ajax({
    url: "php/get_single_user.php",
    data: { id: id },
    type: "post",
    success: function (data) {
      let userData = JSON.parse(data);

      $("#edited-id").val(id);
      $("#edit-username-input").val(userData.username);
      $("#edit-fullname-input").val(userData.fullname);
      $("#edit-type-input").val(userData.type);
      updateEditRoleSelectOption(userData.role);
      oldUsername = userData.username;
      email = userData.email;
    },
  });

  selectedRowIndex = this;
});

function updateEditRoleSelectOption(role) {
  fetch("php/get_all_roles_and_permissions.php")
    .then((res) => res.json())
    .then((response) => {
      $("#edit-role-select").empty();
      for (let i = 0; i < response.length; i++) {
        $("#edit-role-select").append(
          new Option(response[i].role_name, response[i].role_name)
        );
      }
      $("#edit-role-select").val(role).change();
    })
    .catch((error) => console.log(error));
}

$(document).on("click", "#edit-user-modal-button", function () {
  let editUserFormValues = getEditUserFormValues();
  let editUserFormIsValid = validateEditUserForm(editUserFormValues);

  if (editUserFormIsValid) {
    updateEditUserToDatabase(editUserFormValues);
  } else {
    alert("Fill up form before saving");
  }
});

function getEditUserFormValues() {
  let id = $("#edited-id").val();
  let username = $("#edit-username-input").val();
  let fullname = $("#edit-fullname-input").val();
  let type = $("#edit-type-input").val();
  let role = $("#edit-role-select").val();

  let editUserFormValues = {
    id: id,
    username: username,
    fullname: fullname,
    type: type,
    role: role,
  };

  return editUserFormValues;
}

function validateEditUserForm(editUserFormValues) {
  let editUserFormIsValid;

  if (
    editUserFormValues.username === "" ||
    editUserFormValues.fullname === "" ||
    editUserFormValues.type === "" ||
    editUserFormValues.role === ""
  ) {
    editUserFormIsValid = false;
  } else {
    editUserFormIsValid = true;
  }

  return editUserFormIsValid;
}

function updateEditUserToDatabase(editUserFormValues) {
  $.ajax({
    url: "php/update_user.php",
    data: {
      id: editUserFormValues.id,
      username: editUserFormValues.username,
      fullname: editUserFormValues.fullname,
      type: editUserFormValues.type,
      role: editUserFormValues.role,
      old_username: oldUsername,
    },
    type: "post",
    success: function (data) {
      let json = JSON.parse(data);
      let status = json.status;

      if (status == "true") {
        alert("Update user success");
        updateSingleRowInTable(editUserFormValues);
      } else {
        console.log(status);
        alert("Update user failed");
        selectedRowIndex = "";
        oldUsername = "";
        email = "";
      }

      $("#edit-user-modal").modal("hide");
    },
  });
}

function updateSingleRowInTable(editUserFormValues) {
  let table = $("#users-table").DataTable();
  table.row($(selectedRowIndex).parents("tr")).remove().draw();

  table.row
    .add({
      username: editUserFormValues.username,
      fullname: editUserFormValues.fullname,
      email: email,
      role: editUserFormValues.role,
      type: editUserFormValues.type,
      id: editUserFormValues.id,
    })
    .draw();

  selectedRowIndex = "";
  oldUsername = "";
  email = "";
}
// edit user

// delete user
$(document).on("click", ".delete-user-button", function () {
  let id = $(this).data("id");
  if (confirm("Are you sure want to delete this user ?")) {
    $.ajax({
      url: "php/delete_user.php",
      data: { id: id },
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

    removeRowFromTable.call(this);
  } else {
    return null;
  }
});

let removeRowFromTable = function () {
  let table = $("#users-table").DataTable();
  table.row($(this).parents("tr")).remove().draw();
};
// delete user
