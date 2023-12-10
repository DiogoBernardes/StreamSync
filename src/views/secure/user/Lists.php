<?php
$title = 'Inserir';
require_once __DIR__ . '../../../../infrastructure/middlewares/middleware-user.php';
require_once __DIR__ . '../../../../repositories/listsRepository.php';
include_once __DIR__ . '../../../../templates/header.php';
@require_once __DIR__ . '/../../../validations/session.php';
$user = user();

// Simulação: obtém listas (substitua pela função adequada)
$lists = getAllLists($user['id']);
// Configurações da paginação
$itemsPerPage = 6;
$totalItems = count($lists);
$totalPages = ceil($totalItems / $itemsPerPage);
?>

<body>
  <div class="container min-vh-100  position-relative">
    <div>
      <h2 class="title-color">Listas</h2>
      <hr class="my-4 border-primary">
    </div>

    <div class="mt-3 me-5 text-end">
      <button type="button" class="btn btn-outline-info" data-toggle="modal" data-target="#contentModal">
        <span class="d-flex align-items-end">Nova Lista</span>
      </button>
    </div>

    <div id="listCarousel" class="carousel slide mt-3 " data-interval="false">
      <div class="carousel-inner">
        <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
          <div class="carousel-item <?= ($i == 1) ? 'active' : ''; ?>">
            <div class="row card-container">
              <?php $startIndex = ($i - 1) * $itemsPerPage; ?>
              <?php foreach (array_slice($lists, $startIndex, $itemsPerPage) as $list) : ?>
                <div class="col-md-4 d-flex justify-content-center">
                  <div class="card h-50 w-75 rounded border-dark">
                    <img src="https://motoxpert.pt/sh_website_category_page/static/src/img/default.png" class="card-img-top h-75" alt="Imagem da Lista">
                    <div class="card-body bg-color d-inline-flex justify-content-between p-1">
                      <h5 href="view-list.php?id=<?= $list['id']; ?>" class="card-title">
                        <?= $list['name']; ?>
                      </h5>
                      <i class="bi bi-share text-end"></i>
                    </div>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
        <?php endfor; ?>
      </div>
    </div>
    <nav aria-label="Page navigation" class=" d-flex justify-content-center">
      <ul class="pagination">
        <li class="page-item">
          <a class="page-link" href="#listCarousel" role="button" data-slide="prev" aria-label="Previous">
            <span aria-hidden="true">&laquo;</span>
          </a>
        </li>
        <li class="page-item">
          <a class="page-link" href="#listCarousel" role="button" data-slide="next" aria-label="Next">
            <span aria-hidden="true">&raquo;</span>
          </a>
        </li>
      </ul>
    </nav>
  </div>

  <div class="modal fade" id="contentModal" tabindex="-1" role="dialog" aria-labelledby="contentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h3 class="modal-title text-primary" id="contentModalLabel">Criar Lista</h3>
        </div>
        <div class="modal-body">
          <form enctype="multipart/form-data" action="/StreamSync/src/controllers/admin/lists.php" method="post" class="form-control py-3 border-0">
            <div class="row mt-2 mb-4">
              <div class="form-group">
                <label for="title">Nome</label>
                <input type="text" class="form-control" name="name" placeholder="Nome" maxlength="100" size="100" required>
              </div>
            </div>
            <div class="row">
              <div class="text-right">
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                  <button ype="submit" id="submit" name="list" value="create" class="btn btn-primary">Guardar</button>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</body>