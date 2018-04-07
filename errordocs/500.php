<!DOCTYPE html>
<html lang="en-us">
    <head>
        <meta charset="UTF-8">
        <title> template | Acme, Inc.</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="/acme/css/normalize.css">
        <link rel="stylesheet" href="/acme/css/screen.css">
        <link href="https://fonts.googleapis.com/css?family=Bangers" rel="stylesheet">
    </head>
    <body class="home">
        <div id="container">
            <header id="primary-header">
                <div id="site-logo"><a href="index.php"><img src="/acme/images/site/logo.gif" alt="ACME logo"></a></div>
                <div id="account-link"><a href="index.php"><img src="/acme/images/site/account.gif" alt="account logo">My Account</a></div>
            </header>
            <nav id="primary-nav">
                <?php include $_SERVER['DOCUMENT_ROOT'] . '/acme/common/primary-nav.php'; ?>
            </nav>
            <main>
                <h1>Server Error</h1>
                <img src="/acme/images/site/acme_ouch.png" alt="ouch">
            </main>
            <footer id="primary-footer">
                <?php include $_SERVER['DOCUMENT_ROOT'] . '/acme/common/footer.php'; ?>
            </footer>
        </div>
    </body>
</html>
