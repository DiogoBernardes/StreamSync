//Esconder os alertas dos erros ao fim de 3s
function hideAlerts() {
  var alerts = document.querySelectorAll(".alert");
  alerts?.forEach(function (alert) {
    setTimeout(function () {
      $(alert).fadeOut();
    }, 3000);
  });
}

document.addEventListener("DOMContentLoaded", function () {
  hideAlerts();

  let location = window.location.hash;
  if (location) {
    loadContent(location.replace("#", ""));
    return;
  }
  //loadContent("calendar");
});

//Adicionar o conteúdo na mesma página
function loadContent(page) {
  $.ajax({
    url: `/StreamSync/src/views/secure/user/${page}.php`,
    method: "GET",
    success: function (data) {
      $("#content").html(data);
      window.location.hash = page;
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
//fechar os colapses
function closeCollapse() {
  $(".collapse").collapse("hide");
}
// Adicionar listerner para parar o trailer quando o modal é fechado
document.addEventListener("DOMContentLoaded ", function () {
  var modals = document.querySelectorAll(".modal");

  modals.forEach(function (modal) {
    modal.addEventListener("hidden.bs.modal", function () {
      var iframe = modal.querySelector("iframe");

      if (iframe) {
        iframe.setAttribute("src", iframe.getAttribute("src"));
      }
    });
  });
});
