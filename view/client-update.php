<?php
//only logged in users can enter
if(!$_SESSION['loggedin']){
  //not logged in so send them home
  header('Location: /acme/');
  exit;
}
  $fullName = $_SESSION['clientData']['clientFirstname'].' '.$_SESSION['clientData']['clientLastname'];
?>
<!DOCTYPE html>
<html lang="en-us">
    <head>
        <meta charset="UTF-8">
        <title> Update Account Info | Acme, Inc.</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="/acme/css/normalize.css">
        <link rel="stylesheet" href="/acme/css/screen.css">
        <link href="https://fonts.googleapis.com/css?family=Bangers" rel="stylesheet">
    </head>
    <body class="home">
        <div id="container">
            <?php include $_SERVER['DOCUMENT_ROOT'] . '/acme/common/header.php'; ?>
            <nav id="primary-nav">
                <?php echo $navList; ?>
            </nav>
            <main>
                <?php if (isset($message)) { echo $message;}?>
                <form action="/acme/accounts/" method="post" class="acmeform">
                    <fieldset>
                        <legend>Update Account</legend>
                        <label><span>First Name:</span><input type="text" name="clientFirstname" <?php if(isset($clientFirstname)){ echo "value='$clientFirstname'"; } elseif(isset($clientData['clientFirstname'])) {echo "value='$clientData[clientFirstname]'"; }?> pattern="[a-zA-Z .,]{3,99}" title="Only letters please and a minimum of 3 characters." required></label>
                        <label><span>Last Name:</span><input type="text" name="clientLastname" <?php if(isset($clientLastname)){ echo "value='$clientLastname'"; } elseif(isset($clientData['clientLastname'])) {echo "value='$clientData[clientLastname]'"; }?> pattern="[a-zA-Z .,]{3,99}" title="Only letters please and a minimum of 3 characters." required></label>
                        <label><span>Email:</span><input type="email" name="clientEmail" <?php if(isset($clientEmail)){ echo "value='$clientEmail'"; } elseif(isset($clientData['clientEmail'])) {echo "value='$clientData[clientEmail]'"; }?> required></label>
                    </fieldset>
                    <input type="submit" value="Update Account" class="submitBtn">
                    <!--add the action key-value pair-->
                    <input type="hidden" name="action" value="updateAccount">
                    <input type="hidden" name="clientId" value="<?php if(isset($clientId)){ echo $clientId; } elseif(isset($clientData['clientId'])) {echo $clientData['clientId']; }?>">
                </form>
                <br>
                <?php if (isset($lowerMessage)) { echo $lowerMessage;}?>
                <form action="/acme/accounts/" method="post" class="acmeform">
                    <fieldset>
                        <legend>Change Password</legend>        
                        <label><span>Current Password:</span><input type="password" name="clientPassword" title="Upper Case, Lower Case, Number/SpecialChar and min 8 Chars" pattern="(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" required></label><span id="pw-note"></span>
                        <label><span>New Password:</span><input type="password" name="newClientPassword" title="Upper Case, Lower Case, Number/SpecialChar and min 8 Chars" pattern="(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" required></label><span id="pw-note">Passwords must be 8 characters long and contain at least one upper case, one lower case, one number, and one special character.</span>
                        <label><span>Confirm New Password:</span><input type="password" name="newClientPasswordConfirm" title="UpperCase, LowerCase, Number/SpecialChar and min 8 Chars" pattern="(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" required></label>
                    </fieldset>
                    <input type="submit" value="Change Password" class="submitBtn">
                    <!--add the action key-value pair-->
                    <input type="hidden" name="action" value="updatePassword">
                    <input type="hidden" name="clientId" value="<?php if(isset($clientId)){ echo $clientId; } elseif(isset($clientData['clientId'])) {echo $clientData['clientId']; }?>">
                </form>
            </main>
            <footer id="primary-footer">
                <?php include $_SERVER['DOCUMENT_ROOT'] . '/acme/common/footer.php'; ?>
            </footer>
        </div>
    </body>
</html>
