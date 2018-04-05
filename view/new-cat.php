<?php
//only logged in users with level 2 or higher can enter
if($_SESSION['clientData']['clientLevel'] < 2){
  header('Location: /acme/');
  exit;
}
?><!DOCTYPE html>
<html lang"en-us">
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
                <?php
                    if (isset($message)) {
                    echo $message;
                    }
                ?>
                <form action="/acme/products/" method="post" class="acmeform">
                    <fieldset>
                        <legend>Create New Category</legend>
                        <label><span>Category Name:</span><input type="text" size="25" name="categoryName" <?php if(isset($categoryName)){echo "value='$categoryName'";} ?> placeholder="New Category Name" pattern="[a-zA-Z]{3,30}" title="Only letters please and a minimum of 3 characters." required></label>
                    </fieldset>
                    <input type="submit" value="Add a New Category" class="submitBtn">
                    <!--add the action key-value pair-->
                    <input type="hidden" name="action" value="addCategory">
                </form>
            </main>
            <footer id="primary-footer">
                <?php include $_SERVER['DOCUMENT_ROOT'] . '/acme/common/footer.php'; ?>
            </footer>
        </div>
    </body>
</html>
