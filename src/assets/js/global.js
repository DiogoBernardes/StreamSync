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

//Adicionar o conteúdo na mesma página
function loadContent(page) {
  console.log("Tentando carregar a página:", page);
  $.ajax({
    url: `/StreamSync/src/views/secure/user/${page}.php`,
    method: "GET",
    success: function (data) {
      $("#content").html(data);
    },
    error: function () {
      console.error("Erro ao carregar a página");
    },
  });
}
