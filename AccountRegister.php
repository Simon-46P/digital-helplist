

<?php
require_once('lib/PageTemplate.php');
require_once( 'vendor/autoload.php');
require_once('Models/Database.php');
require_once('Utils/Validator.php');
# trick to execute 1st time, but not 2nd so you don't have an inf loop
if (!isset($TPL)) {
    $TPL = new PageTemplate();
    $TPL->PageTitle = "EduQ - Register";
    $TPL->ContentBody = __FILE__;
    include "layout.php";
    exit;
}




$dbContext = new DbContext();
$message = "";
$username ="";
$registeredOk = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $validator = new Validator($_POST);

    $validator->field('username', 'Email')
        ->required()
        ->email();

    $validator->field('password', 'Password')
        ->required()
        ->min_len(8);

    $validator->field('password-confirmation', 'Password Confirmation')
        ->required()
        ->equals($_POST['password']);

    $validator->field('givenname', 'Name')
        ->required();

    if ($validator->is_valid()) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $GivenName = $_POST['givenname'];
        $Street = $_POST['street'];
        $Zip = $_POST['zip'];
        $City = $_POST['city'];

        try {
            $user_id = $dbContext->getUsersDatabase()->getAuth()->register($username, $password, $username);

            $dbContext->addUser($GivenName, $Street, $City, $Zip, $user_id);

            $registeredOk = true;
            $message = "Registration successful!";
        } catch (\Delight\Auth\InvalidEmailException $e) {
            $message = "Invalid email format";
        } catch (\Delight\Auth\InvalidPasswordException $e) {
            $message = "Invalid password";
        } catch (\Delight\Auth\UserAlreadyExistsException $e) {
            $message = "User already exists";
        } catch (\Delight\Auth\TooManyRequestsException $e) {
            $message = "Too many registration attempts. Please try again later.";
        } catch (\Delight\Auth\AttemptCancelledException $e) {
            $message = "Registration attempt cancelled.";
        } catch (\Delight\Auth\AuthError $e) {
            $message = "Authentication error: " . $e->getMessage();
        }catch (\Exception $e) {
            $message = "An error occurred during registration: " . $e->getMessage();
        }
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
                <p><strong>User Registration</strong></p>
                <form method="post" action="AccountRegister.php">
                    <input class="input" type="email" placeholder="Enter Your Email" name="username" value="<?php echo isset($_POST['username']) ? $_POST['username'] : ''; ?>">
                    <br/><br/>
                    <input class="input" type="password" placeholder="Enter Your Password" name="password">
                    <br/><br/>
                    <input class="input" type="password" placeholder="Repeat Password" name="password-confirmation">
                    <br/><br/>
                    <input class="input" type="text" placeholder="Name" name="givenname" value="<?php echo isset($_POST['givenname']) ? $_POST['givenname'] : ''; ?>">
                    <br/><br/>
                    <input class="input" type="text" placeholder="Street Address" name="street" value="<?php echo isset($_POST['street']) ? $_POST['street'] : ''; ?>">
                    <br/><br/>
                    <input class="input" type="text" placeholder="Postal Code" name="zip" value="<?php echo isset($_POST['zip']) ? $_POST['zip'] : ''; ?>">
                    <br/><br/>
                    <input class="input" type="text" placeholder="City" name="city" value="<?php echo isset($_POST['city']) ? $_POST['city'] : ''; ?>">
                    <br/><br/>
                    <button class="newsletter-btn" type="submit"><i class="fa fa-envelope"></i> Register</button>
                </form>
                <?php
                if (isset($validationErrors)) {
                    echo '<p>' . $messages . '</p>';
                    echo '<ul>';
                    foreach ($validationErrors as $error) {
                        echo '<li>' . $error . '</li>';
                    }
                    echo '</ul>';
                }
                else {
                    echo '<p>' . $message . '</p>';
                }
                ?>
            </div>
        </div>
    </div>
</p>