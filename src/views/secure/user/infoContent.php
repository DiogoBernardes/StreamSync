<?php
require_once __DIR__ . '../../../../infrastructure/middlewares/middleware-user.php';
require_once __DIR__ . '../../../../repositories/contentRepository.php';
require_once __DIR__ . '../../../../repositories/categoryRepository.php';
require_once __DIR__ . '../../../../repositories/userRepository.php';
require_once __DIR__ . '../../../../repositories/contentTypeRepository.php';
require_once __DIR__ . '../../../../repositories/reviewsRepository.php';
include_once __DIR__ . '../../../../templates/header.php';
@require_once __DIR__ . '/../../../validations/session.php';
$user = user();

$contentId = isset($_GET['content_id']) ? $_GET['content_id'] : null;
$contentDetails = getContentById($contentId);
$typeDetails = getContentTypeById($contentDetails['type_id']);
$categoryDetails = getCategoryById($contentDetails['category_id']);
$title = $contentDetails['title'];

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


<body class="bg-center bg-fixed bg-cover d-flex flex-column align-items-center m-0 p-0 position-relative text-white " style="background-image: url('data:image/jpeg;base64,<?= base64_encode($contentDetails['poster']); ?>" alt="<?= isset($contentDetails['title']) ? $contentDetails['title'] : 'Title Not Available'; ?>')">
  <div class="overlay position-fixed top-0 start-0 w-100 h-100"></div>
  <div class="container">
    <div class="row mt-2 position-relative">
      <div class="col-md-12 d-flex justify-content-between align-items-center">
        <a class="bi bi-arrow-bar-left pointer fs-3 transition text-white" href="Dashboard.php"></i></a>
      </div>
      <hr class="my-2">
    </div>

    <section class="mt-5">
      <div class="row align-items-center position-relative">
        <div class="col-xl-3 col-lg-4">
          <div class="movie-details-img position-relative">
            <img class="position-relative rounded" src="data:image/jpeg;base64,<?= base64_encode($contentDetails['poster']); ?>" alt="<?= isset($contentDetails['title']) ? $contentDetails['title'] : 'Title Not Available'; ?>">
          </div>
        </div>
        <div class="col-xl-9 col-lg-8">
          <div class="movie-details-content">
            <h2><?= $contentDetails['title']; ?></h2>
            <div>
              <ul class="d-flex p-0 mb-4">
                <li class="d-flex me-5"><?= isset($categoryDetails['name']) ? $categoryDetails['name'] : 'Category Not Available'; ?></li>
                <li class="d-flex me-5">
                  <span>
                    <i class="bi bi-calendar"></i> <?= date('Y', strtotime($contentDetails['release_date'])); ?>
                  </span>
                  <span>
                    <i class="bi bi-clock ms-2"></i> <?= $contentDetails['duration']; ?> min
                  </span>
                </li>
              </ul>
            </div>
            <p><?= $contentDetails['synopsis']; ?> </p>
            <div class="d-flex align-items-center rounded mt-4 flex-wrap">
              <button type="button" class="btn btn-outline-light" data-bs-toggle="modal" data-bs-target="#trailerModal<?= $contentDetails['id']; ?>">
                <i class="bi bi-play"></i> Watch Now
              </button>
            </div>
          </div>
        </div>
      </div>

    </section>


    <section id="reviews" class="position-relative mt-5">
      <div class="container mt-5 mb-5">
        <div class="d-flex justify-content-start row px-5">
          <div class="d-flex flex-column col-md-8 w-100">
            <form enctype="multipart/form-data" method="post" action="/StreamSync/src/controllers/admin/reviews.php">
              <input type="hidden" name="user_id" value="<?= $user['id']; ?>">
              <input type="hidden" name="content_id" value="<?= $contentDetails['id']; ?>">

              <div class="d-none d-sm-flex flex-row mt-4 mb-4">
                <?php if ($user['avatar'] !== null) : ?>
                  <img class="img-fluid img-responsive rounded-circle mr-2" src="data:image/png;base64,<?= base64_encode($user['avatar']) ?>" style="width: 42px; height: 42px;">
                <?php else : ?>
                  <img src="https://static-00.iconduck.com/assets.00/avatar-default-icon-2048x2048-h6w375ur.png" alt="Default Avatar" class="rounded-circle" style="width: 42px; height: 42px;">
                <?php endif; ?>
                <textarea class="form-control mr-3 ms-2" name="comment" placeholder="Add comment" rows="1"></textarea>
                <input type="text" class="form-control mr-3 ms-2 w-12" name="rating" placeholder="0/10 Rating" pattern="[0-9]|10(\.[0-9])?" title="0/10 Rate">
                <button class="btn btn-outline-success ms-2" type="submit" name="review" value="create">Comment</button>
              </div>

              <div class="d-sm-none flex-column">
                <div class="d-flex flex-row align-items-center mb-2">
                  <?php if ($user['avatar'] !== null) : ?>
                    <img class="img-fluid img-responsive rounded-circle mr-2" src="data:image/png;base64,<?= base64_encode($user['avatar']) ?>" style="width: 42px; height: 42px;">
                  <?php else : ?>
                    <img src="https://static-00.iconduck.com/assets.00/avatar-default-icon-2048x2048-h6w375ur.png" alt="Default Avatar" class="rounded-circle" style="width: 42px; height: 42px;">
                  <?php endif; ?>
                  <textarea class="form-control mr-3 ms-2" name="comment" placeholder="Add comment" rows="1"></textarea>
                </div>
                <div class="d-flex flex-row align-items-center">
                  <input type="text" class="form-control w-50 mr-3 ms-2 mb-2 mt-1" name="rating" placeholder="0/10 Rating" pattern="[0-9]|10(\.[0-9])?" title="0/10 Rate">
                  <button class="btn btn-outline-success w-50 ms-2 mb-2" type="submit" name="review" value="create">Comment</button>
                </div>
              </div>
            </form>

            <?php
            $reviews = getReviewsForContent($contentDetails['id']);
            foreach ($reviews as $review) {
              $reviewer = getById($review['user_id']);
              $rating = $review['rating'];
              $wholeStars = floor($rating);
              $halfStar = ($rating - $wholeStars) >= 0.5;
              $loggedInUserReview = $review['user_id'] == $user['id'];
            ?>
              <div class="mt-2 border border-secondary rounded">
                <div class="d-flex flex-column ms-2 mt-2 mb-3">
                  <div class="d-flex align-items-center">
                    <?php if ($reviewer['avatar'] !== null) : ?>
                      <img class="img-fluid img-responsive rounded-circle mr-2" src="data:image/png;base64,<?= base64_encode($reviewer['avatar']) ?>" style="width: 42px; height: 42px;">
                    <?php else : ?>
                      <img src="https://static-00.iconduck.com/assets.00/avatar-default-icon-2048x2048-h6w375ur.png" alt="Default Avatar" class="rounded-circle" style="width: 42px; height: 42px;">
                    <?php endif; ?>
                    <div>
                      <h5 class="ms-2 mb-0"><?= $reviewer['first_name']; ?> <?= $reviewer['last_name']; ?></h5>
                      <p class="ms-2 mb-0 text-size-10"><?= $reviewer['email']; ?></p>
                    </div>
                    <div class="ms-auto me-3">
                      <?php
                      for ($i = 1; $i <= 10; $i++) {
                        if ($i <= $wholeStars) {
                          echo '<i class="bi bi-star-fill text-warning"></i>';
                        } elseif ($halfStar && $i == ($wholeStars + 1)) {
                          echo '<i class="bi bi-star-half text-warning"></i>';
                        } else {
                          echo '<i class="bi bi-star"></i>';
                        }
                      }
                      ?>
                    </div>
                  </div>
                </div>
                <div class="comment-text-sm ms-2 mb-2">
                  <span><?= $review['comment']; ?></span>
                </div>
                <div class="d-flex justify-content-between">
                  <div class="reply-section ms-2 mb-2 text-size-10">
                    <i class="bi bi-calendar me-1"></i><?= date('d/m/Y', strtotime($review['review_date'])); ?>
                  </div>
                  <div class="me-2">
                    <?php
                    if ($loggedInUserReview) {
                      echo '<i class="bi bi-trash pointer" data-bs-toggle="modal" data-bs-target="#deleteModal' . $review['id'] . '"></i>';
                    }
                    ?>
                  </div>
                </div>
              </div>
            <?php
            }
            ?>
          </div>
        </div>
      </div>
    </section>

  </div>

  <!-- Trailer Modal -->
  <div class="modal fade" id="trailerModal<?= $contentDetails['id']; ?>" tabindex="-1" aria-labelledby="trailerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <?php if (isset($contentDetails['trailer']) && !empty($contentDetails['trailer'])) : ?>
          <?php
          $videoLink = $contentDetails['trailer'];
          $videoId = getYoutubeVideoId($videoLink);
          $embedCode = "https://www.youtube.com/embed/$videoId";
          ?>
          <iframe width="100%" height="500px" src="<?= $embedCode; ?>" frameborder="0" allowfullscreen></iframe>
        <?php else : ?>
          <p>Trailer not available.</p>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <!-- Modal Eliminar review -->
  <?php foreach ($reviews as $review) : ?>
    <div class="modal fade" id="deleteModal<?= $review['id']; ?>" tabindex="-1" aria-labelledby="deleteModalLabel<?= $review['id']; ?>" aria-hidden="true">
      <div class="modal-dialog text-dark">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="deleteModalLabel<?= $list['id']; ?>">Eliminar Review</h5>
          </div>
          <div class="modal-body">
            <p class="card-title">
              Tem certeza de que deseja eliminar a Review?
            </p>
            <br>
            <p>Não poderá recuperar a mesma posteriormente.</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <form action="/StreamSync/src/controllers/admin/reviews.php" method="get">
              <input type="hidden" name="review_id" value="<?= $review['id'] ?>">
              <input type="hidden" name="content_id" value="<?= $review['content_id'] ?>">
              <input type="hidden" name="review" value="delete">
              <button type="submit" class="btn btn-danger">Sim, eliminar a review</button>
            </form>

          </div>
        </div>
      </div>
    </div>
  <?php endforeach; ?>
</body>

</html>