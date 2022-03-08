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
          return (
            `<a href="#" data-id='` +
            data +
            `' class='btn btn-outline-info btn-rounded mr-1 edit-announcement-button'><i class="fas fa-pen"></i></a>` +
            `<a href="#" data-id='` +
            data +
            `' class='btn btn-outline-danger btn-rounded delete-announcement-button'><i class="fas fa-trash"></i></a>`
          );
        },
      },
    ],
  });
}
// display all logs

// add announcement
$("#add-new-announcement-button").click(function () {
  let date = $("#date-input").val();
  let title = $("#title-input").val();
  let message = $("#message-text-input").val();

  $.ajax({
    url: "php/add_announcement.php",
    data: {
      date: date,
      title: title,
      message: message,
    },
    type: "post",
    success: function (data) {
      let json = JSON.parse(data);
      let status = json.status;
      if (status == "true") {
        alert("Add announcement success");
        $("#add-announcement-modal").modal("hide");
      } else {
        alert("Add announcement failed");
      }
    },
  });
});
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
  let id = $("#edited-id").val();
  let date = $("#edit-date-input").val();
  let title = $("#edit-title-input").val();
  let message = $("#edit-message-text-input").val();

  console.log("test");

  $.ajax({
    url: "php/update_announcement.php",
    data: {
      id: id,
      date: date,
      title: title,
      message: message,
    },
    type: "post",
    success: function (data) {
      let json = JSON.parse(data);
      let status = json.status;

      if (status == "true") {
        $("#edit-announcement-modal").modal("hide");
        const announcementData = {
          id: id,
          date: date,
          title: title,
          message: message,
        };
        updateSingleRowInTable(announcementData);
        alert("Update announcement success");
      } else {
        alert("Update announcement failed");
      }
    },
  });
});

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
