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

function getFilteredContentByCategory($listId, $categoryFilter = null)
{
  $sql = 'SELECT lc.*, c.* FROM listContent lc INNER JOIN content c ON lc.content_id = c.id WHERE lc.list_id = :list_id';

  if ($categoryFilter) {
    $sql .= ' AND c.category_id = :category_id';
  }

  $PDOStatement = $GLOBALS['pdo']->prepare($sql);
  $PDOStatement->bindValue(':list_id', $listId, PDO::PARAM_INT);

  if ($categoryFilter) {
    $PDOStatement->bindValue(':category_id', $categoryFilter, PDO::PARAM_INT);
  }

  $PDOStatement->execute();
  return $PDOStatement->fetchAll();
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

function deleteListContentAssociations($contentId, $listId)
{
  $PDOStatement = $GLOBALS['pdo']->prepare('DELETE FROM listContent WHERE content_id = ? AND list_id= ?;');
  $PDOStatement->bindValue(1, $contentId, PDO::PARAM_INT);
  $PDOStatement->bindValue(2, $listId, PDO::PARAM_INT);
  $PDOStatement->execute();
}

function addContentToSharedList($contentId, $listId)
{
  $existingContent = getListContentByContentAndListId($contentId, $listId);

  if ($existingContent) {
    return false;
  }

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
    ':list_id' => $listId,
    ':content_id' => $contentId
  ]);
}

function getListContentByContentAndListId($contentId, $listId)
{
  $PDOStatement = $GLOBALS['pdo']->prepare('SELECT * FROM listContent WHERE content_id = :content_id AND list_id = :list_id;');
  $PDOStatement->bindValue(':content_id', $contentId, PDO::PARAM_INT);
  $PDOStatement->bindValue(':list_id', $listId, PDO::PARAM_INT);
  $PDOStatement->execute();

  return $PDOStatement->fetch();
}
