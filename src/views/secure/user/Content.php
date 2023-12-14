<?php
$title = 'Inserir';
require_once '../../../repositories/contentTypeRepository.php';
require_once '../../../repositories/categoryRepository.php';
require_once '../../../controllers/admin/content.php';
require_once __DIR__ . '../../../../infrastructure/middlewares/middleware-user.php';
include_once __DIR__ . '../../../../templates/header.php';
@require_once __DIR__ . '/../../../validations/session.php';
$user = user();
$contentTypes = getAllContentTypes();
$categories = getAllCategories();
$listId = isset($_GET['list_id']) ? $_GET['list_id'] : null;

?>

<!-- Modal -->
<div class="modal fade" id="contentModal" tabindex="-1" role="dialog" aria-labelledby="contentModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title text-primary" id="contentModalLabel">Inserir Conteúdo</h3>
      </div>
      <div class="modal-body">
        <form enctype="multipart/form-data" action="/StreamSync/src/controllers/admin/content.php" method="post" class="form-control py-3 border-0">
          <div class="d-flex justify-content-center align-items-center">
            <div class="w-35 h-35">
              <div class="d-flex justify-content-center">
                <img src="https://pixsector.com/cache/517d8be6/av5c8336583e291842624.png" alt="Default content" class="rounded-circle w-50 h-50">
              </div>
              <div class="card-body media align-items-center">
                <div class="media-body">
                  <label class="btn btn-outline-primary d-flex justify-content-center file-label">
                    <span id="selectedFileName">
                      <?php if (isset($_FILES['poster']) && $_FILES['poster']['name'] !== '') : ?>
                        <?= $_FILES['poster']['name'] ?>
                      <?php else : ?>
                        Carregue a sua fotografia
                      <?php endif; ?>
                    </span>
                    <input id="inputGroupFile01" accept="image/*" type="file" class="form-control position-absolute invisible" name="poster" onchange="updateFileName(this)" />
                  </label>
                  <label class="text-muted small d-flex justify-content-center">Allowed JPG, PNG</label>
                </div>
              </div>
            </div>
          </div>
          <div class="row mt-2">
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
              <div class="form-group">
                <label for="title">Titulo</label>
                <input type="text" class="form-control" name="title" placeholder="Título" maxlength="100" size="100" required>
              </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
              <label for="content-type">Tipo de Conteúdo</label>
              <select class="form-select" aria-label="Default select example" name="type_id" required>
                <?php
                foreach ($contentTypes as $contentType) {
                  echo "<option value='{$contentType['id']}'>{$contentType['name']}</option>";
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
                  echo "<option value='{$category['id']}'>{$category['name']}</option>";
                }
                ?>
              </select>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
              <div class="form-group">
                <label for="watched_date">Assistido/Assistir</label>
                <input type="date" class="form-control" name="watched_date" placeholder="Assistido/Assistir" required>
              </div>
            </div>
          </div>
          <div class="row mt-1">
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
              <div class="form-group">
                <label for="release_date">Data de Lançamento</label>
                <input type="date" class="form-control" name="release_date" placeholder="Data de Lançamento" required>
              </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
              <div class="form-group">
                <label for="end_date">Data de Término</label>
                <input type="date" class="form-control" name="end_date">
              </div>
            </div>
          </div>
          <div class="row mt-1">
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
              <div class="form-group">
                <label for="duration">Duração</label>
                <input type="text" class="form-control" name="duration" placeholder="Duração" maxlength="100" size="100">
              </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
              <div class="form-group">
                <label for="season">Nº Temporadas</label>
                <input type="text" class="form-control" name="number_seasons" placeholder="Número temporadas" maxlength="100" size="100">
              </div>
            </div>
          </div>
          <div class="row mt-1">
            <div class="form-group">
              <label for="season">Link Trailer</label>
              <input type="text" class="form-control" name="trailer" placeholder="Link" maxlength="100" size="100">
            </div>
          </div>
          <div class="row mt-1">
            <div class="form-group">
              <label for="synopsis">Sinopse</label>
              <textarea type="text" class="form-control" name="synopsis"></textarea>
            </div>
          </div>
          <input type="hidden" name="list_id" value="<?= $listId; ?>">

          <div class="row">
            <div class="text-right">
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <button type="submit" id="submit" name="content" value="create" class="btn btn-primary">Guardar</button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>