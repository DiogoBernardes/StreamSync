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
  try {
    $GLOBALS['pdo']->beginTransaction();

    $sqlUpdate = "UPDATE lists SET name = :name WHERE id = :id AND user_id = :user_id;";

    $PDOStatement = $GLOBALS['pdo']->prepare($sqlUpdate);

    $success = $PDOStatement->execute([
      ':id' => isset($list['id']) ? $list['id'] : null,
      ':name' => $list['name'],
      ':user_id' => $userId
    ]);

    if (!$success) {
      throw new Exception("Erro ao executar a consulta de atualização.");
    }

    $GLOBALS['pdo']->commit();

    return true;
  } catch (Exception $e) {
    $GLOBALS['pdo']->rollBack();
    echo "Erro: " . $e->getMessage();
    return false;
  }
}


function deleteList($id, $userId)
{
  $PDOStatement = $GLOBALS['pdo']->prepare('DELETE FROM lists WHERE id = ? AND user_id = ?;');
  $PDOStatement->bindValue(1, $id, PDO::PARAM_INT);
  $PDOStatement->bindValue(2, $userId, PDO::PARAM_INT);

  $success = $PDOStatement->execute();

  return $success;
}

function getSharedListsByUserId($userId)
{
  $sql = "SELECT l.* 
            FROM lists l
            INNER JOIN shares s ON l.id = s.list_id
            WHERE s.destination_user_id = :user_id";

  $PDOStatement = $GLOBALS['pdo']->prepare($sql);
  $PDOStatement->execute([':user_id' => $userId]);

  $lists = [];
  while ($list = $PDOStatement->fetch()) {
    $lists[] = $list;
  }

  return $lists;
}
