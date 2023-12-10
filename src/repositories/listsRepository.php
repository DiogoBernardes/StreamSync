<?php
require_once __DIR__ . '/../infrastructure/db/connection.php';

function createList($list, $userId)
{
  $sqlCreate = "INSERT INTO 
    lists (
        name,
        user_id
    ) 
    VALUES (
        :name,
        :user_id
    )";

  $PDOStatement = $GLOBALS['pdo']->prepare($sqlCreate);

  return $PDOStatement->execute([
    ':name' => $list['name'],
    ':user_id' => $userId
  ]);
}

function getListById($id, $userId)
{
  $PDOStatement = $GLOBALS['pdo']->prepare('SELECT * FROM lists WHERE id = ? AND user_id = ?;');
  $PDOStatement->bindValue(1, $id, PDO::PARAM_INT);
  $PDOStatement->bindValue(2, $userId, PDO::PARAM_INT);
  $PDOStatement->execute();
  return $PDOStatement->fetch();
}

function getAllLists($userId)
{
  $PDOStatement = $GLOBALS['pdo']->prepare('SELECT * FROM lists WHERE user_id = ?;');
  $PDOStatement->bindValue(1, $userId, PDO::PARAM_INT);
  $PDOStatement->execute();
  $listList = [];
  while ($list = $PDOStatement->fetch()) {
    $listList[] = $list;
  }
  return $listList;
}

function updateList($list, $userId)
{
  $sqlUpdate = "UPDATE  
    lists SET
        name = :name,
        user_id = :user_id
    WHERE id = :id AND user_id = :user_id;";

  $PDOStatement = $GLOBALS['pdo']->prepare($sqlUpdate);

  return $PDOStatement->execute([
    ':id' => $list['id'],
    ':name' => $list['name'],
    ':user_id' => $userId
  ]);
}

function deleteList($id, $userId)
{
  $PDOStatement = $GLOBALS['pdo']->prepare('DELETE FROM lists WHERE id = ? AND user_id = ?;');
  $PDOStatement->bindValue(1, $id, PDO::PARAM_INT);
  $PDOStatement->bindValue(2, $userId, PDO::PARAM_INT);

  $success = $PDOStatement->execute();

  return $success;
}
