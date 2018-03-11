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
<html>
        <head>
        <meta charset="UTF-8">
        <title> Register | Acme, Inc.</title>
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
                <h1><?php echo $fullName . ", you are logged in.";?></h1>
                <?php
                  if (isset($message)) {
                    echo $message;
                  }
                ?>
                <?php
                  echo $clientList;
                  if($_SESSION['clientData']['clientLevel']>1){
                    echo'<form action="/acme/products/" method="post" class="acmeform">
                    <input type="submit" value="Manage Products" class="submitBtn">
                    </form>';
                  }
                ?>                
                <form action="/acme/accounts/" method="post" class="acmeform">
                  <input type="submit" value="Update Account Information" class="submitBtn">
                    <!--add the action key-value pair-->
                    <input type="hidden" name="action" value="mod">
                    <input type="hidden" name="clientEmail" value="<?php if(isset($_SESSION['clientData']['clientEmail'])){ echo $_SESSION['clientData']['clientEmail'];} ?>">
                </form>             
            </main>
            <footer id="primary-footer">
                <?php include $_SERVER['DOCUMENT_ROOT'] . '/acme/common/footer.php'; ?>
            </footer>
        </div>
    </body>
</html>
