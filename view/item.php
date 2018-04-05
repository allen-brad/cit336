<?php
if (isset($_SESSION['reviewMessage'])) {
 $reviewMessage = $_SESSION['reviewMessage'];
 unset($_SESSION['reviewMessage']);
}
?>
<!DOCTYPE html>
<html lang="en-us">
        <head>
        <meta charset="UTF-8">
        
        <title> <?php echo $item['invName']; ?> | Acme, Inc.</title>
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
              <div id="sub-main" class="item-display">
                <?php if (isset($message)) { echo $message;} ?>
                <?php if(isset($itemDisplay)){ echo $itemDisplay; } ?>
              </div>
              <?php if(isset($thumbsDisplay)){ echo $thumbsDisplay; } ?>
              <hr>
              <section>
                <h3>Customer Reviews</h3>
                <?php if (isset($reviewMessage)) { echo $reviewMessage;} ?>
                <?php if (isset($itemReviewForm)) { echo $itemReviewForm;} ?>
                <?php if (isset($reviewList)) { echo $reviewList;} ?>
              </section>
            </main>
            <footer id="primary-footer">
                <?php include $_SERVER['DOCUMENT_ROOT'] . '/acme/common/footer.php'; ?>
            </footer>
        </div>
    </body>
</html>
