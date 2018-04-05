            <header id="primary-header">
                <div id="site-logo"><a href="/acme/index.php"><img src="/acme/images/site/logo.gif" alt="ACME logo"></a></div>
                <div id="account-link">
                  <?php
                    if(isset($cookieFirstname)){
                      echo "<span>Welcome $cookieFirstname</span>";
                    }elseif (isset($_SESSION['loggedin'])) {
                      echo "<span>Welcome ". $_SESSION['clientData']['clientFirstname']."</span>";
                    }
                    
                    if(isset($_SESSION['loggedin'])){
                      echo '<a href="/acme/accounts/"><img src="/acme/images/site/account.gif" alt="account logo">Account Admin</a>';
                      echo '<a id="logout" href="/acme/accounts/?action=logout">Log Out</a>';

                    } else {
                      echo '<a href="/acme/accounts/?action=loginView"><img src="/acme/images/site/account.gif" alt="account logo">My Account</a>';
                    }                    
                  ?>
                  </div>
            </header>
