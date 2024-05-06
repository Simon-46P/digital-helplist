<?php
require_once ('lib/PageTemplate.php');
require 'vendor/autoload.php';
require_once ('Models/Database.php');
# trick to execute 1st time, but not 2nd so you don't have an inf loop
if (!isset($TPL)) {
    $TPL = new PageTemplate();
    $TPL->PageTitle = "EduQ - Login";
    $TPL->ContentBody = __FILE__;
    include "layout.php";
    exit;
}

$dbContext = new DbContext();
if (!$dbContext->getUsersDatabase()->getAuth()->isLoggedIn()) {
    header("Location: /AccountLogin.php");
    exit;
}

$message = "";
$username = "";
$roomId = intval($_GET["roomId"]);
$helpRoom = $dbContext->getHelpRooms($roomId)[0];


?>

<p>
<div class="row">
    <div class="col-md-12">
        <div class="newsletter">

            <p>You are in room <strong>&nbsp;<?= $helpRoom->name ?></strong></p>
            <p><?php echo $message; ?></p>



        </div>

    </div>
</div>





</p>