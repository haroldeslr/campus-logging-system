$(document).ready(function () {
  getYearlyLogStats();
  getMonthlyLogStats();
  getDailyLogStats();

  let logData = [];
  initializeDatetalbe();
});

// daily logs
function getDailyLogStats() {
  let date1 = "";
  let date2 = "";
  let date3 = "";
  let date4 = "";
  let date5 = "";
  let date6 = "";
  let date7 = "";

  let day1 = "";
  let day2 = "";
  let day3 = "";
  let day4 = "";
  let day5 = "";
  let day6 = "";
  let day7 = "";

  for (let day = 6; day >= 0; day--) {
    let myCurrentDate = new Date();
    myCurrentDate.setDate(myCurrentDate.getDate() - day);
    let getDateOnly = new Date(myCurrentDate).getDate();
    let getMonthOnly = new Date(myCurrentDate).getMonth() + 1;

    let formatDate = "";
    if (getDateOnly <= 9) {
      formatDate = "0" + getDateOnly;
    } else {
      formatDate = getDateOnly;
    }

    let formatMonth = "";
    if (getMonthOnly <= 9) {
      formatMonth = "0" + getMonthOnly;
    } else {
      formatMonth = getMonthOnly;
    }

    $.ajax({
      url: "php/get_daily_logs_stats.php",
      data: { date: formatDate, month: formatMonth },
      type: "post",
      success: function (data) {
        let json = JSON.parse(data);
        if (day == 6) {
          day1 = json.length;
          date1 = formatDate;
        } else if (day == 5) {
          day2 = json.length;
          date2 = formatDate;
        } else if (day == 4) {
          day3 = json.length;
          date3 = formatDate;
        } else if (day == 3) {
          day4 = json.length;
          date4 = formatDate;
        } else if (day == 2) {
          day5 = json.length;
          date5 = formatDate;
        } else if (day == 1) {
          day6 = json.length;
          date6 = formatDate;
        } else if (day == 0) {
          day7 = json.length;
          date7 = formatDate;
        }
      },
    });
  }

  setTimeout(function () {
    displayDailyLogStats(
      day1,
      day2,
      day3,
      day4,
      day5,
      day6,
      day7,
      date1,
      date2,
      date3,
      date4,
      date5,
      date6,
      date7
    );
  }, 3000);
}

function displayDailyLogStats(
  day1,
  day2,
  day3,
  day4,
  day5,
  day6,
  day7,
  date1,
  date2,
  date3,
  date4,
  date5,
  date6,
  date7
) {
  const dailyLogsChart = document.querySelector(".daily-logs-chart");
  new Chart(dailyLogsChart, {
    type: "bar",
    data: {
      labels: [date1, date2, date3, date4, date5, date6, date7],
      datasets: [
        {
          label: "# of Daily Visitors",
          backgroundColor: "rgba(51, 102, 153, .5)",
          borderColor: "rgba(51, 102, 153)",
          borderWidth: 1,
          data: [day1, day2, day3, day4, day5, day6, day7],
        },
      ],
    },
    options: {
      responsive: true,
      title: { display: false, text: "Chart" },
      legend: { position: "top", display: true },
      tooltips: { mode: "index", intersect: false },
      hover: { mode: "nearest", intersect: true },
      tooltips: {
        mode: "index",
        intersect: false,
      },
      responsive: true,
      scales: {
        xAxes: [
          {
            stacked: true,
            scaleLabel: {
              display: true,
              labelString: "Days",
            },
          },
        ],
        yAxes: [
          {
            stacked: true,
            scaleLabel: {
              display: true,
              labelString: "Number of Visitors",
            },
          },
        ],
      },
    },
  });

  $("#daily-logs-loading-spinner").addClass("d-none");
}
// daily logs

// monthly logs
function getMonthlyLogStats() {
  let jan = "";
  let feb = "";
  let mar = "";
  let apr = "";
  let may = "";
  let jun = "";
  let jul = "";
  let aug = "";
  let sept = "";
  let oct = "";
  let nov = "";
  let dec = "";

  for (let month = 1; month <= 12; month++) {
    let formatMonth = "";
    if (month <= 9) {
      formatMonth = "0" + month;
    } else {
      formatMonth = month;
    }

    $.ajax({
      url: "php/get_monthly_logs_stats.php",
      data: { month: formatMonth },
      type: "post",
      success: function (data) {
        let json = JSON.parse(data);
        if (month == 1) {
          jan = json.length;
        } else if (month == 2) {
          feb = json.length;
        } else if (month == 3) {
          mar = json.length;
        } else if (month == 4) {
          apr = json.length;
        } else if (month == 5) {
          may = json.length;
        } else if (month == 6) {
          jun = json.length;
        } else if (month == 7) {
          jul = json.length;
        } else if (month == 8) {
          aug = json.length;
        } else if (month == 9) {
          sept = json.length;
        } else if (month == 10) {
          oct = json.length;
        } else if (month == 11) {
          nov = json.length;
        } else if (month == 12) {
          dec = json.length;
        }
      },
    });
  }

  setTimeout(function () {
    displayMonthlyLogStats(
      jan,
      feb,
      mar,
      apr,
      may,
      jun,
      jul,
      aug,
      sept,
      oct,
      nov,
      dec
    );
  }, 3000);
}

function displayMonthlyLogStats(
  jan,
  feb,
  mar,
  apr,
  may,
  jun,
  jul,
  aug,
  sept,
  oct,
  nov,
  dec
) {
  const monthlyLogsChart = document.querySelector(".monthly-logs-chart");
  new Chart(monthlyLogsChart, {
    type: "bar",
    data: {
      labels: [
        "JAN.",
        "FEB.",
        "MAR.",
        "APR.",
        "MAY",
        "JUN.",
        "JUL.",
        "AUG.",
        "SEPT.",
        "OCT.",
        "NOV.",
        "DEC.",
      ],
      datasets: [
        {
          label: "# of Monthly Visitors",
          backgroundColor: "rgba(255, 102, 0, .5)",
          borderColor: "rgba(255, 102, 0)",
          borderWidth: 1,
          data: [jan, feb, mar, apr, may, jun, jul, aug, sept, oct, nov, dec],
        },
      ],
    },
    options: {
      responsive: true,
      title: { display: false, text: "Chart" },
      legend: { position: "top", display: true },
      tooltips: { mode: "index", intersect: false },
      hover: { mode: "nearest", intersect: true },
      tooltips: {
        mode: "index",
        intersect: false,
      },
      responsive: true,
      scales: {
        xAxes: [
          {
            stacked: true,
            scaleLabel: {
              display: true,
              labelString: "Months",
            },
          },
        ],
        yAxes: [
          {
            stacked: true,
            scaleLabel: {
              display: true,
              labelString: "Number of Visitors",
            },
          },
        ],
      },
    },
  });

  $("#monthly-logs-loading-spinner").addClass("d-none");
}
// monthly logs

// yearly logs
function getYearlyLogStats() {
  let year2018 = "";
  let year2019 = "";
  let year2020 = "";
  let year2021 = "";
  let year2022 = "";

  for (let year = 2018; year <= 2022; year++) {
    $.ajax({
      url: "php/get_yearly_logs_stats.php",
      data: { year: year },
      type: "post",
      success: function (data) {
        let json = JSON.parse(data);
        if (year == 2018) {
          year2018 = json.length;
        } else if (year == 2019) {
          year2019 = json.length;
        } else if (year == 2020) {
          year2020 = json.length;
        } else if (year == 2021) {
          year2021 = json.length;
        } else if (year == 2022) {
          year2022 = json.length;
        }
      },
    });
  }

  setTimeout(function () {
    displayYearlyLogStats(year2018, year2019, year2020, year2021, year2022);
  }, 3000);
}

function displayYearlyLogStats(
  year2018,
  year2019,
  year2020,
  year2021,
  year2022
) {
  const yearlyLogsChart = document.querySelector(".yearly-logs-chart");
  new Chart(yearlyLogsChart, {
    type: "bar",
    data: {
      labels: ["2018", "2019", "2020", "2021", "2022"],
      datasets: [
        {
          label: "# of Yearly Visitors",
          backgroundColor: "rgba(76, 175, 80, .5)",
          borderColor: "rgba(76, 175, 80)",
          borderWidth: 1,
          data: [year2018, year2019, year2020, year2021, year2022],
        },
      ],
    },
    options: {
      responsive: true,
      title: { display: false, text: "Chart" },
      legend: { position: "top", display: true },
      tooltips: { mode: "index", intersect: false },
      hover: { mode: "nearest", intersect: true },
      tooltips: {
        mode: "index",
        intersect: false,
      },
      responsive: true,
      scales: {
        xAxes: [
          {
            stacked: true,
            scaleLabel: {
              display: true,
              labelString: "Years",
            },
          },
        ],
        yAxes: [
          {
            stacked: true,
            scaleLabel: {
              display: true,
              labelString: "Number of Visitors",
            },
          },
        ],
      },
    },
  });

  $("#yearly-logs-loading-spinner").addClass("d-none");
}
// yearly logs

// datatable script
$(document).on("click", "#generate-daily-logs-btn", function () {
  getTodaysLog();
});

$(document).on("click", "#generate-weekly-logs-btn", function () {
  getWeeklyLogs();
});

$(document).on("click", "#generate-monthly-logs-btn", function () {
  getMonthlyLogs();
});

$(document).on("click", "#generate-yearly-logs-btn", function () {
  getYearlyLogs();
});

function initializeDatetalbe(logData) {
  $("#generate-report-table").DataTable({
    data: logData,
    dom: "Bfrtip",
    buttons: [
      {
        extend: "print",
        text: "Print",
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
    ],
  });
}

// get weekly logs
function getTodaysLog() {
  let start = moment().set({ hour: 01, minute: 00, second: 00 });
  let end = moment().set({ hour: 23, minute: 59, second: 59 });
  getDateTargetLogs(
    start.format("YYYY:MM:DD HH:mm:ss"),
    end.format("YYYY:MM:DD HH:mm:ss")
  );
}

function getWeeklyLogs() {
  let start = moment()
    .subtract(6, "days")
    .set({ hour: 01, minute: 00, second: 00 });
  let end = moment().set({ hour: 23, minute: 59, second: 59 });
  getDateTargetLogs(
    start.format("YYYY:MM:DD HH:mm:ss"),
    end.format("YYYY:MM:DD HH:mm:ss")
  );
}

function getMonthlyLogs() {
  let start = moment()
    .subtract(29, "days")
    .set({ hour: 01, minute: 00, second: 00 });
  let end = moment().set({ hour: 23, minute: 59, second: 59 });
  getDateTargetLogs(
    start.format("YYYY:MM:DD HH:mm:ss"),
    end.format("YYYY:MM:DD HH:mm:ss")
  );
}

function getYearlyLogs() {
  let start = moment()
    .subtract(12, "months")
    .set({ hour: 01, minute: 00, second: 00 });
  let end = moment().set({ hour: 23, minute: 59, second: 59 });
  getDateTargetLogs(
    start.format("YYYY:MM:DD HH:mm:ss"),
    end.format("YYYY:MM:DD HH:mm:ss")
  );
}

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
        //dateAndTime = date + " " + moment(time, "HH:mm:ss").format("hh:mm A");

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
  let table = $("#generate-report-table").DataTable();
  table.clear();
  table.rows.add(logData);
  table.draw();

  $(".buttons-print")[0].click();
}
