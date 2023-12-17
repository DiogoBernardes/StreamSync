<?php

require_once __DIR__ . '/../../repositories/contentTypeRepository.php';
require_once __DIR__ . '/../../validations/admin/validate-contentType.php';
require_once __DIR__ . '/../../validations/session.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['contentType'])) {
    if ($_POST['contentType'] == 'create') {
      $success = createContentType($_POST);

      if ($success) {
        $_SESSION['success_message'] = 'Tipo de conteúdo adicionado com sucesso!';
      } else {
        $_SESSION['error_message'] = 'Erro ao adicionar tipo de conteúdo. Por favor, tente novamente.';
      }
    }

    if ($_POST['contentType'] == 'update') {
      update($_POST);
    }
  }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
  if (isset($_GET['contentType'])) {
    if ($_GET['contentType'] == 'delete') {
      $content = getContentTypeById($_GET['id']);
      $success = delete_ContentType($contentType['id']);

      if ($success) {
        $_SESSION['success'] = 'Content Type deleted successfully!';
        header('location: /StreamSync/src/views/secure/admin/management.php');
      }
    }
  }
}

function create_contentType($req)
{
  $data = validateContentType($req);

  if (isset($data['invalid'])) {
    $_SESSION['errors'] = $data['invalid'];
    $params = '?' . http_build_query($req);
    header('location: /StreamSync/src/views/secure/admin/management.php' . $params);
    return false;
  }

  $success = createContentType($data);

  if ($success) {
    $_SESSION['success'] = 'Content Type created successfully!';
    header('location: /StreamSync/src/views/secure/admin/management.php');
  }
}

function update_contentType($req)
{
  $data = validateContentType($req);

  if (isset($data['invalid'])) {
    $_SESSION['errors'] = $data['invalid'];
    $_SESSION['action'] = 'update';
    $params = '?' . http_build_query($req);
    header('location: /StreamSync/src/views/secure/user/Dashboard.php' . $params);
    return false;
  }

  $success = updateContentType($data);

  if ($success) {
    $_SESSION['success'] = 'Content Type successfully updated!';
    $data['action'] = 'update';
    $params = '?' . http_build_query($data);
    header('location: /StreamSync/src/views/secure/user/Dashboard.php' . $params);
  }
}
function delete_contentType($contentType)
{
  $data = deleteContentType($contentType['id']);
  return $data;
}
