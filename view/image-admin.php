<?php
if (isset($_SESSION['message'])) {
 $message = $_SESSION['message'];
 unset($_SESSION['message']);
}
?>
<!DOCTYPE html>
<html lang="en-us">
        <head>
        <meta charset="UTF-8">
        <title> Image Management | Acme, Inc.</title>
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
              <h1>Image Management</h1>
              <p>Welcome to the image management page. Please choose one of the options below:</p>
              <?php if (isset($message)) { echo $message;} ?> 
              <form class="acmeform" action="/acme/uploads/" method="post" enctype="multipart/form-data">
                <fieldset>
                  <legend>Add New Product Image</legend>
                  <label>Product
                  <?php echo $prodSelect; ?></label><br>
                  <label>Upload Image: <input type="file" name="file1"></label><br>
                  <input type="submit" class="submitBtn" value="Upload">
                  <input type="hidden" name="action" value="upload"><br><br>
                </fieldset>
              </form>
              <hr>
              <h2>Existing Images</h2>
              <p class="notice">If deleting an image, delete the thumbnail too and vice versa.</p>
              <?php
                if (isset($imageDisplay)) {
                 echo $imageDisplay;
                }
              ?>
            </main>
            <footer id="primary-footer">
                <?php include $_SERVER['DOCUMENT_ROOT'] . '/acme/common/footer.php'; ?>
            </footer>
        </div>
    </body>
</html>