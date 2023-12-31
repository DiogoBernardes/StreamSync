<?php

require_once __DIR__ . '/../../repositories/reviewsRepository.php';
require_once __DIR__ . '/../../validations/admin/validate-reviews.php';
require_once __DIR__ . '/../../validations/session.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['review'])) {
    if ($_POST['review'] == 'create') {
      create_review($_POST);
    }

    if ($_POST['review'] == 'update') {
      update_review($_POST);
    }
  }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
  if (isset($_GET['review'])) {
    if ($_GET['review'] == 'delete') {
      $success = delete_review($_GET['review_id']);

      if ($success) {
        $_SESSION['success'] = 'Review deleted successfully!';
        header('location: /StreamSync/src/views/secure/user/infoContent.php?content_id=' . $_GET['content_id']);
      }
    }
  }
}

function create_review($req)
{
  $data = validateReviews($req);

  if (isset($data['invalid'])) {
    $_SESSION['errors'] = $data['invalid'];
    $params = '?' . http_build_query($req);
    header('location: /StreamSync/src/views/secure/user/infoContent.php?content_id=' . $_POST['content_id']);
    return false;
  }

  $success = createReview($data);

  if ($success) {
    $_SESSION['success'] = 'Review created successfully!';
    header('location: /StreamSync/src/views/secure/user/infoContent.php?content_id=' . $_POST['content_id']);
    return true;
  }

  $_SESSION['errors'] = 'Failed to create review.';
  header('location: /StreamSync/src/views/secure/user/infoContent.php?content_id=' . $_POST['content_id']);
  return false;
}

function update_review($req)
{
  $data = validateReviews($req);

  if (isset($data['invalid'])) {
    $_SESSION['errors'] = $data['invalid'];
    $params = '?' . http_build_query($req);
    header('location: /StreamSync/src/views/secure/user/Dashboard.php' . $params);
    return false;
  }

  $success = updateReview($data);

  if ($success) {
    $_SESSION['success'] = 'Review successfully updated!';
    header('location: /StreamSync/src/views/secure/user/Dashboard.php');
  }
}

function delete_review($id)
{
  $data = deleteReview($id);
  return $data;
}
