                <hr>
                <p>&copy; ACME, All rights reserved.<br>
                All images used are believed to be in "Fair Use".
                Please notify the author if any are not and they will be removed.<br>
                Last Updated:
                <?php $filename = basename($_SERVER['SCRIPT_NAME']);
                    if (file_exists($filename)) {
                    echo date ("F d Y H:i:s", filemtime($filename));
                    }
                ?>
                </p>