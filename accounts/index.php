<?php
//Accounts Controller
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
// Get the accounts model
require_once '../model/accounts-model.php';
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
    case 'loginView':
        include '../view/login.php';
        break;
    case 'login':
        //Filter and store data
        $clientEmail = filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL);
        $clientEmail = checkEmail($clientEmail);
        $clientPassword = filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_STRING);
        $checkPassword = checkPassword($clientPassword);
        
        // Check for missing data
        if(empty($clientEmail) || empty($checkPassword)){
        $message = '<p class="red">Please provide information for all empty form fields.</p>';
        include '../view/login.php';
        exit;        
        }
        // A valid password exists, proceed with the login process
        // Query the client data based on the email address
        $clientData = getClient($clientEmail);
        
        // Compare the password just submitted against the hashed password for the matching client
          $hashCheck = password_verify($clientPassword, $clientData['clientPassword']);
        
        // If the hashes don't match create an error and return to the login view
        if (!$hashCheck) {
          $message = '<p class="notice">Please check your password and try again.</p>';
          include '../view/login.php';
          exit;
        }
        // A valid user exists, log them in
        $_SESSION['loggedin'] = TRUE;
        // Remove the password from the array the array_pop function removes the last element from an array
        array_pop($clientData);
        // Store the array into the session
        $_SESSION['clientData'] = $clientData;
        
        $clientList = getClientList();
        // Send them to the admin view
        include '../view/admin.php';
        exit;
      case 'logout';
        $_SESSION = array ();//empty out the global session
        session_destroy();
        header('Location: /acme/');
        break;  
      case 'createAccount':
        include '../view/register.php';
        break;
    case 'register':
        //Filter and store data
        $clientFirstname = filter_input(INPUT_POST, 'clientFirstname', FILTER_SANITIZE_STRING);
        $clientLastname = filter_input(INPUT_POST, 'clientLastname', FILTER_SANITIZE_STRING);
        $clientEmail = filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL);
        $clientPassword = filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_STRING);
        
        $clientEmail = checkEmail($clientEmail);
        
        $emailExists = checkExistingEmail($clientEmail);
        if ($emailExists){
            $message = '<p class="notice">That email address already exists. Do you want to login instead?</p>';
            include '../view/login.php';
            exit;
        }
        
        $checkPassword = checkPassword($clientPassword);
        // Check for missing data
        if(empty($clientFirstname) || empty($clientLastname) || empty($clientEmail) || empty($checkPassword)){
        $message = '<p class="red">Please provide information for all empty form fields.</p>';
        include '../view/register.php';
        exit; }
        
        // Hash the checked password
        $hashedPassword = password_hash($clientPassword, PASSWORD_DEFAULT);
        // Send the data to the model
        $regOutcome = regClient($clientFirstname, $clientLastname, $clientEmail, $hashedPassword);
        
        // Check and report the result
        if($regOutcome === 1){
          $message = "<p>Thanks for registering $clientFirstname. Please use your email and password to login.</p>";
          setcookie('firstname', $clientFirstname, strtotime('+1 year'), '/');
          include '../view/login.php';
          exit;
        } else {
          $message = "<p>Sorry $clientFirstname, but the registration failed. Please try again.</p>";
          include '../view/register.php';
          exit;
        }
        
    default:
      include '../view/admin.php';
}