//Esconder os alertas dos erros ao fim de 3s
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
//Update no texto do botão de upload da imagem
function updateFileName(input) {
  const fileName = input.files[0].name;
  const selectedFileName = document.getElementById("selectedFileName");
  selectedFileName.innerText = fileName;
}

// function updateFileName(input) {
//   const fileName = input.files[0].name;
//   const selectedFileName = document.getElementById("selectedFileName");
//   selectedFileName.innerText = fileName;
// }
