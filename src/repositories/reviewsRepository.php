<?php
require_once __DIR__ . '/../infrastructure/db/connection.php';

function createReview($review)
{
  $sqlCreate = "INSERT INTO 
        reviews (
            user_id, 
            content_id, 
            rating, 
            comment, 
            review_date
        ) 
        VALUES (
            :user_id, 
            :content_id, 
            :rating, 
            :comment, 
            :review_date
        )";

  $PDOStatement = $GLOBALS['pdo']->prepare($sqlCreate);

  return $PDOStatement->execute([
    ':user_id' => $review['user_id'],
    ':content_id' => $review['content_id'],
    ':rating' => $review['rating'],
    ':comment' => $review['comment'],
    ':review_date' => $review['review_date']
  ]);
}

function getReviewById($user_id, $content_id)
{
  $PDOStatement = $GLOBALS['pdo']->prepare('SELECT * FROM reviews WHERE user_id = ? AND content_id = ?;');
  $PDOStatement->bindValue(1, $user_id, PDO::PARAM_INT);
  $PDOStatement->bindValue(2, $content_id, PDO::PARAM_INT);
  $PDOStatement->execute();

  return $PDOStatement->fetch();
}
function getReviewsForContent($content_id)
{
  $PDOStatement = $GLOBALS['pdo']->prepare('SELECT * FROM reviews WHERE content_id = ?;');
  $PDOStatement->bindValue(1, $content_id, PDO::PARAM_INT);
  $PDOStatement->execute();

  $reviewList = [];
  while ($review = $PDOStatement->fetch()) {
    $reviewList[] = $review;
  }

  return $reviewList;
}

function getAllReviews()
{
  $PDOStatement = $GLOBALS['pdo']->query('SELECT * FROM reviews;');
  $reviewList = [];
  while ($review = $PDOStatement->fetch()) {
    $reviewList[] = $review;
  }
  return $reviewList;
}

function checkIfListIsSharedWithUser($listId, $userId)
{
  $PDOStatement = $GLOBALS['pdo']->prepare('SELECT * FROM shares WHERE list_id = :list_id AND destination_user_id = :user_id;');
  $PDOStatement->bindParam(':list_id', $listId, PDO::PARAM_INT);
  $PDOStatement->bindParam(':user_id', $userId, PDO::PARAM_INT);
  $PDOStatement->execute();

  return $PDOStatement->fetch() ? true : false;
}

function updateReview($review)
{
  $sqlUpdate = "UPDATE  
        reviews SET
            rating = :rating, 
            comment = :comment, 
            review_date = :review_date
        WHERE user_id = :user_id AND content_id = :content_id;";

  $PDOStatement = $GLOBALS['pdo']->prepare($sqlUpdate);

  return $PDOStatement->execute([
    ':user_id' => $review['user_id'],
    ':content_id' => $review['content_id'],
    ':rating' => $review['rating'],
    ':comment' => $review['comment'],
    ':review_date' => $review['review_date']
  ]);
}

function deleteReview($user_id, $content_id)
{
  $PDOStatement = $GLOBALS['pdo']->prepare('DELETE FROM reviews WHERE user_id = ? AND content_id = ?;');
  $PDOStatement->bindValue(1, $user_id, PDO::PARAM_INT);
  $PDOStatement->bindValue(2, $content_id, PDO::PARAM_INT);

  return $PDOStatement->execute();
}

function deleteReviewsByContentId($contentId)
{
  $PDOStatement = $GLOBALS['pdo']->prepare('DELETE FROM reviews WHERE content_id = ?;');
  $PDOStatement->bindValue(1, $contentId, PDO::PARAM_INT);
  $PDOStatement->execute();
}
