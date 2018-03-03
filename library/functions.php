<?php
/* 
 * created by Brad R. Allen
 */

function getNavList($categories){
  $navList = '<ul>';
  $navList .= "<li><a href='/acme/index.php' title='View the Acme Home Page'>Home</a></li>";
  foreach ($categories as $category) {
    $navList .= "<li><a href='/acme/index.php?action=".urlencode($category['categoryName'])."' title='View our $category[categoryName] product line'>$category[categoryName]</a></li>";
  }
  $navList .= '</ul>';
  return $navList;
}


function getClientList(){
  $clientList = '<ul>';
  foreach ($_SESSION['clientData'] as $key => $value) {
    $clientList .= "<li>".$key.": ". $value . "</li>";
  }
  $clientList .= '</ul>';
  return $clientList;
}

function checkEmail($clientEmail){
  $valEmail = filter_var($clientEmail, FILTER_VALIDATE_EMAIL);
  return $valEmail;
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