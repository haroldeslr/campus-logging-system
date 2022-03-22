$(document).ready(function () {
  displayAllAnnouncement();
});

// display all announcement
function displayAllAnnouncement() {
  fetch("php/get_all_announcement.php")
    .then((res) => res.json())
    .then((response) => {
      let announcementsData = [];
      for (let i = 0; i < response.length; i++) {
        let data = {
          id: response[i].id,
          date: response[i].date,
          title: response[i].title,
          message: response[i].message,
        };
        announcementsData.push(data);
      }
      updateTable(announcementsData);
    })
    .catch((error) => console.log(error));
}

function updateTable(announcementsData) {
  $("#announcement-table").DataTable({
    data: announcementsData,
    responsive: true,
    pageLength: 25,
    lengthChange: true,
    searching: true,
    ordering: true,
    columns: [
      { data: "date" },
      { data: "title" },
      { data: "message" },

      {
        data: "id",
        render: function (data, type, row, meta) {
          let editButton = ``;
          let deleteButton = ``;

          if (editAnnouncement == 1) {
            editButton =
              `<a href="#" data-id='` +
              data +
              `' class='btn btn-outline-info btn-rounded mr-1 edit-announcement-button'><i class="fas fa-pen"></i></a>`;
          } else {
            editButton = ``;
          }

          if (deleteAnnouncement == 1) {
            deleteButton =
              `<a href="#" data-id='` +
              data +
              `' class='btn btn-outline-danger btn-rounded delete-announcement-button'><i class="fas fa-trash"></i></a>`;
          } else {
            deleteButton = ``;
          }

          return editButton + deleteButton;
        },
      },
    ],
  });
}
// display all announcement

// add announcement
$("#add-new-announcement-button").click(function () {
  let announcementValue = getAddAnnouncementFormValue();
  let addAnnouncementFormIsValid =
    validateAddAnnouncementForm(announcementValue);

  if (addAnnouncementFormIsValid) {
    saveAnnouncementToDatabase(announcementValue);
  } else {
    alert("Fill up form before saving");
  }
});

function getAddAnnouncementFormValue() {
  let date = $("#date-input").val();
  let title = $("#title-input").val();
  let message = $("#message-text-input").val();

  let announcementValue = {
    date: date,
    title: title,
    message: message,
  };

  return announcementValue;
}

function validateAddAnnouncementForm(announcementValue) {
  let addAnnouncementFormIsValid;

  if (
    announcementValue.date === "" ||
    announcementValue.title === "" ||
    announcementValue.message === ""
  ) {
    addAnnouncementFormIsValid = false;
  } else {
    addAnnouncementFormIsValid = true;
  }

  return addAnnouncementFormIsValid;
}

function saveAnnouncementToDatabase(announcementValue) {
  $.ajax({
    url: "php/add_announcement.php",
    data: {
      date: announcementValue.date,
      title: announcementValue.title,
      message: announcementValue.message,
    },
    type: "post",
    success: function (data) {
      let json = JSON.parse(data);
      let status = json.status;

      if (status == "true") {
        alert("Add announcement success");
        getNewAnnouncement(announcementValue);
      } else {
        alert("Add announcement failed");
      }

      $("#add-announcement-modal").modal("hide");
      $("#add-announcement-form").trigger("reset");
    },
  });
}

function getNewAnnouncement(announcementValue) {
  $.ajax({
    url: "php/get_new_announcement.php",
    data: {
      date: announcementValue.date,
      title: announcementValue.title,
      message: announcementValue.message,
    },
    type: "post",
    success: function (data) {
      let announcementData = JSON.parse(data);
      addAnnouncementToDatatable(announcementData);
    },
  });
}

function addAnnouncementToDatatable(announcementData) {
  let announcementTable = $("#announcement-table").DataTable();
  let rowNode = announcementTable.row
    .add({
      date: announcementData.date,
      title: announcementData.title,
      message: announcementData.message,
      id: announcementData.id,
    })
    .draw()
    .node();

  $(rowNode).css("color", "green").animate({ color: "black" });
}
// add announcement

// delete announcement
$(document).on("click", ".delete-announcement-button", function () {
  let id = $(this).data("id");
  if (confirm("Are you sure want to delete this announcement ?")) {
    $.ajax({
      url: "php/delete_announcement.php",
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
  let table = $("#announcement-table").DataTable();
  table.row($(this).parents("tr")).remove().draw();
};
// delete announcement

// edit announcement script
let selectedRowIndex = "";

$(document).on("click", ".edit-announcement-button", function () {
  let id = $(this).data("id");
  $("#edit-announcement-modal").modal("show");
  $.ajax({
    url: "php/get_single_announcement.php",
    data: { id: id },
    type: "post",
    success: function (data) {
      var json = JSON.parse(data);
      $("#edited-id").val(id);
      $("#edit-date-input").val(json.date);
      $("#edit-title-input").val(json.title);
      $("#edit-message-text-input").val(json.message);
    },
  });

  selectedRowIndex = this;
});

$(document).on("click", ".save-announcement-button", function () {
  let editAnnouncementFormValues = getEditAnnouncementFormValues();
  let editAnnouncementFormIsValid = validateEditAnnouncementForm(
    editAnnouncementFormValues
  );

  if (editAnnouncementFormIsValid) {
    updateEditAnnouncementToDatabase(editAnnouncementFormValues);
  } else {
    alert("Fill up form before saving");
  }
});

function getEditAnnouncementFormValues() {
  let id = $("#edited-id").val();
  let date = $("#edit-date-input").val();
  let title = $("#edit-title-input").val();
  let message = $("#edit-message-text-input").val();

  let editAnnouncementFormValues = {
    id: id,
    date: date,
    title: title,
    message: message,
  };

  return editAnnouncementFormValues;
}

function validateEditAnnouncementForm(editAnnouncementFormValues) {
  let editAnnouncementFormIsValid;

  if (
    editAnnouncementFormValues.date === "" ||
    editAnnouncementFormValues.title === "" ||
    editAnnouncementFormValues.message === ""
  ) {
    editAnnouncementFormIsValid = false;
  } else {
    editAnnouncementFormIsValid = true;
  }

  return editAnnouncementFormIsValid;
}

function updateEditAnnouncementToDatabase(editAnnouncementFormValues) {
  $.ajax({
    url: "php/update_announcement.php",
    data: {
      id: editAnnouncementFormValues.id,
      date: editAnnouncementFormValues.date,
      title: editAnnouncementFormValues.title,
      message: editAnnouncementFormValues.message,
    },
    type: "post",
    success: function (data) {
      let json = JSON.parse(data);
      let status = json.status;

      if (status == "true") {
        updateSingleRowInTable(editAnnouncementFormValues);
        alert("Update announcement success");
      } else {
        alert("Update announcement failed");
      }

      $("#edit-announcement-modal").modal("hide");
    },
  });
}

function updateSingleRowInTable(announcementData) {
  let table = $("#announcement-table").DataTable();
  table.row($(selectedRowIndex).parents("tr")).remove().draw();

  table.row
    .add({
      date: announcementData.date,
      title: announcementData.title,
      message: announcementData.message,
      id: announcementData.id,
    })
    .draw();

  selectedRowIndex = "";
}
// edit announcement script
