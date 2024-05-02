<?php
require_once('lib/PageTemplate.php');
require 'vendor/autoload.php';
require_once('Models/Database.php');
# trick to execute 1st time, but not 2nd so you don't have an inf loop
if (!isset($TPL)) {
    $TPL = new PageTemplate();
    $TPL->PageTitle = "Login";
    $TPL->ContentBody = __FILE__;
    include "layout.php";
    exit;
}


$dbContext = new DbContext();
$message = "";
$username = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    $username = $_POST['username'];
    $password = $_POST['password'];

    try{
        $dbContext->getUsersDatabase()->getAuth()
            ->login($username, $password);
        header('Location: /');
        exit;
    }

    catch(Exception $e){
        $message = "Could not login";

    }
}
?>

<p>
<div class="row">
                <div class="col-md-12">
                    <div class="newsletter">
                        
                        <p>User<strong>&nbsp;LOGIN</strong></p>
                        <p><?php echo $message; ?></p>
                        <form method ="POST">
                            <input class="input" type="email" placeholder="Enter Your Email" name="username" value="<?php echo $username ?>" >
                            <br/>
                            <br/>   
                            <input class="input" type="password" name="password" placeholder="Enter Your Password">
                            <br/>
                            <br/>
                            <button class="newsletter-btn"><i class="fa fa-envelope"></i> Login</button>
                        </form>
                        <a href="">Lost password?</a>
                    </div>
                </div>
            </div>



    

</p>