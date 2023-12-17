<?php

require_once __DIR__ . '/../../repositories/categoryRepository.php';
require_once __DIR__ . '/../../validations/admin/validate-category.php';
require_once __DIR__ . '/../../validations/session.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['category'])) {
    if ($_POST['category'] == 'create') {
      $success = createCategory($_POST);

      if ($success) {
        $_SESSION['success_message'] = 'Categoria adicionada com sucesso!';
      } else {
        $_SESSION['error_message'] = 'Erro ao adicionar categoria. Por favor, tente novamente.';
      }
    }

    if ($_POST['category'] == 'update') {
      update_category($_POST);
    }
  }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
  if (isset($_GET['category'])) {
    if ($_GET['category'] == 'delete') {
      $content = getCategoryById($_GET['id']);
      $success = delete_category($category['id']);

      if ($success) {
        $_SESSION['success'] = 'Category deleted successfully!';
        header('location: /StreamSync/src/views/secure/admin/management.php');
      }
    }
  }
}

function create_category($req)
{
  $data = validateCategory($req);

  if (isset($data['invalid'])) {
    $_SESSION['errors'] = $data['invalid'];
    $params = '?' . http_build_query($req);
    header('location: /StreamSync/src/views/secure/admin/management.php' . $params);
    return false;
  }

  $success = createCategory($data);

  if ($success) {
    $_SESSION['success'] = 'Category created successfully!';
    header('location: /StreamSync/src/views/secure/admin/management.php');
  }
}

function update_category($req)
{
  $data = validateCategory($req);

  if (isset($data['invalid'])) {
    $_SESSION['errors'] = $data['invalid'];
    $_SESSION['action'] = 'update';
    $params = '?' . http_build_query($req);
    header('location: /StreamSync/src/views/secure/user/Dashboard.php' . $params);
    return false;
  }

  $success = updateCategory($data);

  if ($success) {
    $_SESSION['success'] = 'Category successfully updated!';
    $data['action'] = 'update';
    $params = '?' . http_build_query($data);
    header('location: /StreamSync/src/views/secure/user/Dashboard.php' . $params);
  }
}
function delete_category($category)
{
  $data = deleteCategory($category['id']);
  return $data;
}
