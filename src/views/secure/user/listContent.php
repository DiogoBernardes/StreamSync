<?php
$title = 'Lista de Conteúdo';
require_once __DIR__ . '../../../../infrastructure/middlewares/middleware-user.php';
require_once __DIR__ . '../../../../repositories/listsRepository.php';
include_once __DIR__ . '../../../../templates/header.php';
@require_once __DIR__ . '/../../../validations/session.php';
require_once __DIR__ . '/Content.php';
$user = user();

//Obter o ID da lista
$listId = isset($_GET['list_id']) ? $_GET['list_id'] : null;

// Verificar se o ID da lista foi fornecido
if (!$listId) {
  echo "List ID not provided.";
  exit;
}

//Procurar os dados da lista pelo ID
$list = getListById($listId, $user['id']);

// Verificar se a lista existe
if (!$list) {
  echo "Lista não encontrada.";
  exit;
}

// Procurar o conteudo associado a lista
//$listContent = getListContent($listId, $user['id']);
?>

<body>
  <div class="container min-vh-100">
    <div class="row mt-2">
      <div class="col-md-12 d-flex justify-content-between align-items-center">
        <h2 class="title-color mb-0"><?= $list['name']; ?></h2>
        <i class="bi bi-arrow-return-left me-5 pointer"></i>
      </div>
    </div>
    <hr class="my-4 border-primary">


    <div class="me-5 text-end">
      <button type="button" class="btn btn-outline-info" data-toggle="modal" data-target="#contentModal">
        <span class="d-flex align-items-end">Adicionar Conteudo</span>
      </button>
      <a href="#contentModal" class="btn btn-outline-info" data-toggle="modal">
        <span class="d-flex align-items-end">Inserir Conteúdo</span>
      </a>
    </div>
  </div>
</body>