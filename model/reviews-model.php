<?php
/* 
 * Reviews model
 */
//check that clients first
function checkExistingClient($clientId){
  $db = acmeConnect();
  $sql = 'SELECT clientId FROM clients WHERE clientId = :clientId';
  $stmt = $db->prepare($sql);
  $stmt->bindValue(':clientId', $clientId, PDO::PARAM_INT);
  $stmt->execute();
  $matchClient = $stmt->fetch(PDO::FETCH_NUM);
  $stmt->closeCursor();
  if(empty($matchClient)){
    return null;
  } else {
    return 1;
  }
}

function checkExistingInv($invId){
  $db = acmeConnect();
  $sql = 'SELECT invId FROM inventory WHERE invId = :invId';
  $stmt = $db->prepare($sql);
  $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);
  $stmt->execute();
  $matchInv = $stmt->fetch(PDO::FETCH_NUM);
  $stmt->closeCursor();
  if(empty($matchInv)){
    return null;
  } else {
    return 1;
  }
}
//get reviews by the product ID
function getReviewsByInvId($invId){
  $db = acmeConnect();
  $sql = 'SELECT * FROM reviews WHERE invId = :invId';
  $stmt = $db->prepare($sql);
  $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);
  $stmt->execute();
  $reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $stmt->closeCursor();
  return $reviews;
}

//Insert new product into inventory table database
function addReview($itemReview, $reviewRating, $invId, $clientId){
    //create connection object
    $db = acmeConnect();
    //sql statement
    $sql = 'INSERT INTO reviews (reviewText, reviewRating, invId, clientId)
            VALUES (:itemReview, :reviewRating, :invId, :clientId)';
   //creates prepared statement
    $stmt = $db->prepare($sql);
    // swap out varialbes for actual values
    //tell database the type of data
    $stmt->bindValue(':itemReview', $itemReview, PDO::PARAM_STR);
    $stmt->bindValue(':reviewRating', $reviewRating, PDO::PARAM_INT);
    $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);
    $stmt->bindValue(':clientId', $clientId, PDO::PARAM_INT);

    //use the prepared statement to insert data
    $stmt->execute();
    //check to see if it worked
    $rowsChanged = $stmt->rowCount();
    //close connection
    $stmt->closeCursor();
    // Return the indication of success (rows changed)
    return $rowsChanged;
}

function getReviewsByClientId($clientId){
  $db = acmeConnect();
  $sql = 'SELECT reviewId, reviewDate, invName FROM reviews JOIN inventory WHERE clientId = :clientId AND reviews.invId = inventory.invId';
  $stmt = $db->prepare($sql);
  $stmt->bindValue(':clientId', $clientId, PDO::PARAM_INT);
  $stmt->execute();
  $item = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $stmt->closeCursor();
  return $item;
}

function getReviewById($reviewId){
  $db = acmeConnect();
  $sql = 'SELECT reviews.reviewId, reviews.reviewText, reviews.reviewRating, reviews.reviewDate, inventory.invName FROM reviews JOIN inventory WHERE reviewId = :reviewId AND reviews.invId = inventory.invId';
  $stmt = $db->prepare($sql);
  $stmt->bindValue(':reviewId', $reviewId, PDO::PARAM_INT);
  $stmt->execute();
  $review = $stmt->fetch(PDO::FETCH_ASSOC);
  $stmt->closeCursor();
  return $review;
}

//update Review
function updateReview($reviewText, $reviewRating, $reviewId, $clientId){
    //create connection object
    $db = acmeConnect();
    //sql statement
    $sql = 'UPDATE reviews SET reviewText = :reviewText, reviewRating = :reviewRating WHERE reviewId = :reviewId AND clientId = :clientId';
   //creates prepared statement
    $stmt = $db->prepare($sql);
    // swap out varialbes for actual values
    //tell database the type of data
    $stmt->bindValue(':reviewText', $reviewText, PDO::PARAM_STR);
    $stmt->bindValue(':reviewRating', $reviewRating, PDO::PARAM_INT);
    $stmt->bindValue(':reviewId', $reviewId, PDO::PARAM_INT);
    $stmt->bindValue(':clientId', $clientId, PDO::PARAM_INT);

    //use the prepared statement to insert data
    $stmt->execute();
    //check to see if it worked
    $rowsChanged = $stmt->rowCount();
    //close connection
    $stmt->closeCursor();
    // Return the indication of success (rows changed)
    return $rowsChanged;
}
//delete Review
function deleteReview($reviewId){
    $db = acmeConnect();
    $sql = 'DELETE FROM reviews WHERE reviewId = :reviewId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':reviewId', $reviewId, PDO::PARAM_INT);
    $stmt->execute();
    $rowsChanged = $stmt->rowCount();
    $stmt->closeCursor();
    return $rowsChanged;
}

