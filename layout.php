<?php
require_once('lib/PageTemplate.php');

ob_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$dbContext = new DbContext();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php if(isset($TPL->PageTitle)) { echo $TPL->PageTitle; } ?></title>
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,700" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="/css/bootstrap.min.css" />
    <link type="text/css" rel="stylesheet" href="/css/slick.css" />
    <link type="text/css" rel="stylesheet" href="/css/slick-theme.css" />
    <link type="text/css" rel="stylesheet" href="/css/nouislider.min.css" />
    <link rel="stylesheet" href="/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <link type="text/css" rel="stylesheet" href="/css/style.css" />
    <link type="text/css" rel="stylesheet" href="/css/site.css" />
    <link rel="icon" href="img/favicon.ico" type="image/x-icon">
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <?php if(isset($TPL->ContentHead)) { include $TPL->ContentHead; } ?>
</head>
<body>
    <!-- HEADER -->
    <header class="navbar-top">
        <!-- TOP HEADER -->



            <div class="nav-container">


            <div class="logo-container">
    <a href="/">
        <img src="img/favicon.ico" alt="logo" width="32px" height="28px">
        <span class="logo-text">Edu</span>
    </a>
    <?php if(!$dbContext->getUsersDatabase()->getAuth()->isLoggedIn()){
        echo '';
    } else {
        $username = $dbContext->getUsersDatabase()->getAuth()->getUsername();
        $role = $dbContext->getRoleByUsername($username);
        echo '<a class="role-text" href="ManageAccount.php" title="Wrong role? Click to manage account">' . $role . '</a>';
    } ?>
</div>


                
                <ul class="header-links">
                <ul class="navbar-nav">
    <li class="nav-item">
        <?php if(!$dbContext->getUsersDatabase()->getAuth()->isLoggedIn()){
            echo '';
        } else {
            $username = $dbContext->getUsersDatabase()->getAuth()->getUsername();
            $givenname = $dbContext->getGivenNameByUsername($username);
            echo '<a class="nav-link text-dark" href="ManageAccount.php" title="Manage Account">Welcome back, ' . $givenname . '!</a>';
            
        } ?>
    </li>
    <li class="nav-item">
        <?php if(!$dbContext->getUsersDatabase()->getAuth()->isLoggedIn()){
            echo '';
        } else {
            echo '<a class="nav-link text-dark" href="/logout.php" title="Manage"><i class="fa-solid fa-right-from-bracket"></i>Logout</a>';
        } ?>
    </li>
    <li class="nav-item">
        <?php if($dbContext->getUsersDatabase()->getAuth()->isLoggedIn()){
            echo '';
        } else {
            echo '<i class="fa-solid fa-user-plus"></i> <a class="nav-link text-dark" href="/AccountRegister.php">Register</a>';
        } ?>
    </li>
    <li class="nav-item">
        <?php if($dbContext->getUsersDatabase()->getAuth()->isLoggedIn()){
            echo '';
        } else {
            echo '<i class="fa-solid fa-right-to-bracket"></i> <a class="nav-link text-dark" href="/AccountLogin.php">Login</a>';
        } ?>
    </li>
</ul>

                </ul>
            </div>

        <!-- /TOP HEADER -->
    
    </header>
    <!-- /HEADER -->
    <!-- NAVIGATION -->
    <nav id="navigation">
        <!-- container -->
     
            <!-- responsive-nav -->
            <div id="responsive-nav">
                <!-- NAV -->
                <ul class="main-nav nav navbar-nav">
                    <!-- You can add your navigation items here -->
                </ul>
                <!-- /NAV -->
            </div>
            <!-- /responsive-nav -->
        
        <!-- /container -->
    </nav>
    <!-- /NAVIGATION -->
    <!-- SECTION -->
    <div class="section">
        <!-- container -->
        <div class="container">
            <?php if(isset($TPL->ContentBody)) { include $TPL->ContentBody; } ?>
        </div>
        <!-- /container -->
    </div>
    <!-- /SECTION -->
    <!-- FOOTER -->
    <footer id="footer" class="center">
        <!-- top footer -->
        <div >
            <!-- container -->
            <div class="container">
                <!-- row -->
                <div class="row">
                    <!-- Footer content goes here -->
                </div>
                <!-- /row -->
            </div>
            <!-- /container -->
        </div>
        <!-- /top footer -->
        <!-- bottom footer -->
        <div id="bottom-footer">
            <div>
                <!-- row -->
                <div class="row">
<div class="col-md-3 col-xs-6">
                        <div class="footer">
                            <h3 class="footer-title">About Us</h3>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut.</p>
                            <ul class="footer-links">
                                <li><a href="#"><i class="fa fa-map-marker"></i>1734 Stonecoal Road</a></li>
                                <li><a href="#"><i class="fa fa-phone"></i>+021-95-51-84</a></li>
                                <li><a href="#"><i class="fa fa-envelope-o"></i>email@email.com</a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-md-3 col-xs-6">
                        <div class="footer">
                            <h3 class="footer-title">Categories</h3>
                            <ul class="footer-links">
                                <li><a href="#">Hot deals</a></li>
                                <li><a href="#">Laptops</a></li>
                                <li><a href="#">Smartphones</a></li>
                                <li><a href="#">Cameras</a></li>
                                <li><a href="#">Accessories</a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="clearfix visible-xs"></div>

                    <div class="col-md-3 col-xs-6">
                        <div class="footer">
                            <h3 class="footer-title">Information</h3>
                            <ul class="footer-links">
                                <li><a href="#">About Us</a></li>
                                <li><a href="#">Contact Us</a></li>
                                <li><a href="#">Privacy Policy</a></li>
                                <li><a href="#">Orders and Returns</a></li>
                                <li><a href="#">Terms & Conditions</a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-md-3 col-xs-6">
                        <div class="footer">
                            <h3 class="footer-title">Service</h3>
                            <ul class="footer-links">
                                <li><a href="#">My Account</a></li>
                                <li><a href="#">View Cart</a></li>
                                <li><a href="#">Wishlist</a></li>
                                <li><a href="#">Track My Order</a></li>
                                <li><a href="#">Help</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- /row -->
            </div>
            <!-- /container -->
        </div>
        <!-- /top footer -->
        <!-- bottom footer -->
        <div id="bottom-footer">
        <img src="\img\eduq-white.png" alt="logo" width="10%" height="10%" class="footer-logo">
            <div class="container">
                <!-- row -->
                <div class="row">
                    <div class="col-md-12 text-center">
                        <ul class="footer-payments">
                            <li><a href="#"><i class="fa-brands fa-cc-visa"></i></a></li>
                            <li><a href="#"><i class="fa fa-credit-card"></i></a></li>
                            <li><a href="#"><i class="fa-brands fa-cc-paypal"></i></a></li>
                            <li><a href="#"><i class="fa-brands fa-cc-mastercard"></i></a></li>
                            <li><a href="#"><i class="fa-brands fa-cc-discover"></i></a></li>
                            <li><a href="#"><i class="fa-brands fa-cc-amex"></i></a></li>
                        </ul>
                        <span class="copyright">

                            Copyright &copy;
                            <script>document.write(new Date().getFullYear());</script> EduQ | All rights reserved</a>

                        </span>
                    </div>
                </div>
                <!-- /row -->
            </div>
            <!-- /container -->
        </div>
        <!-- /bottom footer -->
    </footer>
    <!-- /FOOTER -->
    <!-- jQuery Plugins -->
    <script src="/js/jquery.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <script src="/js/slick.min.js"></script>
    <script src="/js/nouislider.min.js"></script>
    <script src="/js/jquery.zoom.min.js"></script>
    <script src="/js/main.js"></script>
    <!-- @RenderSection("Scripts", false) -->
</body>
</html>

<?php
ob_end_flush();
?>
