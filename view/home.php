<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title> Home | Acme, Inc.</title>
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
                <h1>Welcome to Acme!</h1>
                <div id="main-banner">
                    <div id="featured-item">
                        <ul>
                            <li><h2>Acme Rocket</h2></li>
                            <li>Quick lighting fuse</li>
                            <li>NHTSA approved seat belts</li>
                            <li>Mobile launch stand included</li>
                            <li><a href="/acme/cart/"><img id="actionbtn" alt="Add to cart button" src="/acme/images/site/iwantit.gif"></a></li>
                        </ul>
                    </div>
                </div>
                <div id="sub-main">
                    <section id="featured-recipes">
                        <h2>Featured Recipes</h2>
                        <div id="recipe-box">
                            <a href="#">
                                <figure>
                                    <img src="/acme/images/recipes/bbqsand.jpg" alt="recipe photo">
                                    <figcaption>Pulled Roadrunner BBQ</figcaption>
                                </figure>
                            </a>
                            <a href="#">
                                <figure>
                                    <img src="/acme/images/recipes/potpie.jpg" alt="recipe photo">
                                    <figcaption>Roadrunner Pot Pie</figcaption>
                                </figure>
                            </a>
                            <a href="#">
                                <figure>
                                    <img src="/acme/images/recipes/soup.jpg" alt="recipe photo">
                                    <figcaption>Roadrunner Soup</figcaption>
                                </figure>
                            </a>
                            <a href="#">
                                <figure>
                                    <img src="/acme/images/recipes/taco.jpg" alt="recipe photo">
                                    <figcaption>Roadrunner Tacos</figcaption>
                                </figure>
                            </a>
                        </div>
                    </section>
                    <section id="rocktet-review">
                        <h2>Acme Rocket Review</h2>
                        <ul>
                            <li>"I don't know how I ever caught roadrunners before this." (4/5)</li>
                            <li>"That thing was fast!" (4/5)</li>
                            <li>"Talk about fast delivery." (5/5)</li>
                            <li>"I didn't even have to pull the meat apart." (4.5/5)</li>
                            <li>"I'm on my thirtieth one. I love these things!" (5/5)</li>
                        </ul>
                    </section>
                </div>
            </main>
            <footer id="primary-footer">
                <?php include $_SERVER['DOCUMENT_ROOT'] . '/acme/common/footer.php'; ?>
            </footer>
        </div>
    </body>
</html>
