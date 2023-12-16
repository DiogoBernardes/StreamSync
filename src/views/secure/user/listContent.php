<?php
$title = 'Lista de Conteúdo';
require_once __DIR__ . '../../../../infrastructure/middlewares/middleware-user.php';
require_once __DIR__ . '../../../../repositories/listsRepository.php';
require_once __DIR__ . '../../../../repositories/listContentRepository.php';
require_once __DIR__ . '../../../../repositories/contentRepository.php';
require_once __DIR__ . '../../../../repositories/categoryRepository.php';
require_once __DIR__ . '../../../../repositories/contentTypeRepository.php';
require_once __DIR__ . '../../../../repositories/shareRepository.php';
include_once __DIR__ . '../../../../templates/header.php';
@require_once __DIR__ . '/../../../validations/session.php';
require_once __DIR__ . '/Content.php';
$user = user();

$listId = isset($_GET['list_id']) ? $_GET['list_id'] : null;
$list = getListById($listId, $user['id']);
$listContent = getAllListContent($listId);
$isListOwner = is_array($list) && $list['user_id'] == $user['id'];
$isListSharedWithUser = checkIfListIsSharedWithUser($listId, $user['id']);
?>

<body class="bg-color">
  <div class="w-90 min-vh-100 m-auto">
    <div class="row mt-2">
      <div class="col-md-12 d-flex justify-content-between align-items-center">
        <a class="bi bi-arrow-bar-left pointer fs-3 transition title-color" href="Dashboard.php"></i></a>
      </div>
      <hr class="my-2 border-primary">
    </div>

    <div class="me-5 mt-3 text-end">
      <?php
      $origin_user = getShareByOriginUserId($user['id']);
      if ($isListOwner || $isListSharedWithUser) :
      ?>
          <a href="#contentModal" class="btn btn-outline-info" data-toggle="modal" data-list-id="<?= $list['id']; ?>">
            <span class="d-flex align-items-end">Inserir Conteúdo</span>
          </a>
      <?php endif; ?>

    </div>

    <section class="d-flex justify-content-center">
      <div class="py-4 w-90">
        <h1 id="pageHeaderTitle"></h1>
        <?php foreach ($listContent as $content) : ?>
          <?php
          $contentDetails = getContentById($content['content_id']);
          $typeDetails = getContentTypeById($contentDetails['type_id']);
          $categoryDetails = getCategoryById($contentDetails['category_id']);
          ?>
          <article class="postcard sidebar-color h-auto mt-1">

            <div class="postcard__img_link">
              <a href="infoContent.php?content_id=<?= $content['content_id']; ?>" class="text-decoration-none">
                <img class="postcard__img w-100 position-relative h-100" src="data:image/jpeg;base64,<?= base64_encode($contentDetails['poster']); ?>" alt="<?= isset($contentDetails['title']) ? $contentDetails['title'] : 'Title Not Available'; ?>" />
              </a>
            </div>
            </a>
            <div class="postcard__text position-relative d-flex flex-column w-100 text-left">
              <a href="infoContent.php?content_id=<?= $content['content_id']; ?>" class="text-decoration-none">
                <h4 class="text-white">
                  <?= isset($contentDetails['title']) ? $contentDetails['title'] : 'Title Not Available'; ?>
                </h4>
                <div class="overflow-hidden h-100 mt-2 text-white" style="max-height: 100px;">
                  <?= isset($contentDetails['synopsis']) ? ($contentDetails['synopsis']) : 'Write a Synopsis..'; ?>
                </div>
              </a>
              <ul class="d-flex p-0 flex-row flex-wrap mt-4 mb-0 justify-content-between">
                <a href="infoContent.php?content_id=<?= $content['content_id']; ?>" class="text-decoration-none w-75">
                  <div class="text-white">
                    <li class="bg-secondary d-inline-block rounded-3 ms-1 me-1 p-1">
                      <i class="fas fa-tag mr-2"></i><?= isset($typeDetails['name']) ? $typeDetails['name'] : 'Type Not Available'; ?>
                    </li>
                    <li class="bg-secondary d-inline-block rounded-3 ms-1 me-1 p-1">
                      <i class="fas fa-list mr-2"></i><?= isset($categoryDetails['name']) ? $categoryDetails['name'] : 'Category Not Available'; ?>
                    </li>
                  </div>
                </a>
                <div class="w-25 d-flex justify-content-end">
                  <?php
                  $origin_user = getShareByOriginUserId($user['id']);
                  if ($isListOwner || $isListSharedWithUser) :
                  ?>
                    <button type="button" class="btn btn-outline-info ms-2" data-toggle="modal" data-target="#updateContentModal<?= $content['content_id']; ?>">
                      <i class="bi bi-pen pointer transition">Atualizar</i>
                    </button>
                    <button type="button" class="btn btn-outline-danger ms-2" data-toggle="modal" data-target="#deleteContentModal<?= $content['content_id']; ?>">
                      <i class="bi bi-trash delete-icon ms-2 pointer transition">Remover</i>
                    </button>
                  <?php endif; ?>
                </div>
              </ul>
            </div>
          </article>


          <!-- Modal Atualizar Conteúdo -->
          <div class="modal fade" id="updateContentModal<?= $content['content_id']; ?>" tabindex="-1" aria-labelledby="updateContentModalLabel<?= $content['content_id']; ?>" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="updateContentModalLabel<?= $content['content_id']; ?>">Atualizar Conteúdo</h5>
                </div>
                <div class="modal-body">
                  <form enctype="multipart/form-data" action="/StreamSync/src/controllers/admin/content.php" method="post" class="form-control py-3 border-0">
                    <div class="d-flex justify-content-center align-items-center">
                      <div class="w-35 h-35">
                        <div class="d-flex justify-content-center">
                          <?php
                          if (isset($contentDetails['poster']) && !empty($contentDetails['poster'])) {
                            echo '<img src="data:image/jpeg;base64,' . base64_encode($contentDetails['poster']) . '" alt="Imagem do Conteúdo" class="rounded-circle w-75 h-75 mb-2">';
                          } else {
                            echo '<img src="https://pixsector.com/cache/517d8be6/av5c8336583e291842624.png" alt="Default content" class="rounded-circle w-75 h-75">';
                          }
                          ?>
                        </div>
                        <div class="card-body media align-items-center">
                          <div class="media-body">
                            <label class="btn btn-outline-primary file-label">
                              <span id="selectedFileName">
                                <?php if (isset($_FILES['avatar']) && $_FILES['avatar']['name'] !== '') : ?>
                                  <?= $_FILES['avatar']['name'] ?>
                                <?php else : ?>
                                  Carregue a sua fotografia
                                <?php endif; ?>
                              </span>
                              <input id="inputGroupFile01" accept="image/*" type="file" class="form-control position-absolute invisible" name="poster" onchange="updateFileName(this)" />
                            </label>
                            <label class="text-muted small d-flex justify-content-center">Permitido JPG, PNG</label>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row mt-2">
                      <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="form-group">
                          <label for="title">Titulo</label>
                          <input type="text" class="form-control" name="title" value="<?= $contentDetails['title']; ?>" placeholder="Título" maxlength="100" size="100" required>
                        </div>
                      </div>
                      <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                        <label for="content-type">Tipo de Conteúdo</label>
                        <select class="form-select" aria-label="Default select example" name="type_id" required>
                          <?php
                          foreach ($contentTypes as $contentType) {
                            $selected = ($contentType['id'] == $contentDetails['type_id']) ? 'selected' : '';
                            echo "<option value='{$contentType['id']}' $selected>{$contentType['name']}</option>";
                          }
                          ?>
                        </select>
                      </div>
                    </div>
                    <div class="row mt-1">
                      <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                        <label for="categories">Categorias</label>
                        <select class="form-select" aria-label="Default select example" name="category_id" required>
                          <?php
                          foreach ($categories as $category) {
                            $selected = ($category['id'] == $contentDetails['category_id']) ? 'selected' : '';
                            echo "<option value='{$category['id']}' $selected>{$category['name']}</option>";
                          }
                          ?>
                        </select>
                      </div>
                      <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="form-group">
                          <label for="watched_date">Assistido/Assistir</label>
                          <input type="date" class="form-control" name="watched_date" value="<?= $contentDetails['watched_date']; ?>" placeholder="Assistido/Assistir" required>
                        </div>
                      </div>
                    </div>
                    <div class="row mt-1">
                      <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="form-group">
                          <label for="release_date">Data de Lançamento</label>
                          <input type="date" class="form-control" name="release_date" value="<?= $contentDetails['release_date']; ?>" placeholder="Data de Lançamento" required>
                        </div>
                      </div>
                      <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="form-group">
                          <label for="end_date">Data de Término</label>
                          <input type="date" class="form-control" name="end_date" value="<?= $contentDetails['end_date']; ?>">
                        </div>
                      </div>
                    </div>
                    <div class="row mt-1">
                      <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="form-group">
                          <label for="duration">Duração</label>
                          <input type="text" class="form-control" name="duration" value="<?= $contentDetails['duration']; ?>" placeholder="Duração" maxlength="100" size="100">
                        </div>
                      </div>
                      <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="form-group">
                          <label for="season">Nº Temporadas</label>
                          <input type="text" class="form-control" name="number_seasons" value="<?= $contentDetails['number_seasons']; ?>" placeholder="Número temporadas" maxlength="100" size="100">
                        </div>
                      </div>
                    </div>
                    <div class="row mt-1">
                      <div class="form-group">
                        <label for="season">Link Trailer</label>
                        <input type="text" class="form-control" name="trailer" value="<?= $contentDetails['trailer']; ?>" placeholder="Link" maxlength="100" size="100">
                      </div>
                    </div>
                    <div class="row mt-1">
                      <div class="form-group">
                        <label for="synopsis">Sinopse</label>
                        <div class="d-flex">
                          <textarea class="form-control me-2" name="synopsis" placeholder="Sinopse" maxlength="100" size="100"><?= $contentDetails['synopsis']; ?></textarea>
                        </div>
                      </div>
                    </div>
                    <input type="hidden" name="id" value="<?= $content['content_id']; ?>">


                    <div class="row">
                      <div class="text-right">
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                          <button type="submit" id="submit" name="content" value="update" class="btn btn-primary">Guardar</button>
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>

          <!-- delete modal -->

          <div class="modal fade" id="deleteContentModal<?= $content['content_id']; ?>" tabindex="-1" aria-labelledby="deleteContentModalLabel<?= $content['content_id']; ?>" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="deleteModalLabel<?= $content['content_id']; ?>">Eliminar lista</h5>
                </div>
                <div class="modal-body">
                  <p class="card-title">
                    Tem certeza de que deseja eliminar a lista <?= $contentDetails['title']; ?>?
                  </p>
                  <br>
                  <p>Não poderá recuperar a mesma posteriormente.</p>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                  <form action="/StreamSync/src/controllers/admin/content.php" method="get">
                    <input type="hidden" name="id" value="<?= $content['content_id']; ?>">
                    <input type="hidden" name="content" value="delete">
                    <button type="submit" class="btn btn-danger">Sim, eliminar o conteúdo</button>
                  </form>

                </div>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </section>

  </div>

</body>