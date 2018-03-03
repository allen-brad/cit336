<?php
//Products Controller
// Create or access a Session
session_start();

$action = filter_input(INPUT_POST, 'action');
    if ($action == NULL){
$action = filter_input(INPUT_GET, 'action');
}
// Get the database connection file
require_once '../library/connections.php';
// Get the acme model
require_once '../model/acme-model.php';
// Get the products model
require_once '../model/products-model.php';
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
    case 'newCategory':
        include '../view/new-cat.php';
        break;
    case 'newProduct':
        include '../view/new-prod.php';
        break;
    case 'addCategory':
        //Filster and store data
        $categoryName = filter_input(INPUT_POST, 'categoryName', FILTER_SANITIZE_STRING);
        //run check funtion and use result for empty below
        $checkedCategoryName = checkCategoryName($categoryName);
        
        // Check for missing data
        if(empty($checkedCategoryName)){
        $message = '<p class="red">Please enter a category name</p>';
        include '../view/new-cat.php';
        exit; }
        
        // Send the data to the model
        $regOutcome = addCategory($categoryName);
        
        // Check and report the result
        if($regOutcome === 1){
         //$message = "<p class='green'>BAM! You created the $categoryName category</p>";
         //include '../view/prod-mgmt.php';
         header('Location: /acme/products/?action=newCategory');
         exit;
        } else {
         $message = "<p class='red'>$regOutcome SPLAT! Adding the $categoryName category failed. Please try again.</p>";
         include '../view/new-cat.php';
         exit;
        }
    case 'addProduct':
        //Filter and store data
        $invName = filter_input(INPUT_POST, 'invName', FILTER_SANITIZE_STRING);
        $invDescription = filter_input(INPUT_POST, 'invDescription', FILTER_SANITIZE_STRING);
        $invImage = filter_input(INPUT_POST, 'invImage', FILTER_SANITIZE_URL);
        $invThumbnail = filter_input(INPUT_POST, 'invThumbnail', FILTER_SANITIZE_URL);
        $invPrice = filter_input(INPUT_POST, 'invPrice', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $invStock = filter_input(INPUT_POST, 'invStock',FILTER_SANITIZE_NUMBER_INT);
        $invSize = filter_input(INPUT_POST, 'invSize',FILTER_SANITIZE_NUMBER_INT);
        $invWeight = filter_input(INPUT_POST, 'invWeight',FILTER_SANITIZE_NUMBER_INT);
        $invLocation = filter_input(INPUT_POST, 'invLocation', FILTER_SANITIZE_STRING);
        $categoryID = filter_input(INPUT_POST, 'categoryID',FILTER_SANITIZE_NUMBER_INT);
        $invVendor = filter_input(INPUT_POST, 'invVendor', FILTER_SANITIZE_STRING);
        $invStyle = filter_input(INPUT_POST, 'invStyle', FILTER_SANITIZE_STRING);
        
        //run check funtions and use result for empty below
        $checkedInvName = checkInvName($invName);
        $checkedInvImage = checkImagePath($invImage);
        $checkedInvThumbnail = checkImagePath($invThumbnail);
        $checkedInvLocation = checkInvLocation($invLocation);
        $checkedInvVendor = checkInvVendor($invVendor);
        $checkedInvStyle = checkInvVendor($invStyle);
    
        // Check for missing data
        if(empty($checkedInvName)||empty($invDescription)||empty($checkedInvImage)||empty($checkedInvThumbnail)
                ||empty($invPrice)||empty($invSize)||empty($invStock)||empty($invWeight)||empty($checkedInvLocation)
                ||empty($categoryID)||empty($checkedInvVendor)||empty($checkedInvStyle)){
            $message = '<p class="red">Please complete all fields.</p>';
            include '../view/new-prod.php';
            exit;
        }
        // Send the data to the model
        $regOutcome = addProduct($invName, $invDescription, $invImage,
        $invThumbnail, $invPrice, $invStock, $invSize, $invWeight, $invLocation,
        $categoryID, $invVendor, $invStyle);
        
        // Check and report the result
        if($regOutcome === 1){
         $message = "<p class='green'>BAM! You created the $invName product</p>";         
         include '../view/new-prod.php';
         exit;
        } else {
         $message = "<p class='red'>$regOutcome SPLAT! Adding the $invName product failed. Please try again.</p>";
         include '../view/new-prod.php';
         exit;
        }
    default:
        include '../view/prod-mgmt.php';
}