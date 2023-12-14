<?php
$title = 'Lista de Conteúdo';
require_once __DIR__ . '../../../../infrastructure/middlewares/middleware-user.php';
require_once __DIR__ . '../../../../repositories/listsRepository.php';
require_once __DIR__ . '../../../../repositories/listContentRepository.php';
require_once __DIR__ . '../../../../repositories/contentRepository.php';
require_once __DIR__ . '../../../../repositories/categoryRepository.php';
require_once __DIR__ . '../../../../repositories/contentTypeRepository.php';
include_once __DIR__ . '../../../../templates/header.php';
@require_once __DIR__ . '/../../../validations/session.php';
require_once __DIR__ . '/Content.php';
$user = user();

$listId = isset($_GET['list_id']) ? $_GET['list_id'] : null;
$list = getListById($listId, $user['id']);
$listContent = getAllListContent($listId);

function getYoutubeVideoId($url)
{
  $videoId = "";
  $pattern = '/(?:youtube\.com\/(?:[^\/\ns]+\/S+\/|(?:v|e(?:mbed)?)\/|\S*?[?&]v=)|youtu\.be\/)([a-zA-Z0-9_-]{11})/';

  preg_match($pattern, $url, $matches);

  if (!empty($matches[1])) {
    $videoId = $matches[1];
  }

  return $videoId;
}
?>

<body class="bg-color">
  <div class="w-90 min-vh-100 m-auto">
    <div class="row mt-2">
      <div class="col-md-12 d-flex justify-content-between align-items-center">
        <a class="bi bi-arrow-bar-left pointer fs-3 transition title-color" href="Dashboard.php"></i></a>
        <h2 class="title-color mb-0 me-5"><?= $list['name']; ?></h2>
      </div>
      <hr class="my-2 border-primary">
    </div>

    <div class="me-5 mt-3 text-end">
      <a href="#contentModal" class="btn btn-outline-info" data-toggle="modal" data-list-id="<?= $list['id']; ?>">
        <span class="d-flex align-items-end">Inserir Conteúdo</span>
      </a>
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
          <a href="infoContent.php?content_id=<?= $content['content_id']; ?>" class="text-decoration-none">
            <article class="postcard sidebar-color h-auto mt-1">
              <div class="postcard__img_link">
                <img class="postcard__img w-100 position-relative" src="data:image/jpeg;base64,<?= base64_encode($contentDetails['poster']); ?>" alt="<?= isset($contentDetails['title']) ? $contentDetails['title'] : 'Title Not Available'; ?>" />
              </div>
              <div class="postcard__text position-relative d-flex flex-column w-100 text-left">
                <h4 class="">
                  <?= isset($contentDetails['title']) ? $contentDetails['title'] : 'Title Not Available'; ?>
                </h4>
                <div class="overflow-hidden h-100 mt-2" style="max-height: 100px;">
                  <?= isset($contentDetails['synopsis']) ? ($contentDetails['synopsis']) : 'Write a Synopsis..'; ?>
                </div>
                <ul class="d-flex p-0 flex-row flex-wrap mt-2">
                  <li class="bg-secondary d-inline-block rounded-3 ms-1 me-1 p-1">
                    <i class="fas fa-tag mr-2"></i><?= isset($typeDetails['name']) ? $typeDetails['name'] : 'Type Not Available'; ?>
                  </li>
                  <li class="bg-secondary d-inline-block rounded-3 ms-1 me-1 p-1">
                    <i class="fas fa-list mr-2"></i><?= isset($categoryDetails['name']) ? $categoryDetails['name'] : 'Category Not Available'; ?>
                  </li>
                </ul>
              </div>
            </article>
          </a>

        <?php endforeach; ?>
      </div>
    </section>

  </div>
</body>