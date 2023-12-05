function hideAlerts() {
  var alerts = document.querySelectorAll(".alert");
  alerts.forEach(function (alert) {
    setTimeout(function () {
      alert.style.display = "none";
    }, 3000);
  });
}

document.addEventListener("DOMContentLoaded", function () {
  hideAlerts();
});
