<?php
/* 
 * created by Brad R. Allen
 */

function getNavList($categories){
  $navList = '<ul>';
  $navList .= "<li><a href='/acme/' title='View the Acme Home Page' >Home</a></li>";
  foreach ($categories as $category) {
    $navList .= "<li><a href='/acme/products/?action=category&type=$category[categoryName]' title='View our $category[categoryName] product line'>$category[categoryName]</a></li>";
  }
  $navList .= '</ul>';
  return $navList;
}

function checkEmail($clientEmail){
  $valEmail = filter_var($clientEmail, FILTER_VALIDATE_EMAIL);
  return $valEmail;
}
//build a display of products within an unordered list
function buildProductsDisplay($products){
 $pd = '<ul id="prod-display">';
 foreach ($products as $product) {
  $pd .= "<li><a href='/acme/products/?action=item&invId=$product[invId]'>";
  $pd .= "<img src='$product[invThumbnail]' alt='Image of $product[invName] on Acme.com'>";
  $pd .= '<hr>';
  $pd .= "<h2>$product[invName]</h2>";
  $pd .= "<span>$$product[invPrice]</span>";
  $pd .= '</a></li>';
 }
 $pd .= '</ul>';
 return $pd;
}
function averageStarRating($reviews){
  If(isset($reviews)){
    $totalStars = 0;
    foreach ($reviews as $review) {
      $totalStars += $review['reviewRating'];
    }
    if(count($reviews)==0){
      return null;
    }
    $averageStars = $totalStars/count($reviews);
    $whole = floor($averageStars);
    $fraction = $averageStars - $whole;
    $starRating = "";
    $half = FALSE;
    for($i=0;$i<5; $i++ ){
      if($i<=$averageStars-1){
        $starRating .= '<span class="star-icon full">☆</span>';
      } else {
        if($fraction >=.5 & $half ==FALSE){
          $starRating .= '<span class="star-icon half">☆</span>';
          $half = TRUE;
        } else {
          $starRating .= '<span class="star-icon">☆</span>';
        }
      }
    }
  return $starRating;
  }
}
function buildItemDisplay($item,$reviews){
  $starRating = averageStarRating($reviews);
  $itemView = '<section id="item-image-section">';
  $itemView .="<h2>$item[invName] &nbsp; <a id='item-reivew' href='#reviews'>$starRating See All Reviews</a></h2>";
  $itemView .='<figure id="item-image">';
  $itemView .="<img src='$item[invImage]' alt='Image of $item[invName] on Acme.com'>";
  $itemView .="</figure>";
  $itemView .="</section>";
  $itemView .= '<section id="item-desc">';
  $itemView .="<p>$item[invDescription]</p>";
  $itemView .="<ul>";  
  $itemView .="<li>A $item[invVendor] product</li>";
  $itemView .="<li>Primary Material: $item[invStyle]</li>";
  $itemView .="<li>Product Weight: $item[invWeight]</li>";
  $itemView .="<li>Shipping Size: $item[invSize](w x l x h)</li>";
  $itemView .="<li>Ships from: $item[invLocation]</li>";
  $itemView .="<li>Number in stock: $item[invStock]</li>";
  $itemView .="</ul>";  
  $itemView .="<h3 id='item-price' class='red'>$$item[invPrice]</h3>";
  $itemView .="</section>";

  return $itemView;        
}
function buildThumbsDisplay($thumbs){
  $tn = '<hr><ul id="thumbnail-display">';
  foreach ($thumbs as $thumb) {
    $tn .= "<li><img src='$thumb[imgPath]' alt='Image of $thumb[imgName] on Acme.com'></li>";
  }
  $tn .= '</ul>';
  return $tn;
}

function buildReviewListById($reviews){
  $screenName = substr($_SESSION['clientData']['clientFirstname'], 0,1).$_SESSION['clientData']['clientLastname'];//temporary cheat
  $reviewList = '<div id="reviews">';
  foreach ($reviews as $review) {
    $reviewList .= '<section class="review">';
    $reviewList .= "<h4>$screenName gave this $review[reviewRating] stars on ". date ("d F, Y", strtotime($review['reviewDate'])).":</h4>";
    $reviewList .= "<p>$review[reviewText]</p>";
    $reviewList .= '</section>';
  }
  $reviewList .= '</div>';
  return $reviewList;
}
function buildReviewListByClientId($reviews){
  if(empty($reviews)){
    $reviewList = null;
  }else{
    $reviewList = '<section id="clientReviews">';
    $reviewList .= '<h3>Manage Your Reviews</h3>';
    $reviewList .= '<ul>';
      foreach ($reviews as $review) {
        $reviewList .= "<li>$review[invName] (Reviewed on: " .date ("d F, Y", strtotime($review['reviewDate'])).") ";
        $reviewList .= "<a href='/acme/reviews/?action=editReview&reviewId=$review[reviewId]' title='Click to modify'> Edit |</a>";
        $reviewList .= "<a href='/acme/reviews/?action=confirmReviewDelete&reviewId=$review[reviewId]' title='Click to delete'> Delete</a>";
        $reviewList .= "</li>";
      }
    $reviewList .= "</ul>";
    $reviewList .= '</section>';
    return $reviewList;
  }
}

// Check the password for a minimum of 8 characters,
// at least one 1 capital letter, at least 1 number and
// at least 1 special character
function checkPassword($clientPassword){
  $pattern = '/^(?=.*[[:digit:]])(?=.*[[:punct:]])[[:print:]]{8,}$/';
  return preg_match($pattern, $clientPassword);
}
function checkCategoryName($categoryName){
  $pattern = '([a-zA-Z]{3,30})';
  return preg_match($pattern, $categoryName);
}
function checkInvName($invName){
  $pattern = '([a-zA-Z]{3,50})';
  return preg_match($pattern, $invName);
}
function checkImagePath($imgPath){
  $pattern = '([a-zA-Z]{3,50})';
  return preg_match($pattern, $imgPath);
}
function checkInvLocation($invLocation){
  $pattern = '([a-zA-Z0-9 .,]{3,35})';
  return preg_match($pattern, $invLocation);
}
function checkInvVendor($invVendor){
  $pattern = '([a-zA-Z0-9 .,]{3,35})';
  return preg_match($pattern, $invVendor);
}
function checkInvStyle($invStyle){
  $pattern = '([a-zA-Z0-9 .,]{3,35})';
  return preg_match($pattern, $invStyle);
}
function checkReviewRating($reviewRating){
  $pattern = '([1-5])';
  return preg_match($pattern, $reviewRating);
}

/* * ********************************
* Functions for working with images
* ********************************* */
// Adds "-tn" designation to file name
function makeThumbnailName($image) {
 $i = strrpos($image, '.');
 $image_name = substr($image, 0, $i);
 $ext = substr($image, $i);
 $image = $image_name . '-tn' . $ext;
 return $image;
}

// Build images display for image management view
function buildImageDisplay($imageArray) {
 $id = '<ul id="image-display">';
 foreach ($imageArray as $image) {
  $id .= '<li>';
  $id .= "<img src='$image[imgPath]' title='$image[invName] image on Acme.com' alt='$image[invName] image on Acme.com'>";
  $id .= "<p><a href='/acme/uploads?action=delete&imgId=$image[imgId]&filename=$image[imgName]' title='Delete the image'>Delete $image[imgName]</a></p>";
  $id .= '</li>';
 }
 $id .= '</ul>';
 return $id;
}

// Build the products select list
function buildProductsSelect($products) {
 $prodList = '<select name="invId" id="invId">';
 $prodList .= "<option>Choose a Product</option>";
 foreach ($products as $product) {
  $prodList .= "<option value='$product[invId]'>$product[invName]</option>";
 }
 $prodList .= '</select>';
 return $prodList;
}

// Handles the file upload process and returns the path
// The file path is stored into the database
function uploadFile($name) {
 // Gets the paths, full and local directory
 global $image_dir, $image_dir_path;
 if (isset($_FILES[$name])) {
  // Gets the actual file name
  $filename = $_FILES[$name]['name'];
  if (empty($filename)) {
   return;
  }
 // Get the file from the temp folder on the server
 $source = $_FILES[$name]['tmp_name'];
 // Sets the new path - images folder in this directory
 $target = $image_dir_path . '/' . $filename;
 // Moves the file to the target folder
 move_uploaded_file($source, $target);
 // Send file for further processing
 processImage($image_dir_path, $filename);
 // Sets the path for the image for Database storage
 $filepath = $image_dir . '/' . $filename;
 // Returns the path where the file is stored
 return $filepath;
 }
}

// Processes images by getting paths and 
// creating smaller versions of the image
function processImage($dir, $filename) {
 // Set up the variables
 $dir = $dir . '/';

 // Set up the image path
 $image_path = $dir . $filename;

 // Set up the thumbnail image path
 $image_path_tn = $dir.makeThumbnailName($filename);

 // Create a thumbnail image that's a maximum of 200 pixels square
 resizeImage($image_path, $image_path_tn, 200, 200);

 // Resize original to a maximum of 500 pixels square
 resizeImage($image_path, $image_path, 500, 500);
}

// Checks and Resizes image
function resizeImage($old_image_path, $new_image_path, $max_width, $max_height) {

 // Get image type
 $image_info = getimagesize($old_image_path);
 $image_type = $image_info[2];

 // Set up the function names
 switch ($image_type) {
 case IMAGETYPE_JPEG:
  $image_from_file = 'imagecreatefromjpeg';
  $image_to_file = 'imagejpeg';
 break;
 case IMAGETYPE_GIF:
  $image_from_file = 'imagecreatefromgif';
  $image_to_file = 'imagegif';
 break;
 case IMAGETYPE_PNG:
  $image_from_file = 'imagecreatefrompng';
  $image_to_file = 'imagepng';
 break;
 default:
  return;
 }

 // Get the old image and its height and width
 $old_image = $image_from_file($old_image_path);
 $old_width = imagesx($old_image);
 $old_height = imagesy($old_image);

 // Calculate height and width ratios
 $width_ratio = $old_width / $max_width;
 $height_ratio = $old_height / $max_height;

 // If image is larger than specified ratio, create the new image
 if ($width_ratio > 1 || $height_ratio > 1) {

  // Calculate height and width for the new image
  $ratio = max($width_ratio, $height_ratio);
  $new_height = round($old_height / $ratio);
  $new_width = round($old_width / $ratio);

  // Create the new image
  $new_image = imagecreatetruecolor($new_width, $new_height);

  // Set transparency according to image type
  if ($image_type == IMAGETYPE_GIF) {
   $alpha = imagecolorallocatealpha($new_image, 0, 0, 0, 127);
   imagecolortransparent($new_image, $alpha);
  }

  if ($image_type == IMAGETYPE_PNG || $image_type == IMAGETYPE_GIF) {
   imagealphablending($new_image, false);
   imagesavealpha($new_image, true);
  }

  // Copy old image to new image - this resizes the image
  $new_x = 0;
  $new_y = 0;
  $old_x = 0;
  $old_y = 0;
  imagecopyresampled($new_image, $old_image, $new_x, $new_y, $old_x, $old_y, $new_width, $new_height, $old_width, $old_height);

  // Write the new image to a new file
  $image_to_file($new_image, $new_image_path);
  // Free any memory associated with the new image
  imagedestroy($new_image);
  } else {
  // Write the old image to a new file
  $image_to_file($old_image, $new_image_path);
  }
  // Free any memory associated with the old image
  imagedestroy($old_image);
}