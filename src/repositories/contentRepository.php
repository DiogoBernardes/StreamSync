<?php
require_once __DIR__ . '/../infrastructure/db/connection.php';
require_once 'listContentRepository.php';

function createContent($content, $listId)
{
  if (isset($_FILES['poster']) && $_FILES['poster']['error'] === UPLOAD_ERR_OK) {
    $content['poster'] = uploadPoster($_FILES['poster']);
  }

  $sqlCreate = "INSERT INTO 
    content (
        type_id, 
        title, 
        release_date, 
        end_date, 
        number_seasons,
        synopsis,
        category_id,
        poster,
        trailer,
        watched_date
    ) 
    VALUES (
        :type_id, 
        :title, 
        :release_date, 
        :end_date, 
        :number_seasons,
        :synopsis,
        :category_id,
        :poster,
        :trailer,
        :watched_date
    )";

  $PDOStatement = $GLOBALS['pdo']->prepare($sqlCreate);

  $success = $PDOStatement->execute([
    ':type_id' => $content['type_id'],
    ':title' => $content['title'],
    ':release_date' => $content['release_date'],
    ':end_date' => $content['end_date'],
    ':number_seasons' => $content['number_seasons'],
    ':synopsis' => $content['synopsis'],
    ':category_id' => $content['category_id'],
    ':poster' => $content['poster'],
    ':trailer' => $content['trailer'],
    ':watched_date' => $content['watched_date']
  ]);

  if ($success) {
    $contentId = $GLOBALS['pdo']->lastInsertId();
    createListContent(['list_id' => $listId, 'content_id' => $contentId]);

    return $success;
  }


  return $success;
}

function getContentById($id)
{
  $PDOStatement = $GLOBALS['pdo']->prepare('SELECT * FROM content WHERE id = ?;');
  $PDOStatement->bindValue(1, $id, PDO::PARAM_INT);
  $PDOStatement->execute();
  return $PDOStatement->fetch();
}

function getAllContent()
{
  $PDOStatement = $GLOBALS['pdo']->query('SELECT * FROM content;');
  $contentList = [];
  while ($content = $PDOStatement->fetch()) {
    $contentList[] = $content;
  }
  return $contentList;
}


function updateContent($content)
{
  // Verifica se um novo arquivo de imagem foi enviado
  if (isset($_FILES['poster']) && $_FILES['poster']['error'] === UPLOAD_ERR_OK) {
    $content['poster'] = uploadPoster($_FILES['poster']);
  } else {
    $existingContent = getContentById($content['id']);
    $content['poster'] = $existingContent['poster'];
  }

  $sqlUpdate = "UPDATE  
    content SET
        type_id = :type_id, 
        title = :title, 
        release_date = :release_date, 
        end_date = :end_date, 
        number_seasons = :number_seasons,
        synopsis = :synopsis,
        category_id = :category_id,
        poster = :poster,
        trailer = :trailer,
        watched_date = :watched_date
    WHERE id = :id;";

  $PDOStatement = $GLOBALS['pdo']->prepare($sqlUpdate);

  return $PDOStatement->execute([
    ':id' => $content['id'],
    ':type_id' => $content['type_id'],
    ':title' => $content['title'],
    ':release_date' => $content['release_date'],
    ':end_date' => $content['end_date'],
    ':number_seasons' => $content['number_seasons'],
    ':synopsis' => $content['synopsis'],
    ':category_id' => $content['category_id'],
    ':poster' => $content['poster'],
    ':trailer' => $content['trailer'],
    ':watched_date' => $content['watched_date']
  ]);
}



function deleteContent($id)
{
  $PDOStatement = $GLOBALS['pdo']->prepare('DELETE FROM content WHERE id = ?;');
  $PDOStatement->bindValue(1, $id, PDO::PARAM_INT);
  return $PDOStatement->execute();
}

function uploadPoster($file)
{
  $allowedImageTypes = ['jpg', 'jpeg', 'png'];
  $statusMsg = '';

  if ($file && $file['error'] === UPLOAD_ERR_OK) {
    $fileName = basename($file["name"]);
    $fileType = pathinfo($fileName, PATHINFO_EXTENSION);

    if (in_array($fileType, $allowedImageTypes)) {
      $imgContent = file_get_contents($file["tmp_name"]);

      if ($imgContent) {
        $statusMsg = 'Ficheiro carregado com sucesso';
        return $imgContent;
      } else {
        $statusMsg = 'Erro ao ler o conteúdo do ficheiro.';
      }
    } else {
      $statusMsg = 'Desculpe, apenas são suportados ficheiros JPG, JPEG, PNG.';
    }
  }
  throw new Exception($statusMsg);
}
function getWatchedDatesForCalendar($userId)
{
  $sql = "SELECT c.title, c.watched_date
          FROM content c
          JOIN listContent lc ON c.id = lc.content_id
          JOIN lists l ON lc.list_id = l.id
          WHERE l.user_id = :user_id AND c.watched_date IS NOT NULL";

  $PDOStatement = $GLOBALS['pdo']->prepare($sql);
  $PDOStatement->bindParam(':user_id', $userId, PDO::PARAM_INT);
  $PDOStatement->execute();

  $events = [];

  while ($content = $PDOStatement->fetch()) {
    $start = date('Y-m-d', strtotime($content['watched_date']));

    $events[] = [
      'title' => $content['title'],
      'start' => $start,
    ];
  }

  return $events;
}

function getContentCountByCategory()
{
  $sql = "SELECT c.category_id, COUNT(c.id) AS content_count, ct.name AS category_name
          FROM content c
          JOIN category_type ct ON c.category_id = ct.id
          GROUP BY c.category_id";

  $PDOStatement = $GLOBALS['pdo']->query($sql);

  $contentCountByCategory = [];
  while ($row = $PDOStatement->fetch()) {
    $contentCountByCategory[$row['category_name']] = $row['content_count'];
  }

  return $contentCountByCategory;
}

function getContentCountByType()
{
  $sql = "SELECT ct.name AS content_type, COUNT(c.id) AS content_count
            FROM content c
            JOIN content_type ct ON c.type_id = ct.id
            GROUP BY ct.name";

  $PDOStatement = $GLOBALS['pdo']->query($sql);

  $contentCountByType = [];
  while ($row = $PDOStatement->fetch()) {
    $contentCountByType[$row['content_type']] = $row['content_count'];
  }

  return $contentCountByType;
}

function calculateAverageContentPerDay()
{
  $sql = "SELECT AVG(content_count) AS average_content_per_day FROM (
                SELECT COUNT(*) AS content_count, DATE(created_at) AS creation_date
                FROM content
                GROUP BY DATE(created_at)
            ) AS daily_counts";
  $stmt = $GLOBALS['pdo']->query($sql);
  $result = $stmt->fetch(PDO::FETCH_ASSOC);

  return $result['average_content_per_day'];
}
