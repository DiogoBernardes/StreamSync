<?php
$title = 'Inserir';
require_once __DIR__ . '../../../../infrastructure/middlewares/middleware-user.php';
require_once __DIR__ . '../../../../repositories/listsRepository.php';
require_once __DIR__ . '../../../../repositories/listContentRepository.php';
require_once __DIR__ . '../../../../repositories/contentRepository.php';
include_once __DIR__ . '../../../../templates/header.php';
@require_once __DIR__ . '/../../../validations/session.php';
$user = user();
$lists = getSharedListsByUserId($user['id']);
$itemsPerPage = 6;
$totalItems = count($lists);
$totalPages = ceil($totalItems / $itemsPerPage);

?>

<body>
  <div class="container min-vh-100">
    <div class="mt-3">
      <h2 class="title-color">Listas Partilhadas</h2>
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
                            <img class="chart-canvas rounded w-100 mt-less40 h-200px" src="data:image/jpeg;base64,<?= base64_encode($randomImage); ?>" alt="<?= isset($contentDetails['title']) ? $contentDetails['title'] : 'Title Not Available'; ?>" />
                          <?php else : ?>
                            <img class="chart-canvas rounded w-100 mt-less40 h-200px" src="https://motoxpert.pt/sh_website_category_page/static/src/img/default.png" alt="Default Image" />
                          <?php endif; ?>
                        </div>
                      </div>
                      <div class="card-body ">
                        <div class="d-flex justify-content-between">
                          <h5 class="mb-0 "><a href="listContent.php?list_id=<?= $list['id']; ?>" class="text-decoration-none text-dark fw-bold"><?= $list['name']; ?></a></h5>
                          <div>
                            <i class="bi bi-trash delete-icon ms-2 pointer" data-bs-toggle="modal" data-bs-target="#deleteModal<?= $list['id']; ?>"></i>
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


    <!-- Modal Eliminar Partilha -->
    <?php foreach ($lists as $list) : ?>
      <div class="modal fade" id="deleteModal<?= $list['id']; ?>" tabindex="-1" aria-labelledby="deleteModalLabel<?= $list['id']; ?>" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="deleteModalLabel<?= $list['id']; ?>">Eliminar partilha</h5>
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
              <form action="/StreamSync/src/controllers/admin/shared.php" method="get">
                <input type="hidden" name="list_id" value="<?= $list['id']; ?>">
                <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                <input type="hidden" name="share" value="delete">
                <button type="submit" class="btn btn-danger">Sim, eliminar a lista</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    <?php endforeach; ?>



</body>