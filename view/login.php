<!DOCTYPE html>
<html lang"en-us">
    <head>
        <meta charset="UTF-8">
        <title> Log In | Acme, Inc.</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../css/normalize.css">
        <link rel="stylesheet" href="../css/screen.css">
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
                <form action="/acme/accounts/" method="post" enctype="multipart/form-data" class="acmeform">
                    <fieldset>
                        <legend>Acme Login</legend>
                        <label><span>Email:</span><input type="email" name="clientEmail" <?php if(isset($clientEmail)){echo "value='$clientEmail'";} ?> size="35" placeholder="youremail@yourdomain.com" required></label>
                        <label><span>Password:</span><input type="password" name="clientPassword" title="UpperCase, LowerCase, Number/SpecialChar and min 8 Chars" pattern="(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" required></label><span id="pw-note">Passwords must be 8 characters long and contain at least one upper case, one lower case, one number, and one special character.</span>
                    </fieldset>
                    <input type="submit" value="Sign In" class="submitBtn">
                    <!--add the action key-value pair-->
                    <input type="hidden" name="action" value="login">
                    <?php if(isset($invIdPair)) { echo $invIdPair; } ?>
                </form>
                <form action="/acme/accounts/" method="post" enctype="multipart/form-data" class="acmeform">
                    <input type="submit" value="Create New Account" class="newAccountBtn">
                    <!--add the action key-value pair-->
                    <input type="hidden" name="action" value="createAccount">
                </form>
            </main>
            <footer id="primary-footer">
                <?php include $_SERVER['DOCUMENT_ROOT'] . '/acme/common/footer.php'; ?>
            </footer>
        </div>
    </body>
</html>
