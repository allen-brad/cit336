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
    case 'category':
      $type = filter_input(INPUT_GET, 'type', FILTER_SANITIZE_STRING);
      $products = getProductsByCategory($type);
      if(!count($products)){
        $message = "<p class='red'>Sorry, no $type products could be found.</p>";
      } else {
         $prodDisplay = buildProductsDisplay($products);
      }
      include '../view/category.php';
      break;
      
    case 'item':
      $invId = filter_input(INPUT_GET, 'invid', FILTER_SANITIZE_NUMBER_INT);
      $item = getItemById($invId);
      if(!count($item)){
        $message = "<p class='red'>Sorry, product $invId could not be found.</p>";
      } else {
         $itemDisplay = buildItemDisplay($item);
      }
      
      include '../view/item.php';
    break;
    
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
        
    case 'mod':
        $invId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        $prodInfo = getProductInfo($invId);
        if(count($prodInfo)<1){
          $message = 'Sorry, no product information could be found.';
        }
        include '../view/prod-update.php';
        exit;
        break;
        
    case 'del':
        $invId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        $prodInfo = getProductInfo($invId);
        if(count($prodInfo)<1){
          $message = 'Sorry, no product information could be found.';
        }
        include '../view/prod-delete.php';
        exit;
        break;
        
    case 'deleteProd':
        $invName = filter_input(INPUT_POST, 'invName', FILTER_SANITIZE_STRING);
        $invId = filter_input(INPUT_POST, 'invId', FILTER_SANITIZE_NUMBER_INT);
        
        $deleteResult = deleteProduct($invId);
        if ($deleteResult) {
          $message = "<p class='green'>Bam! $invName was successfully deleted.</p>";
          $_SESSION['message'] = $message;
          header('location: /acme/products/');
          exit;
        } else {
          $message = "<p class='red'>Error: $invName was not deleted.</p>";
          $_SESSION['message'] = $message;
          header('location: /acme/products/');
          exit;
        }
        break;
        
    case 'updateProd':
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
        $invId = filter_input(INPUT_POST, 'invId', FILTER_SANITIZE_NUMBER_INT);

        
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
            include '../view/prod-update.php';
            exit;
        }
        // Send the data to the model
        $updateResult = updateProduct($invName, $invDescription, $invImage,
        $invThumbnail, $invPrice, $invStock, $invSize, $invWeight, $invLocation,
        $categoryID, $invVendor, $invStyle, $invId);
        
        // Check and report the result
        if ($updateResult) {
          $message = "<p class='green'>Congratulations, $invName was successfully updated.</p>";
          $_SESSION['message'] = $message;
          header('location: /acme/products/');
          exit;
        } else {
         $message = "<p class='red'>$updateResult SPLAT! Updating the $invName product failed. Please try again.</p>";
         include '../view/prod-update.php';
         exit;
        } 
        
    default:
      $products = getProductBasics();
      if(count($products)>0){
          $prodList = '<table>';
          $prodList .= '<thead>';
          $prodList .= '<tr><th>Product Name</th><td>&nbsp;</td><td>&nbsp;</td></tr>';
          $prodList .= '</thead>';
          $prodList .= '<tbody>';
          foreach ($products as $product) {
            $prodList .= "<tr><td>$product[invName]</td>";
            $prodList .= "<td><a href='/acme/products?action=mod&id=$product[invId]' title='Click to modify'>Modify</a></td>";
            $prodList .= "<td><a href='/acme/products?action=del&id=$product[invId]' title='Click to delete'>Delete</a></td></tr>";
          }
          $prodList .= '</tbody></table>';
          } else {
          $message = '<p class="notify">Sorry, no products were returned.</p>';
          }  
      include '../view/prod-mgmt.php';
}