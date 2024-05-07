<?php
require_once ('lib/PageTemplate.php');
require_once ('vendor/autoload.php');
require_once ('Models/Database.php');
require_once ('Utils/Validator.php');
# trick to execute 1st time, but not 2nd so you don't have an inf loop
if (!isset($TPL)) {
    $TPL = new PageTemplate();
    $TPL->PageTitle = "EduQ - Register";
    $TPL->ContentBody = __FILE__;
    include "layout.php";
    exit;
}
ob_start();


$dbContext = new DbContext();
$message = "";
$username = "";
$registeredOk = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $validator = new Validator($_POST);

    $validator->field('queueName')
        ->required()
        ->min_len(3)->max_len(12);


    if ($validator->is_valid()) {
        $username = $_POST['queueName'];
        $date = date('Y-m-d H:i:s');
        $userId = $dbContext->getUsersDatabase()->getAuth()->getUserId();

        $dbContext->createRoomQueue($username, $date, $userId);
        header("Location: /HelpRooms.php");

    } else {
        $validationErrors = $validator->error_messages;
        $messages = "Please correct the following errors:";
    }
}
?>

<p>
<div class="row">
    <div class="col-md-12">
        <div class="newsletter">
            <p><strong>Create Room</strong></p>
            <form method="post">
                <input class="input" type="text" placeholder="Enter your room name" name="queueName"
                    value="<?php echo isset($_POST['queueName']) ? $_POST['queueName'] : ''; ?>">
                <br /><br />
                <button class="newsletter-btn" type="submit"><i class="fa-solid fa-plus"></i>Create Queue Room</button>
            </form>
            <?php
            if (isset($validationErrors)) {
                echo '<p>' . $messages . '</p>';
                echo '<ul>';
                foreach ($validationErrors as $error) {
                    echo '<li>' . $error . '</li>';
                }
                echo '</ul>';
            } else {
                echo '<p>' . $message . '</p>';
            }
            ?>
        </div>
    </div>
</div>
</p>