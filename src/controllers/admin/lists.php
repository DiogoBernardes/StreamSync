<?php

require_once __DIR__ . '/../../repositories/listsRepository.php';
require_once __DIR__ . '/../../validations/admin/validate-list.php';
require_once __DIR__ . '/../../validations/session.php';
require_once __DIR__ . '/../../repositories/listContentRepository.php';
require_once __DIR__ . '/../../repositories/shareRepository.php';
require_once __DIR__ . '/../../repositories/reviewsRepository.php';
require_once __DIR__ . '/../../repositories/contentRepository.php';

if (!isset($_SESSION['id'])) {
  exit('User not logged in');
}

$userId = $_SESSION['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['list'])) {
  $action = $_POST['list'];

  switch ($action) {
    case 'create':
      create_list($_POST, $userId);
      break;

    case 'update':
      update_list($_POST, $userId);
      break;
  }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['list'])) {
  $action = $_GET['list'];

  if ($action == 'delete') {
    delete_list($_GET['list_id'], $userId);
  }
}

function create_list($req, $userId)
{
  $data = validateList($req);

  if (isset($data['invalid'])) {
    $_SESSION['errors'] = $data['invalid'];
    $params = '?' . http_build_query($req);
    header('location: /StreamSync/src/views/secure/user/List.php' . $params);
    return false;
  }

  $success = createList($data, $userId);

  if ($success) {
    $_SESSION['success'] = 'List created successfully!';
    header('location: /StreamSync/src/views/secure/user/Dashboard.php');
  }
}

function update_list($req, $userId)
{
  $data = validateList($req);

  $success = updateList($data, $userId);

  if ($success) {
    $_SESSION['success'] = 'List successfully updated!';
    $data['action'] = 'update';
    $params = '?' . http_build_query($data);
    header('location: /StreamSync/src/views/secure/user/Dashboard.php#Lists');
  } else {
    $_SESSION['errors'] = 'Failed to update list.';
    header('location: /StreamSync/src/views/secure/user/Dashboard.php');
  }
}



function delete_list($listId, $userId)
{
  $list = getListById($listId, $userId);

  if ($list) {
    deleteSharesByListId($listId);

    $listContents = getAllListContent($listId);
    foreach ($listContents as $listContent) {
      deleteListContent($listContent['id']);

      deleteReviewsByContentId($listContent['content_id']);

      deleteContent($listContent['content_id']);
    }

    $success = deleteList($listId, $userId);

    if ($success) {
      $_SESSION['success'] = 'List deleted successfully!';
      header('location: /StreamSync/src/views/secure/user/Dashboard.php');
    } else {
      $_SESSION['errors'] = 'Error deleting list.';
      header('location: /StreamSync/src/views/secure/user/Dashboard.php');
    }
  } else {
    $_SESSION['errors'] = 'List not found';
    header('location: /StreamSync/src/views/secure/user/Dashboard.php');
  }
}
