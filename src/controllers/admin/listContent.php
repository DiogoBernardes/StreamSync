<?php

require_once __DIR__ . '/../../repositories/listContentRepository.php';
require_once __DIR__ . '/../../repositories/contentRepository.php';
require_once __DIR__ . '/../../validations/admin/validate-list-content.php';
require_once __DIR__ . '/../../validations/session.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['listContent'])) {
    if ($_POST['listContent'] == 'create') {
      create_listContent($_POST);
    }

    if ($_POST['listContent'] == 'update') {
      update_listContent($_POST);
    }
  }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
  if (isset($_GET['listContent'])) {
    if ($_GET['listContent'] == 'delete') {
      $listContent = getListContentById($_GET['id']);
      $success = delete_listContent($listContent['id']);

      if ($success) {
        $_SESSION['success'] = 'List content deleted successfully!';
        header('location: /StreamSync/src/views/secure/user/Dashboard.php');
      }
    }
    if ($_GET['listContent'] == 'deleteAssociation') {
      $content = getContentById($_GET['id']);
      $success = delete_contentAssociations($content['id'], $_GET['list_id']);
    }
  }
}

function create_listContent($req)
{
  $data = validateListContent($req);

  if (isset($data['invalid'])) {
    $_SESSION['errors'] = $data['invalid'];
    $params = '?' . http_build_query($req);
    header('location: /StreamSync/src/views/secure/user/ListContent.php' . $params);
    return false;
  }

  $success = createListContent($data);

  if ($success) {
    $_SESSION['success'] = 'List content created successfully!';
    header('location: /StreamSync/src/views/secure/user/Dashboard.php');
  }
}

function update_listContent($req)
{
  $data = validateListContent($req);

  if (isset($data['invalid'])) {
    $_SESSION['errors'] = $data['invalid'];
    $_SESSION['action'] = 'update';
    $params = '?' . http_build_query($req);
    header('location: /StreamSync/src/views/secure/user/Dashboard.php' . $params);
    return false;
  }

  $success = updateListContent($data);

  if ($success) {
    $_SESSION['success'] = 'List content successfully updated!';
    $data['action'] = 'update';
    $params = '?' . http_build_query($data);
    header('location: /StreamSync/src/views/secure/user/Dashboard.php' . $params);
  }
}

function delete_listContent($listContent)
{
  $data = deleteListContent($listContent['id']);
  return $data;
}

function delete_contentAssociations($contentId, $listId)
{
  $success = deleteListContentAssociations($contentId, $listId);

  if ($success) {
    $_SESSION['success'] = 'Content deleted successfully!';
    header('location: /StreamSync/src/views/secure/user/Dashboard.php?list_id=' . $listId);
  } else {
    $_SESSION['errors'] = 'Error deleting content.';
    header('location: /StreamSync/src/views/secure/user/Dashboard.php?list_id=' . $listId);
  }
}
