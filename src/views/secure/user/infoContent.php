<?php
// Include necessários e outras configurações, se necessário
$title = 'Lista de Conteúdo';
require_once __DIR__ . '../../../../infrastructure/middlewares/middleware-user.php';
require_once __DIR__ . '../../../../repositories/contentRepository.php';
require_once __DIR__ . '../../../../repositories/categoryRepository.php';
require_once __DIR__ . '../../../../repositories/contentTypeRepository.php';
include_once __DIR__ . '../../../../templates/header.php';
@require_once __DIR__ . '/../../../validations/session.php';
$user = user();

$contentId = isset($_GET['content_id']) ? $_GET['content_id'] : null;

$contentDetails = getContentById($contentId);
$typeDetails = getContentTypeById($contentDetails['type_id']);
$categoryDetails = getCategoryById($contentDetails['category_id']);

// Inclua cabeçalho e estrutura HTML da página
include_once __DIR__ . '../../../../templates/header.php';
?>

<!-- Conteúdo da Página de Informações do Conteúdo -->
<div class="container">
  <!-- Exibir detalhes do conteúdo usando $contentDetails, $typeDetails, $categoryDetails, etc. -->
  <h1><?= $contentDetails['title']; ?></h1>
  <!-- ... Outras informações ... -->
</div>