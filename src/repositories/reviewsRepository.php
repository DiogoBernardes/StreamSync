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

function getReviewById($id)
{
  $PDOStatement = $GLOBALS['pdo']->prepare('SELECT * FROM reviews WHERE id = ?;');
  $PDOStatement->bindValue(1, $id, PDO::PARAM_INT);
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

function deleteReview($id)
{
  $PDOStatement = $GLOBALS['pdo']->prepare('DELETE FROM reviews WHERE id = ?;');
  $PDOStatement->bindValue(1, $id, PDO::PARAM_INT);
  return $PDOStatement->execute();
}

function deleteReviewsByUserId($userId)
{
  $PDOStatement = $GLOBALS['pdo']->prepare('DELETE FROM reviews WHERE user_id = ?;');
  $PDOStatement->bindValue(1, $userId, PDO::PARAM_INT);

  return $PDOStatement->execute();
}
function deleteReviewsByContentId($contentId)
{
  $PDOStatement = $GLOBALS['pdo']->prepare('DELETE FROM reviews WHERE content_id = ?;');
  $PDOStatement->bindValue(1, $contentId, PDO::PARAM_INT);
  $PDOStatement->execute();
}


function getRatingStatistics()
{
  $PDOStatement = $GLOBALS['pdo']->query('SELECT rating, COUNT(*) as count FROM reviews GROUP BY rating;');
  $ratingStatistics = [];
  while ($row = $PDOStatement->fetch()) {
    $ratingStatistics[$row['rating']] = $row['count'];
  }
  return $ratingStatistics;
}

function calculateAverageReviewsPerDay()
{
  try {
    $sql = "SELECT COUNT(content_id) / COUNT(DISTINCT DATE(review_date)) AS avg_reviews_per_day FROM reviews;";
    $PDOStatement = $GLOBALS['pdo']->query($sql);
    $result = $PDOStatement->fetch(PDO::FETCH_ASSOC);

    return $result['avg_reviews_per_day'];
  } catch (Exception $e) {
    error_log("Erro na função calculateAverageReviewsPerDay: " . $e->getMessage());
    return false;
  }
}
