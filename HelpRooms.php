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
$helpRooms = $dbContext->getHelpRooms($user_id);

if (!$dbContext->getUsersDatabase()->getAuth()->isLoggedIn()) {
    header("Location: /AccountLogin.php");
    exit;
}

$message = "";
$username = "";



?>

<p>
<div class="row">
    <div class="col-md-12">
        <div class="newsletter">

            <p>Your<strong>&nbsp;Rooms</strong></p>
            <p><?php echo $message; ?></p>
            <section>
                <?php
                $lastId = null;
                foreach ($helpRooms as $helpRoom) {
                    if ($lastId === $helpRoom->id)
                        continue;
                    $lastId = $helpRoom->id;

                    ?>
                    <article>
                        <a href="HelpRoom.php?roomId=<?= $helpRoom->id ?>"
                            class="help__room__name <?php echo $helpRoom->admin_user_id === $user_id ? "room__admin" : "" ?>"><?= $helpRoom->name ?></a>
                    </article>
                    <?php
                }
                ?>
            </section>


        </div>

    </div>
</div>





</p>