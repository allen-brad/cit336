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
  $pd .= "<li><a href='/acme/products/?action=item&invid=$product[invId]'>";
  $pd .= "<img src='$product[invThumbnail]' alt='Image of $product[invName] on Acme.com'>";
  $pd .= '<hr>';
  $pd .= "<h2>$product[invName]</h2>";
  $pd .= "<span>$$product[invPrice]</span>";
  $pd .= '</a></li>';
 }
 $pd .= '</ul>';
 return $pd;
}

function buildItemDisplay($item){
  $itemView = '<section id="item-image">';
  $itemView .="<h2>$item[invName]</h2>";
  $itemView .="<img src='$item[invImage]' alt='Image of $item[invName] on Acme.com'>";
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