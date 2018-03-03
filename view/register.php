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
                <form action="/acme/accounts/index.php" method="post" class="acmeform">
                    <fieldset>
                        <legend>Create New Acme Account</legend>
                        <label><span>First Name:</span><input type="text" name="clientFirstname"<?php if(isset($clientFirstname)){echo "value='$clientFirstname'";} ?> placeholder="First Name" pattern="[a-zA-Z .,]{3,99}" title="Only letters please and a minimum of 3 characters." required></label>
                        <label><span>Last Name:</span><input type="text" name="clientLastname" <?php if(isset($clientLastname)){echo "value='$clientLastname'";} ?> placeholder="Last Name" pattern="[a-zA-Z .,]{3,99}" title="Only letters please and a minimum of 3 characters." required></label>
                        <label><span>Email:</span><input type="email" name="clientEmail" <?php if(isset($clientEmail)){echo "value='$clientEmail'";} ?> placeholder="youremail@yourdomain.com" required></label>
                        <label><span>Password:</span><input type="password" name="clientPassword" title="Upper Case, Lower Case, Number/SpecialChar and min 8 Chars" pattern="(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" required></label><span id="pw-note">Passwords must be 8 characters long and contain at least one upper case, one lower case, one number, and one special character.</span>
                        <label><span>Confirm Password:</span><input type="password" name="clientPasswordconfirm" title="UpperCase, LowerCase, Number/SpecialChar and min 8 Chars" pattern="(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" required></label>
                    </fieldset>
                    <input type="submit" value="Create New Account" class="submitBtn">
                    <!--add the action key-value pair-->
                    <input type="hidden" name="action" value="register">
                </form>
            </main>
            <footer id="primary-footer">
                <?php include $_SERVER['DOCUMENT_ROOT'] . '/acme/common/footer.php'; ?>
            </footer>
        </div>
    </body>
</html>
