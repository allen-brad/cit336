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
                <?php
                    if (isset($message)) {
                    echo $message;
                    }
                ?>
                <h1><?php echo $fullName; ?></h1>
                <?php echo $clientList;
                if($_SESSION['clientData']['clientLevel']>1){
                  echo '<p><a href="/acme/products" title="Manage Products">Manage Products</a></p>';
                }
                ?>                
            </main>
            <footer id="primary-footer">
                <?php include $_SERVER['DOCUMENT_ROOT'] . '/acme/common/footer.php'; ?>
            </footer>
        </div>
    </body>
</html>
