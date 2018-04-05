<?php
/* 
 * Reviews Controller
 */
// Create or access a session
session_start();

$action = filter_input(INPUT_POST, 'action');
    if ($action == NULL){
$action = filter_input(INPUT_GET, 'action');
}
// Get the database connection file
require_once '../library/connections.php';
// Get the acme model
require_once '../model/acme-model.php';
// Get the accounts model
require_once '../model/accounts-model.php';
// Get the reivews model
require_once '../model/reviews-model.php';
// Get the functions
require_once '../library/functions.php';

// Get the array of categories
$categories = getCategories();

// get the navList using the $categories array and the getNavList function
$navList = getNavList($categories);
// Check if the firstname cookie exists, get its value
if(isset($_COOKIE['firstname'])){
  $cookieFirstname = filter_input(INPUT_COOKIE, 'firstname', FILTER_SANITIZE_STRING);
}

switch ($action) {
    case 'addReview':
      //Filter and store data
        $itemReview = filter_input(INPUT_POST, 'itemReview', FILTER_SANITIZE_STRING);
        $reviewRating = filter_input(INPUT_POST, 'reviewRating',FILTER_SANITIZE_NUMBER_INT);
        $invId = filter_input(INPUT_POST, 'invId',FILTER_SANITIZE_NUMBER_INT);
        $clientId = filter_input(INPUT_POST, 'clientId',FILTER_SANITIZE_NUMBER_INT);
        
        //run check funtions and use result for empty below
        $checkedReviewRating = checkreviewRating($reviewRating);
        $invExists = checkExistingInv($invId); // bad ID will be null
        $clientExists = checkExistingClient($clientId); // bad ID will be null
        
        // Check for empty data
        if(empty($itemReview)||empty($checkedReviewRating)||empty($invExists)||empty($clientExists)){
            $_SESSION['reviewMessage'] = '<p class="red">Please complete all fields.</p>';
            include "../products/action=item&invId=$invId";
            exit;
        }
        // Send the data to the model
        $regOutcome = addReview($itemReview, $reviewRating, $invId,$clientId);
        
        // Check and report the result
        if($regOutcome === 1){
          $_SESSION['reviewMessage'] = "<p class='green'>BAM! Thank you for the review, it's displayed below.</p>";         
          header('location: ../products/?action=item&invId='.$invId);
          exit;
        } else {
          $_SESSION['reviewMessage'] = "<p class='red'>SPLAT! The product review failed. Please try again.</p>";
          header('location: ../products/?action=item&invId='.$invId);
          exit;
        }
      break;
    case 'editReview':
        //Filter and store data
        $reviewId = filter_input(INPUT_GET, 'reviewId', FILTER_VALIDATE_INT);
      
        $review = getReviewById($reviewId);
        if(count($review)<1){
          $message = 'Sorry, no review information could be found.';
        }
        $invName = $review['invName'];
        $reviewDate = date("d F, Y", strtotime($review['reviewDate']));
        $reviewText = $review['reviewText'];
        $reviewRating = $review['reviewRating'];
        include '../view/review-update.php';
        break;
    case 'updateReview':
        //Filter and store data
        $reviewText = filter_input(INPUT_POST, 'reviewText', FILTER_SANITIZE_STRING);
        $reviewRating = filter_input(INPUT_POST, 'reviewRating',FILTER_SANITIZE_NUMBER_INT);
        $reviewId = filter_input(INPUT_POST, 'reviewId', FILTER_SANITIZE_NUMBER_INT);
        $invName = filter_input(INPUT_POST, 'invName', FILTER_SANITIZE_STRING);
        $reviewDate = filter_input(INPUT_POST, 'reviewDate', FILTER_SANITIZE_STRING);
        $clientId = $_SESSION['clientData']['clientId'];//just to make sure the client actually owns this review
        
        $checkedReviewRating = checkReviewRating($reviewRating);
        // Check for missing data
        if(empty($checkedReviewRating)||empty($reviewText)||empty($reviewId)){
            $message = '<p class="red">Please complete all fields.</p>';
            include '../view/review-update.php';
            //include "../reviews/?action=editReview&reviewId=$reviewId";
            exit;
        }
        // Send the data to the model
        $updateResult = updateReview($reviewText, $reviewRating, $reviewId, $clientId);
        
        // Check and report the result
        if ($updateResult) {
          $message = "<p class='green'>Bam! The $invName review was successfully updated.</p>";
          $_SESSION['message'] = $message;
          header('location: /acme/accounts/');
          exit;
        } else {
         $message = "<p class='red'>SPLAT! Updating the $invName review failed. Please try again.</p>";
          include '../view/review-update.php';
         exit;
        } 

        break;
    case 'deleteReview':
      $reviewId = filter_input(INPUT_POST, 'reviewId', FILTER_VALIDATE_INT);
      $invName = filter_input(INPUT_POST, 'invName', FILTER_VALIDATE_INT);
      
      $deleteResult = deleteReview($reviewId);
      if ($deleteResult) {
        $message = "<p class='green'>Bam! The $invName review was successfully deleted.</p>";
        $_SESSION['message'] = $message;
        header('location: /acme/accounts/');
        exit;
      } else {
        $message = "<p class='red'>Splat! The $invName review was not deleted.</p>";
        $_SESSION['message'] = $message;
        header('location: /acme/accounts/');
        exit;
      }
              break;
    case 'confirmReviewDelete':
      $reviewId = filter_input(INPUT_GET, 'reviewId', FILTER_VALIDATE_INT);
      
      $review = getReviewById($reviewId);
      if(count($review)<1){
        $message = 'Sorry, no review information could be found.';
      }
      $invName = $review['invName'];
      $reviewDate = date("d F, Y", strtotime($review['reviewDate']));
      $reviewText = $review['reviewText'];
      $reviewRating = $review['reviewRating'];
      include '../view/review-delete.php';
      break;
    default:
    if($_SESSION['loggedin']){
        $clientList = getClientList();
        include '../view/admin.php';
      } else {
        header('Location: /acme/');
      }
}

