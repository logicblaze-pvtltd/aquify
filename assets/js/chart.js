var dayMonth1 = $("input[name='dayMonth0[]']")
  .map(function () {
    return $(this).val();
  })
  .get();
var dayMonth2 = $("input[name='dayMonth1[]']")
  .map(function () {
    return $(this).val();
  })
  .get();
var dayMonth3 = $("input[name='dayMonth2[]']")
  .map(function () {
    return $(this).val();
  })
  .get();
var dayMonth4 = $("input[name='dayMonth3[]']")
  .map(function () {
    return $(this).val();
  })
  .get();
var dayMonth5 = $("input[name='dayMonth4[]']")
  .map(function () {
    return $(this).val();
  })
  .get();
var dayMonth6 = $("input[name='dayMonth5[]']")
  .map(function () {
    return $(this).val();
  })
  .get();

var records1 = $("input[name='records0[]']")
  .map(function () {
    return $(this).val();
  })
  .get();
var records2 = $("input[name='records1[]']")
  .map(function () {
    return $(this).val();
  })
  .get();
var records3 = $("input[name='records2[]']")
  .map(function () {
    return $(this).val();
  })
  .get();
var records4 = $("input[name='records3[]']")
  .map(function () {
    return $(this).val();
  })
  .get();
var records5 = $("input[name='records4[]']")
  .map(function () {
    return $(this).val();
  })
  .get();
var records6 = $("input[name='records5[]']")
  .map(function () {
    return $(this).val();
  })
  .get();

records1 = parseInt(records1, 10);
records2 = parseInt(records2, 10);
records3 = parseInt(records3, 10);
records4 = parseInt(records4, 10);
records5 = parseInt(records5, 10);
records6 = parseInt(records6, 10);

const salechart = document.getElementById("SalesChart").getContext("2d");

new Chart(salechart, {
  type: "line",
  data: {
    labels: [dayMonth1, dayMonth2, dayMonth3, dayMonth4, dayMonth5, dayMonth6],
    datasets: [
      {
        data: [records1, records2, records3, records4, records5, records6],
        label: "Sale Status",
        borderColor: "#3371FF",
        backgroundColor: "#D70040",
      },
    ],
  },
});

// No. of medicine Chart
var month1 = $("input[name='month0[]']")
  .map(function () {
    return $(this).val();
  })
  .get();
var month2 = $("input[name='month1[]']")
  .map(function () {
    return $(this).val();
  })
  .get();
var month3 = $("input[name='month2[]']")
  .map(function () {
    return $(this).val();
  })
  .get();
var month4 = $("input[name='month3[]']")
  .map(function () {
    return $(this).val();
  })
  .get();
var month5 = $("input[name='month4[]']")
  .map(function () {
    return $(this).val();
  })
  .get();
var month6 = $("input[name='month5[]']")
  .map(function () {
    return $(this).val();
  })
  .get();

var totalMed1 = $("input[name='totalMed0[]']")
  .map(function () {
    return $(this).val();
  })
  .get();
var totalMed2 = $("input[name='totalMed1[]']")
  .map(function () {
    return $(this).val();
  })
  .get();
var totalMed3 = $("input[name='totalMed2[]']")
  .map(function () {
    return $(this).val();
  })
  .get();
var totalMed4 = $("input[name='totalMed3[]']")
  .map(function () {
    return $(this).val();
  })
  .get();
var totalMed5 = $("input[name='totalMed4[]']")
  .map(function () {
    return $(this).val();
  })
  .get();
var totalMed6 = $("input[name='totalMed5[]']")
  .map(function () {
    return $(this).val();
  })
  .get();

totalMed1 = parseInt(totalMed1, 10);
totalMed2 = parseInt(totalMed2, 10);
totalMed3 = parseInt(totalMed3, 10);
totalMed4 = parseInt(totalMed4, 10);
totalMed5 = parseInt(totalMed5, 10);
totalMed6 = parseInt(totalMed6, 10);
const medchart = document.getElementById("MedicineChart").getContext("2d");

new Chart(medchart, {
  type: "bar",
  data: {
    labels: [month1, month2, month3, month4, month5, month6],
    datasets: [
      {
        data: [
          totalMed1,
          totalMed2,
          totalMed3,
          totalMed4,
          totalMed5,
          totalMed6,
        ],
        label: "No. of Supply",
        backgroundColor: "#3371FF",
      },
    ],
  },
});

$(document).ready(function () {
  setInterval(paymentStatus, 5000);
  // read();
  // $("#refreshNot").click(function () {
  //   $.ajax({
  //     type: "post",
  //     url: "./ajax/notification.php",
  //     data: {
  //       status: 1,
  //     },
  //     success: function (res) {
  //       if (res == "1") {
  //         read();
  //       }
  //     },
  //   });
  // });
});
//  function read(){
//   $.ajax({
//     type: "post",
//     url: "./ajax/readNot.php",
//     data: {
//       noti: 1,
//     },
//     success: function (res) {
//       if (res) {
//         $(".noti").html(res);
//       }
//     },
//   });
//  }
function paymentStatus() {
  var status = $("#userStatus").val();
  var days = $("#days").val();
  if (days >= 30 && status == 0) {
    const Toast = Swal.mixin({
      position: "top-center",
      showConfirmButton: true,
      confirmButtonText: "OK",
      preConfirm: () => {
        return (window.location.href = "paymentStatus.php");
      },
    });
    Toast.fire({
      icon: "Error",
      title: "Kindly Pay Your Pending Dues!! \n" + (37 - days) + " days Left",
    });
  }
}
