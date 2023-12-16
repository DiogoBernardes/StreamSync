<?php
require_once __DIR__ . '/../infrastructure/db/connection.php';

function createShare($share, $recipientEmail, $originUserId)
{
  $sqlCreate = "INSERT INTO shares (
            share_date,
            origin_user_id,
            destination_user_id,
            list_id
        ) 
        VALUES (
            :share_date,
            :origin_user_id,
            (SELECT id FROM users WHERE email = :recipient_email LIMIT 1),
            :list_id
        )";

  $PDOStatement = $GLOBALS['pdo']->prepare($sqlCreate);

  return $PDOStatement->execute([
    ':share_date' => $share['share_date'],
    ':origin_user_id' => $originUserId,
    ':recipient_email' => $recipientEmail,
    ':list_id' => $share['list_id']
  ]);
}


function getShareById($id)
{
  $PDOStatement = $GLOBALS['pdo']->prepare('SELECT * FROM shares WHERE id = ?;');
  $PDOStatement->bindValue(1, $id, PDO::PARAM_INT);
  $PDOStatement->execute();
  return $PDOStatement->fetch();
}

function getShareByOriginUserId($user_id)
{
  $PDOStatement = $GLOBALS['pdo']->prepare('SELECT * FROM shares WHERE origin_user_id = ?;');
  $PDOStatement->bindValue(1, $user_id, PDO::PARAM_INT);
  $PDOStatement->execute();
  return $PDOStatement->fetch();
}


function getAllShares()
{
  $PDOStatement = $GLOBALS['pdo']->prepare('SELECT * FROM shares;');
  $PDOStatement->execute();
  $shareList = [];
  while ($share = $PDOStatement->fetch()) {
    $shareList[] = $share;
  }
  return $shareList;
}

function updateShare($share)
{
  try {
    $GLOBALS['pdo']->beginTransaction();

    $sqlUpdate = "UPDATE shares SET share_date = :share_date, origin_user_id = :origin_user_id, destination_user_id = :destination_user_id WHERE id = :id;";

    $PDOStatement = $GLOBALS['pdo']->prepare($sqlUpdate);

    $success = $PDOStatement->execute([
      ':id' => isset($share['id']) ? $share['id'] : null,
      ':share_date' => $share['share_date'],
      ':origin_user_id' => $share['origin_user_id'],
      ':destination_user_id' => $share['destination_user_id']
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

function deleteShare($list_id, $user_id)
{
  try {
    error_log("List ID: " . $list_id);
    error_log("User ID: " . $user_id);

    // Verifica se há uma partilha associada à lista e ao usuário logado
    $PDOStatement = $GLOBALS['pdo']->prepare('SELECT id FROM shares WHERE list_id = ? AND destination_user_id = ?;');
    $PDOStatement->bindValue(1, $list_id, PDO::PARAM_INT);
    $PDOStatement->bindValue(2, $user_id, PDO::PARAM_INT);
    $PDOStatement->execute();

    $share_id = $PDOStatement->fetchColumn();

    // Log adicional para verificar se a entrada existe
    $exists = $share_id ? 'Existe' : 'Não existe';
    error_log("Entrada na tabela shares: " . $exists);

    if (!$share_id) {
      throw new Exception("Partilha não encontrada para a lista {$list_id} e usuário {$user_id}");
    }

    $PDOStatement = $GLOBALS['pdo']->prepare('DELETE FROM shares WHERE id = ?;');
    $PDOStatement->bindValue(1, $share_id, PDO::PARAM_INT);

    $success = $PDOStatement->execute();

    return $success;
  } catch (Exception $e) {
    error_log("Erro: " . $e->getMessage());
    return false;
  }
}

function deleteSharesByListId($listId) {
  $PDOStatement = $GLOBALS['pdo']->prepare('DELETE FROM shares WHERE list_id = ?;');
  $PDOStatement->bindValue(1, $listId, PDO::PARAM_INT);
  $PDOStatement->execute();
}

function deleteSharesByUserId($userId) {
  $sqlDeleteOrigin = "DELETE FROM shares WHERE origin_user_id = :user_id;";
  $PDOStatement = $GLOBALS['pdo']->prepare($sqlDeleteOrigin);
  $PDOStatement->bindValue(':user_id', $userId, PDO::PARAM_INT);
  $PDOStatement->execute();

  $sqlDeleteDestination = "DELETE FROM shares WHERE destination_user_id = :user_id;";
  $PDOStatement = $GLOBALS['pdo']->prepare($sqlDeleteDestination);
  $PDOStatement->bindValue(':user_id', $userId, PDO::PARAM_INT);
  $PDOStatement->execute();
}
