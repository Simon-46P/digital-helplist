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
        <div id="bottom-footer">
                <div class="footer-info">
                        <div class="footer">
                            <h3 class="footer-logo">EduQ</h3>
                            <ul class="footer-links">
                                <li>EduQ facilitates the pedagogical work<br>and administrative processes within schools<br>enabling a better education.</li>
                                <li class="logo-text-link"><a href="#"><i class="fa-brands fa-linkedin"></i>@EduQ</a></li>
                            </ul>
                        </div>
                    </div>
                
                    <div class="footer-info">
                        <div class="footer">
                            <h3 class="footer-title">EduQ</h3>
                            <ul class="footer-links underline-effect">
                                <li><a href="#" data-hover="About EduQ">About EduQ</a></li>
                                <li><a href="#" data-hover="Blog">Blog</a></li>
                                <li><a href="#" data-hover="Customers">Customers</a></li>
                                <li><a href="#" data-hover="Terms & Conditions">Terms & Conditions</a></li>
                                <li><a href="#" data-hover="Privacy Policy">Privacy Policy</a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="footer-info">
                        <div class="footer">
                            <h3 class="footer-title">School Forms</h3>
                            <ul class="footer-links underline-effect">
                                <li><a href="#" data-hover="Preschool">Preschool</a></li>
                                <li><a href="#" data-hover="Primary School">Primary School</a></li>
                                <li><a href="#" data-hover="High School">High School</a></li>
                                <li><a href="#" data-hover="University">University</a></li>
                                <li><a href="#" data-hover="Adult Education">Adult Education</a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="footer-info">
                        <div class="footer">
                            <h3 class="footer-title">Products</h3>
                            <ul class="footer-links underline-effect">
                                <li><a href="#" data-hover="Help Queue System">Help Queue System</a></li>
                                <li><a href="#" data-hover="Resource Sharing Hub">Resource Sharing Hub</a></li>
                                <li><a href="#" data-hover="Interactive Whiteboard">Interactive Whiteboard</a></li>
                                <li><a href="#" data-hover="Assessment and Grading Module">Assessment and Grading Module</a></li>
                                <li><a href="#" data-hover="Collaborative Learning Spaces">Collaborative Learning Spaces</a></li>
                            </ul>
                        </div>
                    </div>
                    
                    <div class="footer-info">
                        <div class="footer">
                            <h3 class="footer-title">Contact</h3>
                            <ul class="footer-links underline-effect">
                                <li><a href="#" data-hover="Contact us">Contact us</a></li>
                                <li><a href="#" data-hover="Career">Career</a></li>
                                <li><a href="#" data-hover="Support">Support</a></li>
                            </ul>
                        </div>
                    </div>

            </div>
            <!-- /container -->
        <span class="copyright">

Copyright &copy;
<script>document.write(new Date().getFullYear());</script> EduQ | All rights reserved</a>

</span>
        <!-- /top footer -->
      
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
