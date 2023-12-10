<?php
require_once __DIR__ . '/../infrastructure/db/connection.php';

function createContentType($contentType)
{
  $sqlCreate = "INSERT INTO 
    content_type (
        name
    ) 
    VALUES (
        :name
    )";

  $PDOStatement = $GLOBALS['pdo']->prepare($sqlCreate);

  return $PDOStatement->execute([
    ':name' => $contentType['name']
  ]);
}

function getContentTypeById($id)
{
  $PDOStatement = $GLOBALS['pdo']->prepare('SELECT * FROM content_type WHERE id = ?;');
  $PDOStatement->bindValue(1, $id, PDO::PARAM_INT);
  $PDOStatement->execute();
  return $PDOStatement->fetch();
}

function getAllContentTypes()
{
  $PDOStatement = $GLOBALS['pdo']->query('SELECT * FROM content_type;');
  $contentType = [];
  while ($listOfContentTypes = $PDOStatement->fetch()) {
    $contentType[] = $listOfContentTypes;
  }
  return $contentType;
}

function updateContentType($contentType)
{
  $sqlUpdate = "UPDATE  
    content_type SET
        name = :name
    WHERE id = :id;";

  $PDOStatement = $GLOBALS['pdo']->prepare($sqlUpdate);

  return $PDOStatement->execute([
    ':id' => $contentType['id'],
    ':name' => $contentType['name']
  ]);
}

function deleteContentType($id)
{
  $PDOStatement = $GLOBALS['pdo']->prepare('DELETE FROM content_type WHERE id = ?;');
  $PDOStatement->bindValue(1, $id, PDO::PARAM_INT);
  return $PDOStatement->execute();
}
