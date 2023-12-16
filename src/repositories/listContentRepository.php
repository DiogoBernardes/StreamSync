<?php
require_once __DIR__ . '/../infrastructure/db/connection.php';

function createListContent($listContent)
{
  $sqlCreate = "INSERT INTO 
    listContent (
        list_id, 
        content_id
    ) 
    VALUES (
        :list_id, 
        :content_id
    )";

  $PDOStatement = $GLOBALS['pdo']->prepare($sqlCreate);

  return $PDOStatement->execute([
    ':list_id' => $listContent['list_id'],
    ':content_id' => $listContent['content_id']
  ]);
}

function getListContentById($id)
{
  $PDOStatement = $GLOBALS['pdo']->prepare('SELECT * FROM listContent WHERE id = ?;');
  $PDOStatement->bindValue(1, $id, PDO::PARAM_INT);
  $PDOStatement->execute();
  return $PDOStatement->fetch();
}

function getAllListContent($listId = null)
{
  $sql = 'SELECT * FROM listContent';

  if ($listId !== null) {
    $sql .= ' WHERE list_id = :list_id';
  }

  $PDOStatement = $GLOBALS['pdo']->prepare($sql);

  if ($listId !== null) {
    $PDOStatement->bindValue(':list_id', $listId, PDO::PARAM_INT);
  }

  $PDOStatement->execute();
  $listContentList = [];

  while ($listContent = $PDOStatement->fetch()) {
    $listContentList[] = $listContent;
  }

  return $listContentList;
}


function updateListContent($listContent)
{
  $sqlUpdate = "UPDATE  
    listContent SET
        list_id = :list_id, 
        content_id = :content_id
    WHERE id = :id;";

  $PDOStatement = $GLOBALS['pdo']->prepare($sqlUpdate);

  return $PDOStatement->execute([
    ':id' => $listContent['id'],
    ':list_id' => $listContent['list_id'],
    ':content_id' => $listContent['content_id']
  ]);
}

function deleteListContent($id)
{
  $PDOStatement = $GLOBALS['pdo']->prepare('DELETE FROM listContent WHERE id = ?;');
  $PDOStatement->bindValue(1, $id, PDO::PARAM_INT);
  return $PDOStatement->execute();
}

function deleteListContentAssociations($contentId)
{
  $PDOStatement = $GLOBALS['pdo']->prepare('DELETE FROM listContent WHERE content_id = ?;');
  $PDOStatement->bindValue(1, $contentId, PDO::PARAM_INT);
  $PDOStatement->execute();
}
