$(document).ready(function () {
  getTodaysLog();
});

function getTodaysLog() {
  fetch("php/get_todays_log.php")
    .then((res) => res.json())
    .then((response) => {
      let logData = [];
      for (let i = 0; i < response.length; i++) {
        // convert time to 12 hour format
        let dateAndTime = response[i].time;
        let date = dateAndTime.substring(0, 10);
        let time = dateAndTime.substr(dateAndTime.length - 8);
        dateAndTime = date + " " + moment(time, "HH:mm:ss").format("hh:mm A");

        let data = {
          id: response[i].id,
          full_name: response[i].full_name,
          contact_number: response[i].contact_number,
          address: response[i].address,
          age: response[i].age,
          temperature: response[i].temperature,
          gender: response[i].gender,
          reason: response[i].reason,
          selected_buildings: response[i].selected_buildings,
          image_name: response[i].image_name,
          time: dateAndTime,
        };
        logData.push(data);
      }
      initializeDatetalbe(logData);
    })
    .catch((error) => console.log(error));
}

function initializeDatetalbe(logData) {
  $("#logbook-table").DataTable({
    data: logData,
    dom: "Bfrtip",
    buttons: [
      {
        extend: "print",
        exportOptions: {
          columns: [0, 1, 2, 3, 4, 5, 6, 7, 8],
        },
      },
    ],
    responsive: true,
    pageLength: 100,
    searching: true,
    ordering: true,
    columns: [
      { data: "time" },
      { data: "full_name" },
      { data: "address" },
      { data: "age" },
      { data: "temperature" },
      { data: "gender" },
      { data: "reason" },
      { data: "selected_buildings" },
      { data: "contact_number" },
      {
        data: "id",
        render: function (data, type, row, meta) {
          let editButton = ``;
          let deleteButton = ``;

          if (editLog == 1) {
            editButton =
              `<a href="#" data-id='` +
              data +
              `' class='btn btn-outline-info btn-rounded mr-1 edit-log-button'><i class="fas fa-pen"></i></a>`;
          } else {
            editButton = ``;
          }

          if (deleteLog == 1) {
            deleteButton =
              `<a href="#" data-id='` +
              data +
              `' class='btn btn-outline-danger btn-rounded delete-log-button'><i class="fas fa-trash"></i></a>`;
          } else {
            deleteButton = ``;
          }

          return editButton + deleteButton;
        },
      },
    ],
    language: {
      emptyTable: "No logs on that day.",
    },
  });
}

// delete log script
$(document).on("click", ".delete-log-button", function () {
  let id = $(this).data("id");
  if (confirm("Are you sure want to delete this Log ?")) {
    $.ajax({
      url: "php/delete_log.php",
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
  let table = $("#logbook-table").DataTable();
  table.row($(this).parents("tr")).remove().draw();
};
// delete log script

// edit log script
let selectedRowIndex = "";

$(document).on("click", ".edit-log-button", function () {
  let id = $(this).data("id");
  $("#edit-log-modal").modal("show");
  $.ajax({
    url: "php/get_single_log.php",
    data: { id: id },
    type: "post",
    success: function (data) {
      var json = JSON.parse(data);
      $("#edited-fullname").val(json.full_name);
      $("#edited-age").val(json.age);
      $("#edited-address").val(json.address);
      $("#edited-contactnumber").val(json.contact_number);
      $("#edited-temp").val(json.temperature);
      $("#edited-gender").val(json.gender).change();
      $("#edited-reason").val(json.reason).change();
      $("#edited-target-location").val(json.selected_buildings);
      $("#edited-id").val(id);
      $("#edited-time").val(json.time);

      // load image
      let baseURL = "https://pucls.000webhostapp.com/php/imageupload/";
      let imageName = json.image_name;

      $.ajax({
        url: baseURL + imageName,
        type: "HEAD",
        success: function () {
          $("#selfie-img").prop("src", baseURL + imageName);
        },
        error: function () {
          $("#selfie-img").prop("src", "php/imageupload/selfie_image.png");
        },
      });
    },
  });

  selectedRowIndex = this;
});

$(document).on("click", ".update-log-button", function () {
  let id = $("#edited-id").val();
  let fullname = $("#edited-fullname").val();
  let age = $("#edited-age").val();
  let gender = $("#edited-gender").val();
  let address = $("#edited-address").val();
  let contactnumber = $("#edited-contactnumber").val();
  let temperature = $("#edited-temp").val();
  let reason = $("#edited-reason").val();
  let selectedBuildings = $("#edited-target-location").val();
  let time = $("#edited-time").val();

  let editLogFormIsValid = validateEditLogForm();

  if (editLogFormIsValid) {
    $.ajax({
      url: "php/update_log.php",
      data: {
        id: id,
        fullname: fullname,
        age: age,
        gender: gender,
        address: address,
        contactnumber: contactnumber,
        temperature: temperature,
        reason: reason,
        time: time,
      },
      type: "post",
      success: function (data) {
        let json = JSON.parse(data);
        let status = json.status;

        if (status == "true") {
          $("#edit-log-modal").modal("hide");
          const logData = {
            id: id,
            fullname: fullname,
            age: age,
            gender: gender,
            address: address,
            contactnumber: contactnumber,
            temperature: temperature,
            reason: reason,
            selected_buildings: selectedBuildings,
            time: time,
          };
          updateSingleRowInTable(logData);
          alert("Update Log Success");
        } else {
          alert("Update Log Failed");
        }
      },
    });
  } else {
    alert("Please fill up form properly");
  }
});

function validateEditLogForm() {
  let editLogFormIsValid = false;

  let fullname = $("#edited-fullname").val();
  let age = $("#edited-age").val();
  let gender = $("#edited-gender").val();
  let address = $("#edited-address").val();
  let contactnumber = $("#edited-contactnumber").val();
  let temperature = $("#edited-temp").val();
  let reason = $("#edited-reason").val();

  if (
    fullname == "" ||
    fullname.length > 70 ||
    age == "" ||
    age.length > 2 ||
    gender == "" ||
    gender.length > 6 ||
    address == "" ||
    address.length > 70 ||
    contactnumber == "" ||
    contactnumber.length > 12 ||
    temperature == "" ||
    temperature.length > 5 ||
    reason == "" ||
    reason.length > 255
  ) {
    editLogFormIsValid = false;
  } else {
    editLogFormIsValid = true;
  }

  return editLogFormIsValid;
}

function updateSingleRowInTable(logData) {
  let table = $("#logbook-table").DataTable();
  table.row($(selectedRowIndex).parents("tr")).remove().draw();

  table.row
    .add({
      time: logData.time,
      full_name: logData.fullname,
      address: logData.address,
      age: logData.age,
      temperature: logData.temperature,
      gender: logData.gender,
      reason: logData.reason,
      selected_buildings: logData.selected_buildings,
      contact_number: logData.contactnumber,
      id: logData.id,
    })
    .draw();

  selectedRowIndex = "";
}
// edit log script

// date range picker
$(function () {
  var start = moment().set({ hour: 01, minute: 00, second: 00 });
  var end = moment().set({ hour: 23, minute: 59, second: 59 });

  function cb(start, end) {
    $("#reportrange span").html(
      start.format("MMMM D, YYYY   hh-mm A") +
        "  -  " +
        end.format("MMMM D, YYYY   hh-mm A")
    );

    getDateTargetLogs(
      start.format("YYYY:MM:DD HH:mm:ss"),
      end.format("YYYY:MM:DD HH:mm:ss")
    );
  }

  $("#reportrange").daterangepicker(
    {
      timePicker: true,
      startDate: start,
      endDate: end,
      ranges: {
        Today: [
          moment().set({ hour: 01, minute: 00, second: 00 }),
          moment().set({ hour: 23, minute: 59, second: 59 }),
        ],
        Yesterday: [
          moment()
            .subtract(1, "days")
            .set({ hour: 01, minute: 00, second: 00 }),
          moment()
            .subtract(1, "days")
            .set({ hour: 23, minute: 59, second: 59 }),
        ],
        "Last 7 Days": [
          moment()
            .subtract(6, "days")
            .set({ hour: 01, minute: 00, second: 00 }),
          moment().set({ hour: 23, minute: 59, second: 59 }),
        ],
        "Last 30 Days": [
          moment()
            .subtract(29, "days")
            .set({ hour: 01, minute: 00, second: 00 }),
          moment().set({ hour: 23, minute: 59, second: 59 }),
        ],
        "This Month": [
          moment().startOf("month").set({ hour: 01, minute: 00, second: 00 }),
          moment().endOf("month").set({ hour: 23, minute: 59, second: 59 }),
        ],
        "Last Month": [
          moment()
            .subtract(1, "month")
            .startOf("month")
            .set({ hour: 01, minute: 00, second: 00 }),
          moment()
            .subtract(1, "month")
            .endOf("month")
            .set({ hour: 23, minute: 59, second: 59 }),
        ],
      },
    },
    cb
  );
});

function getDateTargetLogs(startDate, endDate) {
  $.ajax({
    url: "php/get_date_range_log.php",
    data: { startDate: startDate, endDate: endDate },
    type: "post",
    success: function (data) {
      let response = JSON.parse(data);
      let logData = [];
      for (let i = 0; i < response.length; i++) {
        // convert time to 12 hour format
        let dateAndTime = response[i].time;
        let date = dateAndTime.substring(0, 10);
        let time = dateAndTime.substr(dateAndTime.length - 8);
        dateAndTime = date + " " + moment(time, "HH:mm:ss").format("hh:mm A");

        let data = {
          id: response[i].id,
          full_name: response[i].full_name,
          contact_number: response[i].contact_number,
          address: response[i].address,
          age: response[i].age,
          temperature: response[i].temperature,
          gender: response[i].gender,
          reason: response[i].reason,
          selected_buildings: response[i].selected_buildings,
          time: dateAndTime,
        };
        logData.push(data);
      }
      displayDateTargetLogs(logData);
    },
  });
}

function displayDateTargetLogs(logData) {
  let table = $("#logbook-table").DataTable();
  table.clear();
  table.rows.add(logData);
  table.draw();
}
// date range picker
