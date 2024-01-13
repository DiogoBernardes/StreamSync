<?php
$title = 'Inserir';
require_once __DIR__ . '../../../../infrastructure/middlewares/middleware-user.php';
require_once __DIR__ . '../../../../repositories/listsRepository.php';
require_once __DIR__ . '../../../../repositories/listContentRepository.php';
require_once __DIR__ . '../../../../repositories/contentRepository.php';
include_once __DIR__ . '../../../../templates/header.php';
@require_once __DIR__ . '/../../../validations/session.php';
$user = user();

$lists = getAllLists($user['id']);
$itemsPerPage = 6;
$totalItems = count($lists);
$totalPages = ceil($totalItems / $itemsPerPage);

?>

<body>
  <div class="container min-vh-100">
    <div class="mt-3">
      <h2 class="title-color">Listas</h2>
      <hr class="my-4 border-primary">
    </div>
    <div class="d-flex justify-content-between mt-2">
      <nav aria-label="Page navigation" class="d-flex justify-content-center ms-5">
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
      <button type="button" class="btn btn-outline-info me-5" data-toggle="modal" data-target="#contentModal">
        <span class="d-flex align-items-end">Nova Lista</span>
      </button>
    </div>

    <?php if ($totalItems > 0) : ?>

      <div id="listCarousel" class="carousel slide mt-4" data-interval="false">
        <div class="carousel-inner">
          <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
            <div class="carousel-item <?= ($i == 1) ? 'active' : ''; ?>">
              <div class="row">
                <?php $startIndex = ($i - 1) * $itemsPerPage; ?>
                <?php foreach (array_slice($lists, $startIndex, $itemsPerPage) as $list) : ?>
                  <div class="col-lg-4 col-md-6 col-sm-12 mt-4 mb-3 d-flex justify-content-center py-2">
                    <div class="card z-index-2 w-80 card-color">
                      <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">
                        <div class="bg-gradient-dark shadow-dark border-radius-lg py-3 pe-1 h-25">
                          <?php
                          $randomImage = '';
                          $listContents = getAllListContent($list['id']);
                          foreach ($listContents as $content) :
                            $contentDetails = getContentById($content['content_id']);
                            if (!empty($contentDetails) && isset($contentDetails['poster'])) {
                              $randomImage = $contentDetails['poster'];
                              break;
                            }
                          endforeach;
                          ?>
                          <?php if (!empty($randomImage)) : ?>
                            <a href="listContent.php?list_id=<?= $list['id']; ?>"> <img class="chart-canvas rounded w-100 mt-less40 h-200px" src="data:image/jpeg;base64,<?= base64_encode($randomImage); ?>" alt="<?= isset($contentDetails['title']) ? $contentDetails['title'] : 'Title Not Available'; ?>" />
                            </a>
                          <?php else : ?>
                            <a href="listContent.php?list_id=<?= $list['id']; ?>">
                              <img class="chart-canvas rounded w-100 mt-less40 h-200px" src="https://motoxpert.pt/sh_website_category_page/static/src/img/default.png" alt="Default Image" />
                            </a>
                          <?php endif; ?>
                        </div>
                      </div>
                      <div class="card-body ">
                        <div class="d-flex justify-content-between">
                          <h5 class="mb-0 "><a href="listContent.php?list_id=<?= $list['id']; ?>" class="text-decoration-none text-dark fw-bold"><?= $list['name']; ?></a></h5>
                          <div>
                            <i class="bi bi-pen pointer" data-toggle="modal" data-target="#updateModal<?= $list['id']; ?>"></i>
                            <i class="bi bi-trash delete-icon ms-2 pointer" data-bs-toggle="modal" data-bs-target="#deleteModal<?= $list['id']; ?>"></i>
                            <i class="bi bi-share text-end ms-2 pointer share-icon" data-bs-toggle="modal" data-bs-target="#shareModal<?= $list['id']; ?>"></i>
                          </div>
                        </div>
                        <hr class="dark horizontal">
                        <div class="d-flex align-items-center">
                          <i class="material-icons text-sm me-1">Atualizado:</i>
                          <p class="mb-0 small"><?= date('d/m/Y', strtotime($list['updated_at'])); ?></p>
                        </div>

                      </div>
                    </div>
                  </div>
                <?php endforeach; ?>
              </div>
            </div>
          <?php endfor; ?>
        </div>
      </div>

    <?php else : ?>
      <div class="d-flex justify-content-center align-items-center h-50">
        <h3 class="text-center">Ainda não possui nenhuma lista.</h3>
      </div>
    <?php endif; ?>

    <!-- Modal Criar nova lista -->
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



    <!-- Modal Atualizar Lista -->
    <?php foreach ($lists as $list) : ?>
      <div class="modal fade" id="updateModal<?= $list['id']; ?>" tabindex="-1" aria-labelledby="updateModalLabel<?= $list['id']; ?>" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="updateModalLabel<?= $list['id']; ?>">Atualizar lista</h5>
            </div>
            <div class="modal-body">
              <form enctype="multipart/form-data" action="/StreamSync/src/controllers/admin/lists.php" method="post" class="form-control py-3 border-0">
                <div class="row mt-2 mb-4">
                  <div class="form-group">
                    <label for="title">Nome</label>
                    <input type="text" class="form-control" name="name" value="<?= $list['name']; ?>" maxlength="100" size="100" required>
                  </div>
                </div>
                <input type="hidden" name="id" value="<?= $list['id']; ?>">
                <div class="row">
                  <div class="text-right">
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                      <button type="submit" id="submit" name="list" value="update" class="btn btn-primary">Guardar</button>
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    <?php endforeach; ?>


    <!-- Modal Eliminar lista -->
    <?php foreach ($lists as $list) : ?>
      <div class="modal fade" id="deleteModal<?= $list['id']; ?>" tabindex="-1" aria-labelledby="deleteModalLabel<?= $list['id']; ?>" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="deleteModalLabel<?= $list['id']; ?>">Eliminar lista</h5>
            </div>
            <div class="modal-body">
              <p class="card-title">
                Tem certeza de que deseja eliminar a lista <?= $list['name']; ?>?
              </p>
              <br>
              <p>Não poderá recuperar a mesma posteriormente.</p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
              <form action="/StreamSync/src/controllers/admin/lists.php" method="get">
                <input type="hidden" name="list_id" value="<?= $list['id'] ?>">
                <input type="hidden" name="list" value="delete">
                <button type="submit" class="btn btn-danger">Sim, eliminar a lista</button>
              </form>

            </div>
          </div>
        </div>
      </div>
    <?php endforeach; ?>


    <!-- Modal partilhar Lista -->
    <?php foreach ($lists as $list) : ?>
      <div class="modal fade" id="shareModal<?= $list['id']; ?>" tabindex="-1" aria-labelledby="shareModalLabel<?= $list['id']; ?>" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="shareModalLabel<?= $list['id']; ?>">Partilhar lista</h5>
            </div>
            <div class="modal-body">
              <form enctype="multipart/form-data" action="/StreamSync/src/controllers/admin/shared.php" method="post" class="form-control py-3 border-0">
                <div class="row mt-2 mb-4">
                  <div class="form-group">
                    <label for="email">Email do destinatário:</label>
                    <input type="email" class="form-control" name="email" placeholder="Email do destinatário" required>
                  </div>
                </div>
                <input type="hidden" name="list_id" value="<?= $list['id']; ?>">
                <div class="row">
                  <div class="text-right">
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                      <button type="submit" id="submit" name="share" value="create" class="btn btn-primary">Partilhar</button>
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    <?php endforeach; ?>



</body>