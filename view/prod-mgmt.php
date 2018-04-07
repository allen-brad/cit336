<?php
//only logged in users with level 2 or higher can enter
if($_SESSION['clientData']['clientLevel'] < 2){
  header('Location: /acme/');
}
if (isset($_SESSION['message'])) {
 $message = $_SESSION['message'];
 unset($_SESSION['message']);
}
?>
<!DOCTYPE html>
<html lang="en-us">
    <head>
        <meta charset="UTF-8">
        <title> Prod MGMT | Acme, Inc.</title>
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
                <h1>Product Management</h1>
                <form action="/acme/products/" method="post" class="acmeform">
                  <input type="submit" value="Add a New Category" class="submitBtn">
                    <!--add the action key-value pair-->
                    <input type="hidden" name="action" value="newCategory">
                </form>
                <br>
                <form action="/acme/products/" method="post" class="acmeform">
                  <input type="submit" value="Add a New Product" class="submitBtn">
                    <!--add the action key-value pair-->
                    <input type="hidden" name="action" value="newProduct">
                </form>
                <?php
                  if (isset($message)) {
                    echo $message;
                  } if (isset($prodList)) {
                    echo $prodList;
                  }
                ?>
            </main>
            <footer id="primary-footer">
                <?php include $_SERVER['DOCUMENT_ROOT'] . '/acme/common/footer.php'; ?>
            </footer>
        </div>
    </body>
</html>
