<?php
require_once __DIR__ . '/../infrastructure/db/connection.php';

function createCategory($category)
{
  $sqlCreate = "INSERT INTO 
    category_type (
        name
    ) 
    VALUES (
        :name
    )";

  $PDOStatement = $GLOBALS['pdo']->prepare($sqlCreate);

  return $PDOStatement->execute([
    ':name' => $category['name']
  ]);
}

function getCategoryById($id)
{
  $PDOStatement = $GLOBALS['pdo']->prepare('SELECT * FROM category_type WHERE id = ?;');
  $PDOStatement->bindValue(1, $id, PDO::PARAM_INT);
  $PDOStatement->execute();
  return $PDOStatement->fetch();
}

function getAllCategories()
{
  $PDOStatement = $GLOBALS['pdo']->query('SELECT * FROM category_type;');
  $category = [];
  while ($listOfCategories = $PDOStatement->fetch()) {
    $category[] = $listOfCategories;
  }
  return $category;
}

function updateCategory($category)
{
  $sqlUpdate = "UPDATE  
    category_type SET
        name = :name
    WHERE id = :id;";

  $PDOStatement = $GLOBALS['pdo']->prepare($sqlUpdate);

  return $PDOStatement->execute([
    ':id' => $category['id'],
    ':name' => $category['name']
  ]);
}

function deleteCategory($id)
{
  $PDOStatement = $GLOBALS['pdo']->prepare('DELETE FROM category_type WHERE id = ?;');
  $PDOStatement->bindValue(1, $id, PDO::PARAM_INT);
  return $PDOStatement->execute();
}
