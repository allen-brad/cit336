<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title> template | Acme, Inc.</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/normalize.css">
        <link rel="stylesheet" href="css/screen.css">
        <link href="https://fonts.googleapis.com/css?family=Bangers" rel="stylesheet">
    </head>
    <body class="home">
        <div id="container">
            <?php include $_SERVER['DOCUMENT_ROOT'] . '/acme/common/header.php'; ?>
            <nav id="primary-nav">
                <?php echo $navList; ?>
            </nav>
            <main>
                <h1>Primary Heading</h1>
            </main>
            <footer id="primary-footer">
                <?php include $_SERVER['DOCUMENT_ROOT'] . '/acme/common/footer.php'; ?>
            </footer>
        </div>
    </body>
</html>
