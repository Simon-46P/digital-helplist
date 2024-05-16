<?php
require_once ('lib/PageTemplate.php');
require 'vendor/autoload.php';
require_once ('Models/Database.php');
require_once ('Utils/Validator.php');

# trick to execute 1st time, but not 2nd so you don't have an inf loop
if (!isset($TPL)) {
    $TPL = new PageTemplate();
    $TPL->PageTitle = "EduQ - Login";
    $TPL->ContentBody = __FILE__;
    include "layout.php";
    exit;
}

$dbContext = new DbContext();
$validator = new Validator($_POST);


$roomId = intval($_GET["roomId"]);

$user_id = $dbContext->getUsersDatabase()->getAuth()->getUserId();
$helpRoom = $dbContext->getHelpRooms(null, $roomId)[0];
if (!$dbContext->getUsersDatabase()->getAuth()->isLoggedIn() || $user_id !== $helpRoom->admin_user_id) {
    header("Location: /AccountLogin.php");
    exit;
}
date_default_timezone_set("Europe/Stockholm");
$message = "";
$username = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST["email"];
    $validator->field("email")->required()->email();

    if ($validator->is_valid()) {
        $newMemberId = $dbContext->getUserIdWithEmail($email)[0]->id ?? "0";


        $date = date('Y-m-d H:i:s');

        $message = "Added " . $email . " to class " . $helpRoom->name;
        !count($dbContext->getRoomAccessUserId($newMemberId, $roomId)) ? $dbContext->inviteUserToRoom($date, $newMemberId, $roomId) : $message = "Alredy added or have not registered to the website";
    } else {
        $message = "Wrong text format";

    }
}
?>

<p>
<div class="row">

    <div class="col-md-12">

        <div class="newsletter">

            <p>Invite students or teachers to room <strong>&nbsp;<?= $helpRoom->name ?></strong></p>
            <p><?php echo $message; ?></p>

            <section>
                <form method="POST">
                    <input type="text" name="email" placeholder="Eduq@gmail.com" class="input">
                    <button type="submit">Invite</button>
                </form>
            </section>



        </div>

    </div>
</div>





</p>