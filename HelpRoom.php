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


$message = "";
$username = "";
$roomId = intval($_GET["roomId"]);
$helpRooms = $dbContext->getHelpRooms($user_id);
if (!$dbContext->getUsersDatabase()->getAuth()->isLoggedIn() || $dbContext->roomPermissions($roomId, $helpRooms, $user_id)) {
    header("Location: /AccountLogin.php");
    exit;
}
date_default_timezone_set("Europe/Stockholm");

$helpRoom = $dbContext->getHelpRooms(null, $roomId)[0];

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if ($_POST["formId"] !== "Done") {

        if (count($dbContext->IfUserInQueue($user_id, $roomId)) > 0) {
            $dbContext->removeFromQueue($user_id, $roomId);
            $message = "You left your queue in " . $helpRoom->name;


        } else {
            $date = date('Y-m-d H:i:s');
            $dbContext->addUserToQueue($date, $roomId, $user_id);
            $message = "You joined queue in " . $helpRoom->name;

        }

    } else {
        $queuePosId = $_POST["queuePosId"];
        $dbContext->HelpedStudent(false, $queuePosId);

    }


}
$helpList = $dbContext->getHelpQueue($roomId);

?>

<p>
<div class="row">

    <div class="col-md-12">
        <?php

        if (count($dbContext->IfUserInQueue($user_id, $roomId)) > 0) {
            ?>
            <form method="POST">
                <input type="submit" value="Leave Queue">
                <input type="hidden" name="formId" value="">

            </form>
            <?php
        } else {
            ?>
            <form method="POST">
                <input type="submit" value="Join Queue">
                <input type="hidden" name="formId" value="">

            </form>
            <?php
        }

        ?>
        <div class="newsletter">


            <div>
                <a href="inviteStudents.php?roomId=<?= $roomId ?>"> Invite students to <?= $helpRoom->name ?></a>
            </div>

            <p>You are in room <strong>&nbsp;<?= $helpRoom->name ?></strong></p>
            <p><?php echo $message;

            echo $dbContext->roomPermissions($roomId, $helpRooms, $user_id);

            ?></p>

            <section>
                <h2>Help List</h2>

                <?php
                foreach ($helpList as $helpPosition) {

                    ?>

                    <p><?= $helpPosition->givenname ?>     <?= $helpPosition->lastname ?></p>

                    <?php if ($user_id === $helpRoom->admin_user_id) {
                        ?>
                        <form method="POST">

                            <input type="submit" value="Done">
                            <input type="hidden" name="queuePosId" value="<?= $helpPosition->id ?>">
                            <input type="hidden" name="formId" value="Done">

                        </form>

                    <?php } ?>


                    <?php
                }
                ?>

            </section>



        </div>

    </div>
</div>





</p>