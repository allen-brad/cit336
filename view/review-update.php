<!DOCTYPE html>
<html lang="en-us">
    <head>
        <meta charset="UTF-8">
        <title> Review Update | Acme, Inc.</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="/acme/css/normalize.css">
        <link rel="stylesheet" href="/acme/css/screen.css">
        <link href="https://fonts.googleapis.com/css?family=Bangers" rel="stylesheet">
        <script>
          function adjustRating(rating){document.getElementById("ratingValue").innerHTML = "Rating: " + rating + " Stars";}
        </script>
    </head>
    <body class="home">
        <div id="container">
            <?php include $_SERVER['DOCUMENT_ROOT'] . '/acme/common/header.php'; ?>
            <nav id="primary-nav">
                <?php echo $navList; ?>
            </nav>
            <main>
              <?php if (isset($message)) {echo $message;}?>
                <form action="/acme/reviews/" method="post" class="acmeform">
                  <fieldset>
                  <legend>Update your <?php if (isset($invName)) {echo $invName;}?> review</legend>
                  <p>Reviewed on <?php if (isset($reviewDate)) {echo $reviewDate;}?></p>
                  <label><span>Review Text:</span><textarea name="reviewText" required><?php if (isset($reviewText)) {echo $reviewText;}?></textarea></label>
                  <label><span id="ratingValue">Rating: <?php if (isset($reviewRating)) {echo $reviewRating;}?> Stars</span><input type="range" name="reviewRating" id="reviewRating" value="<?php if (isset($reviewRating)) {echo $reviewRating;}?>" min="1" max="5" step="1" oninput="adjustRating(this.value)" onchange="adjustRating(this.value)">
		</label>
                  </fieldset>
                  <input type="submit" value="Submit Review" class="submitBtn">
                  <input type="hidden" name="action" value="updateReview">
                  <input type="hidden" name="reviewId" value="<?php if (isset($reviewId)) {echo $reviewId;}?>">
                  <input type="hidden" name="invName" value="<?php if (isset($invName)) {echo $invName;}?>">
                  <input type="hidden" name="reviewDate" value="<?php if (isset($reviewDate)) {echo $reviewDate;}?>">
                </form>
            </main>
            <footer id="primary-footer">
                <?php include $_SERVER['DOCUMENT_ROOT'] . '/acme/common/footer.php'; ?>
            </footer>
        </div>
    </body>
</html>
