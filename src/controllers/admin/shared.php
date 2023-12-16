<?php

require_once __DIR__ . '/../../repositories/shareRepository.php';
require_once __DIR__ . '/../../validations/admin/validate-share.php';
require_once __DIR__ . '/../../validations/session.php';

if (!isset($_SESSION['id'])) {
  exit('User not logged in');
}

$userId = $_SESSION['id'];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['share'])) {
    if ($_POST['share'] == 'create') {
      create_share($_POST);
    }

    if ($_POST['share'] == 'update') {
      update_share($_POST);
    }
  }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
  if (isset($_GET['share']) && $_GET['share'] === 'delete' && isset($_GET['list_id']) && isset($_GET['user_id'])) {
    $listIdToDelete = $_GET['list_id'];
    $user_id = $_GET['user_id'];

    // Chame a função de exclusão aqui
    $success = deleteShare($listIdToDelete, $user_id);

    if ($success) {
      $_SESSION['success'] = 'Lista excluída com sucesso!';
      header('location: /StreamSync/src/views/secure/user/Dashboard.php');
      exit;
    } else {
      $_SESSION['errors'] = 'Falha ao excluir a lista.';
    }
  }
}

function create_share($req)
{
  if (!isset($_SESSION['id'])) {
    exit('User not logged in');
  }

  $originUserId = $_SESSION['id'];
  $data = validateShare($req);

  if (isset($data['invalid'])) {
    $_SESSION['errors'] = $data['invalid'];
    $params = '?' . http_build_query($req);
    header('location: /StreamSync/src/views/secure/user/List.php' . $params);
    return false;
  }

  $recipientEmail = $_POST['email'];
  $data['origin_user_id'] = $originUserId;

  $success = createShare($data, $recipientEmail, $originUserId);

  if ($success) {
    $_SESSION['success'] = 'Lista compartilhada com sucesso!';
    header('location: /StreamSync/src/views/secure/user/Dashboard.php');
  }
}

function update_share($req)
{
  $data = validateShare($req);

  $success = updateShare($data);

  if ($success) {
    $_SESSION['success'] = 'List successfully updated!';
    $data['action'] = 'update';
    $params = '?' . http_build_query($data);
    header('location: /StreamSync/src/views/secure/user/Dashboard.php#Lists' . $params);
  } else {
    $_SESSION['errors'] = 'Failed to update list.';
    header('location: /StreamSync/src/views/secure/user/Dashboard.php');
  }
}

function delete_share($share_id)
{
  $loggedInUserId = $_SESSION['id'];
  $success = deleteShare($share_id, $loggedInUserId);
  return $success;
}
