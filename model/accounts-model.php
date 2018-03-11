<?php
/* 
 * Accounts model
 */
//check for existing client first
function checkExistingEmail($clientEmail){
  $db = acmeConnect();
  $sql = 'SELECT clientEmail FROM clients WHERE clientEmail = :email';
  $stmt = $db->prepare($sql);
  $stmt->bindValue(':email', $clientEmail, PDO::PARAM_STR);
  $stmt->execute();
  $matchEmail = $stmt->fetch(PDO::FETCH_NUM);
  $stmt->closeCursor();
  if(empty($matchEmail)){
    return 0;
  } else {
    return 1;
  }
}
    
//Insert site visitor data to database
function regClient($clientFirstName, $clientLastName, $clientEmail,
        $clientPassword){
    //create connection object
    $db = acmeConnect();
    //sql statement
    $sql = 'INSERT INTO clients (clientFirstName, clientLastName, clientEmail,
            clientPassword) VALUES (:firstname, :lastname, :email, :password)';
    
   //creates prepared statement
    $stmt = $db->prepare($sql);
    // swap out varialbes for actual values
    //tell database the type of data
    $stmt->bindValue(':firstname', $clientFirstName, PDO::PARAM_STR);
    $stmt->bindValue(':lastname', $clientLastName, PDO::PARAM_STR);
    $stmt->bindValue(':email', $clientEmail, PDO::PARAM_STR);
    $stmt->bindValue(':password', $clientPassword, PDO::PARAM_STR);
    
    //use the prepared statement to insert data
    $stmt->execute();
    //check to see if it worked
    $rowsChanged = $stmt->rowCount();
    //close connection
    $stmt->closeCursor();
    // Return the indication of success (rows changed)
    return $rowsChanged;
}
// Update account info
function updateClient($clientFirstname, $clientLastname, $clientEmail, $clientId){
      //create connection object
    $db = acmeConnect();
    //sql statement
    $sql = 'UPDATE clients SET clientFirstname = :clientFirstname, clientLastname = :clientLastname, clientEmail = :clientEmail WHERE clientId = :clientId';
   //creates prepared statement
    $stmt = $db->prepare($sql);
    // swap out varialbes for actual values
    //tell database the type of data
    $stmt->bindValue(':clientFirstname', $clientFirstname, PDO::PARAM_STR);
    $stmt->bindValue(':clientLastname', $clientLastname, PDO::PARAM_STR);
    $stmt->bindValue(':clientEmail', $clientEmail, PDO::PARAM_STR);
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
// Update account password
function updateClientPassword($clientId, $hashedPassword){
      //create connection object
    $db = acmeConnect();
    //sql statement
    $sql = 'UPDATE clients SET clientPassword = :clientPassword WHERE clientId = :clientId';
   //creates prepared statement
    $stmt = $db->prepare($sql);
    // swap out varialbes for actual values
    //tell database the type of data
    $stmt->bindValue(':clientPassword', $hashedPassword, PDO::PARAM_STR);
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

// Get client data based on an email address
function getClient($clientEmail){
  $db = acmeConnect();
  $sql = 'SELECT clientId, clientFirstname, clientLastname, clientEmail, clientLevel, clientPassword FROM clients WHERE clientEmail = :email';
  $stmt = $db->prepare($sql);
  $stmt->bindValue(':email', $clientEmail, PDO::PARAM_STR);
  $stmt->execute();
  $clientData = $stmt->fetch(PDO::FETCH_ASSOC);
  $stmt->closeCursor();
  return $clientData;
}

function getPasswordById($clientId){
  $db = acmeConnect();
  $sql = 'SELECT clientPassword FROM clients WHERE clientId = :clientId';
  $stmt = $db->prepare($sql);
  $stmt->bindValue(':clientId', $clientId, PDO::PARAM_INT);
  $stmt->execute();
  $currentPassword = $stmt->fetch(PDO::FETCH_ASSOC);
  $stmt->closeCursor();
  return $currentPassword['clientPassword'];
}
// Get an UL of client name and email
function getClientList(){
  $clientList = '<ul id="clientDataList">';
  foreach ($_SESSION['clientData'] as $key => $value) {
    if ($key == 'clientFirstname') {
        $clientList .= "<li>First Name: " . $value . "</li>";
      } elseif ($key == 'clientLastname'){
        $clientList .= "<li>Last Name: " . $value . "</li>";
      }elseif ($key == 'clientEmail'){
        $clientList .= "<li>Email: " . $value . "</li>";
      }
    }
  $clientList .= '</ul>';
  return $clientList;
}