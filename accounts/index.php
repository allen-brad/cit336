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
          $message = $clientData['clientPassword'].'<p class="notice">Please check your password and try again.</p>';
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
        
        //comes back empty if bad and gets caught below
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
        break;
    case 'mod':
        //should be logged in to get here so load clientData from the $_SESSION 
        $clientData = getClient($_SESSION['clientData']['clientEmail']);
        if(count($clientData)<1){
          $message = 'Sorry, no client information could be found.';
        }        
        include '../view/client-update.php';
        exit;
        break;
    case 'updateAccount':
      
        $clientData = getClient($_SESSION['clientData']['clientEmail']);
        if(count($clientData)<1){
          $message = 'Sorry, no client information could be found.';
        }
        //Filter and store data
        $clientFirstname = filter_input(INPUT_POST, 'clientFirstname', FILTER_SANITIZE_STRING);
        $clientLastname = filter_input(INPUT_POST, 'clientLastname', FILTER_SANITIZE_STRING);
        $clientEmail = filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL);
        $clientId = filter_input(INPUT_POST, 'clientId', FILTER_SANITIZE_NUMBER_INT);
        
        //is a valid email?
        $clientEmail = checkEmail($clientEmail);
        
        //if email is diffent check to see if the new email has already been used by someone else
        if($clientEmail !== $_SESSION['clientData']['clientEmail']){
          $emailExists = checkExistingEmail($clientEmail);
          if ($emailExists){
            $message = '<p class="red">That email address is already registered.</p>';
            include '../view/client-update.php';
            exit;
          }
        }
        // Check for missing data
        if(empty($clientFirstname) || empty($clientLastname) || empty($clientEmail)){
        $message = '<p class="red">Please provide information for all empty form fields.</p>';
        include '../view/client-update.php';
        exit; }
        
        // Send the data to the model
        $updateOutcome = updateClient($clientFirstname, $clientLastname, $clientEmail, $clientId);
        
        // Check and report the result
        if($updateOutcome === 1){
          $message = '<p class ="green">Bam! '.$clientFirstname.', you updated your account.</p>';
          setcookie('firstname', $clientFirstname, strtotime('+1 year'), '/');
          // Update the $clientData Query the client data based on the email address
          $clientData = getClient($clientEmail);
          // Update the session variables
          // Remove the password from the array the array_pop function removes the last element from an array
          array_pop($clientData);
          // Store the array into the session
           $_SESSION['clientData'] = $clientData;
           // build the client list <ul>
          $clientList = getClientList();
          include '../view/admin.php';
          exit;
        } else {
          $message = '<p class ="red">Splat! '.$clientFirstname.', the update failed! Please try again.</p>';
          include '../view/client-update.php';
          exit;
        }
        break;
    case 'updatePassword':
        $clientData = getClient($_SESSION['clientData']['clientEmail']);
        if(count($clientData)<1){
          $message = 'Sorry, no client information could be found.';
        }
        $clientPassword = filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_STRING);
        $newClientPassword = filter_input(INPUT_POST, 'newClientPassword', FILTER_SANITIZE_STRING);
        $newClientPasswordConfirm = filter_input(INPUT_POST, 'newClientPasswordConfirm', FILTER_SANITIZE_STRING);
        $clientId = filter_input(INPUT_POST, 'clientId', FILTER_SANITIZE_NUMBER_INT);

        //check new password, it comes back empty if bad and gets caught below
        $checkPassword = checkPassword($newClientPassword);
        
        // Check for missing data
        if(empty($clientPassword) || empty($checkPassword) || empty($newClientPasswordConfirm)){
        $lowerMessage = '<p class="red">Please provide information for all empty form fields.</p>';
        include '../view/client-update.php';
        exit; }
        
        //get the current password hash for comparrison
        $currentPasswordHash = getPasswordById($clientId);
        //compare current password against the hashed password
        $hashCheck = password_verify($clientPassword, $currentPasswordHash);
        
        // If the hashes don't match create an error and return to the update-client view
        if (!$hashCheck) {
          $lowerMessage = '<p class="red">Current Password Incorrect. Please re-enter your current password and try again.</p>';
          include '../view/client-update.php';
          exit;
        }
        // Make sure the two new passwords match each other.
        if ($newClientPassword !== $newClientPasswordConfirm) {
          $lowerMessage = '<p class="red">New Passwords Do Not Match. Please try again.</p>';
          include '../view/client-update.php';
          exit;
        }
        
        // Hash the new password
        $hashedPassword = password_hash($newClientPassword, PASSWORD_DEFAULT);
        //Send the data to the model
        $regOutcome = updateClientPassword($clientId, $hashedPassword);
        
        // Check and report the result
        if($regOutcome === 1){
          $message = '<p class ="green">Bam! You updated your password.</p>';
          $clientList = getClientList();
          include '../view/admin.php';
          exit;
        } else {
          $lowerMessage = '<p class ="red">Splat! The password update failed! Please try again.</p>';
          include '../view/client-update.php';
          exit;
        }
        break;  
    default:
      //incase someone must hits /acme/accounts
      if($_SESSION['loggedin']){
        // Query the client data based on the email address
        $clientList = getClientList();
      }
      include '../view/admin.php';
}