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
$user_id = $dbContext->getUsersDatabase()->getAuth()->getUserId();
if (!$dbContext->getUsersDatabase()->getAuth()->isLoggedIn()) {
    header("Location: /AccountLogin.php");
    exit;
}
date_default_timezone_set("Europe/Stockholm");
$message = "";
$username = "";
$roomId = intval($_GET["roomId"]);
$helpRoom = $dbContext->getHelpRooms($roomId)[0];
$helpList = $dbContext->getHelpQueue($roomId);
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (count($dbContext->IfUserInQueue($user_id, $roomId)) > 0) {
        $dbContext->removeFromQueue($user_id, $roomId);
        $message = "You left your queue in " . $helpRoom->name;
        $helpList = $dbContext->getHelpQueue($roomId);


    } else {
        $date = date('Y-m-d H:i:s');
        $dbContext->addUserToQueue($date, $roomId, $user_id);
        $message = "You joined queue in " . $helpRoom->name;
        $helpList = $dbContext->getHelpQueue($roomId);

    }

}
?>

<p>
<div class="row">

    <div class="col-md-12">
        <?php

        if (count($dbContext->IfUserInQueue($user_id, $roomId)) > 0) {
            ?>
            <form method="POST">
                <input type="submit" value="Leave Queue">
            </form>
            <?php
        } else {
            ?>
            <form method="POST">
                <input type="submit" value="Join Queue">
            </form>
            <?php
        }

        ?>
        <div class="newsletter">

            <p>You are in room <strong>&nbsp;<?= $helpRoom->name ?></strong></p>
            <p><?php echo $message; ?></p>

            <section>
                <h2>Help List</h2>

                <?php
                foreach ($helpList as $helpPosition) {

                    ?>

                    <p><?= $helpPosition->givenname ?>     <?= $helpPosition->lastname ?></p>
                    <?php
                }
                ?>


            </section>



        </div>

    </div>
</div>





</p>