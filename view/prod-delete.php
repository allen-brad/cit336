<?php
//only logged in users with level 2 or higher can enter
if($_SESSION['clientData']['clientLevel'] < 2){
  header('Location: /acme/');
  exit;
}
?>
<!DOCTYPE html>
<html lang"en-us">
    <head>
        <meta charset="UTF-8">
        <title><?php if(isset($prodInfo['invName'])){ echo "Delete $prodInfo[invName] ";}?>| ACME, Inc.</title>
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
                        <legend><?php if(isset($prodInfo['invName'])){ echo "Delete $prodInfo[invName] ";}?></legend>
                        <p>Confirm Product Deletion. The delete is permanent.</p>
                        <label><span>Product Name:</span><input type="text" size="25" name="invName" <?php if(isset($prodInfo['invName'])) {echo "value='$prodInfo[invName]'"; }?> readonly></label>
                        <label><span>Product Description:</span><textarea name="invDescription" readonly><?php if(isset($prodInfo['invDescription'])) {echo $prodInfo['invDescription']; } ?></textarea></label>                    
                    </fieldset>
                    <input type="submit" value="Delete Product" class="submitBtn">
                    <!--add the action key-value pair-->
                    <input type="hidden" name="action" value="deleteProd">
                    <input type="hidden" name="invId" value="<?php if(isset($prodInfo['invId'])){ echo $prodInfo['invId'];}?>">
                </form>
            </main>
            <footer id="primary-footer">
                <?php include $_SERVER['DOCUMENT_ROOT'] . '/acme/common/footer.php'; ?>
            </footer>
        </div>
    </body>
</html>
