<?php
require_once ('lib/PageTemplate.php');
require_once ('vendor/autoload.php');
require_once ('Models/Database.php');
require_once ('Utils/Validator.php');

if (!isset($TPL)) {
    $TPL = new PageTemplate();
    $TPL->PageTitle = "EduQ - Edit Profile";
    $TPL->ContentBody = __FILE__;
    include "layout.php";
    exit;
}

ob_start();
$dbContext = new DbContext();
$message = "";
$userData = [];

$userData = $dbContext->getUserDetails($_SESSION['auth_user_id']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $givenName = $_POST['givenname'];
    $lastname = $_POST["lastname"];
    $street = $_POST['street'];
    $city = $_POST['city'];
    $zip = $_POST['zip'];
    $role = $_POST['role'];
    try {
        $dbContext->updateUser($_SESSION['auth_user_id'], $givenName, $lastname, $street, $city, $zip, $role);
        $message = "Profile updated successfully!";
        header("Location: ManageAccount.php");
        exit;
    } catch (Exception $e) {
        $message = "Error updating profile: " . $e->getMessage();
    }
}
?>

<p>

<div class="row">
    <div class="col-md-12">
        <div class="newsletter">
            <p><strong>Edit Profile</strong></p>
            <form method="post" action="ManageAccount.php">
                <input class="input" type="text" placeholder="Name" name="givenname"
                    value="<?php echo isset($userData['givenname']) ? $userData['givenname'] : ''; ?>">
                <br /><br />
                <input class="input" type="text" placeholder="Lastname" name="lastname"
                    value="<?php echo isset($userData['lastname']) ? $userData['lastname'] : ''; ?>">

                <br /><br />
                <input class="input" type="text" placeholder="Street Address" name="street"
                    value="<?php echo isset($userData['street']) ? $userData['street'] : ''; ?>">
                <br /><br />
                <input class="input" type="text" placeholder="City" name="city"
                    value="<?php echo isset($userData['city']) ? $userData['city'] : ''; ?>">
                <br /><br />

                <input class="input" type="text" placeholder="Postal Code" name="zip"
                    value="<?php echo isset($userData['zip']) ? $userData['zip'] : ''; ?>">

                <br /><br />
                <div class="radio-container">
                    <div class="radio-input">
                        <input type="radio" id="student" name="role" value="student" <?php if (isset($userData['accountrole']) && $userData['accountrole'] == 'student')
                            echo 'checked'; ?>>
                        <label for="student">Student</label>
                    </div>
                    <div class="radio-input">
                        <input type="radio" id="teacher" name="role" value="teacher" <?php if (isset($userData['accountrole']) && $userData['accountrole'] == 'teacher')
                            echo 'checked'; ?>>
                        <label for="teacher">Teacher</label>
                    </div>
                </div>


                <br /><br />
                <button class="newsletter-btn" type="submit"><i class="fa fa-save"></i> Save Changes</button>
            </form>
            <?php
            if (!empty($message)) {
                echo '<p>' . $message . '</p>';
            }
            ?>
        </div>
    </div>
</div>
</p>