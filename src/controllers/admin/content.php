<?php

require_once __DIR__ . '/../../repositories/contentRepository.php';
require_once __DIR__ . '/../../repositories/reviewsRepository.php';
require_once __DIR__ . '/../../repositories/listContentRepository.php';
require_once __DIR__ . '/../../validations/admin/validate-content.php';
require_once __DIR__ . '/../../validations/session.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['content'])) {
    if ($_POST['content'] == 'create') {
      create_content($_POST, $_POST['list_id']);
    }

    if ($_POST['content'] == 'update') {
      update_content($_POST, $_POST['list_id']);
    }
  }
}


if ($_SERVER['REQUEST_METHOD'] === 'GET') {
  if (isset($_GET['content'])) {
    // if ($_GET['content'] == 'update') {
    //   $content = getContentById($_GET['id']);
    //   $content['action'] = 'update';
    //   $params = '?' . http_build_query($content);
    //   header('location: /StreamSync/src/views/secure/user/Content.php' . $params);
    // }

    if ($_GET['content'] == 'delete') {
      $content = getContentById($_GET['id']);
      $success = delete_content($content['id'], $_GET['list_id']);

      if ($success) {
        $_SESSION['success'] = 'Content deleted successfully!';
        header('location: /StreamSync/src/views/secure/user/Dashboard.php');
      }
    }
  }
}

function create_content($req, $listId)
{
  $data = validateContent($req);

  if (isset($data['invalid'])) {
    $_SESSION['errors'] = $data['invalid'];
    $params = '?' . http_build_query($req);
    header('location: /StreamSync/src/views/secure/user/Content.php' . $params);
    return false;
  }

  $success = createContent($data, $listId);

  if ($success) {
    $_SESSION['success'] = 'Content created successfully!';
    header('location: /StreamSync/src/views/secure/user/listContent.php?list_id=' . $listId);
    return true;
  }

  $_SESSION['errors'] = 'Failed to create content.';
  header('location: /StreamSync/src/views/secure/user/listContent.php?list_id=' . $listId);
  return false;
}


function update_content($req, $listId)
{
  $data = validateContent($req);

  if (isset($data['invalid'])) {
    $_SESSION['errors'] = $data['invalid'];
    $_SESSION['action'] = 'update';
    $params = '?list_id=' . $listId . '&' . http_build_query($req);
    header('location: /StreamSync/src/views/secure/user/listContent.php?list_id=' . $params);
    return false;
  }

  $success = updateContent($data);

  if ($success) {
    $_SESSION['success'] = 'Content successfully updated!';
    $data['action'] = 'update';
    $params = '?list_id=' . $listId . '&' . http_build_query($data);
    header('location: /StreamSync/src/views/secure/user/listContent.php?list_id=' . $params);
  }
}

function delete_content($contentId, $listId)
{
  deleteListContentAssociations($contentId, $listId);
  deleteReviewsByContentId($contentId);

  $success = deleteContent($contentId);

  if ($success) {
    $_SESSION['success'] = 'Content deleted successfully!';
    header('location: /StreamSync/src/views/secure/user/Dashboard.php?list_id=' . $listId);
  } else {
    $_SESSION['errors'] = 'Error deleting content.';
    header('location: /StreamSync/src/views/secure/user/Dashboard.php?list_id=' . $listId);
  }
}
