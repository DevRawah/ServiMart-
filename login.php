<?php
$title = ' || login';
require_once('template/header.php');
require_once('config/database.php');
require_once('config/app.php');
require_once 'classes/user.php';

$user = new User;
if ($user->isLogged()) {
    header('location:index1.php');
    die();
}
$errors = [];
$email = '';
$password = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = mysqli_real_escape_string($mysqli, $_POST['email']);
    $password = mysqli_real_escape_string($mysqli, $_POST['password']);

    if (empty($email)) {
        array_push($errors, "Email is required");
    }
    if (empty($password)) {
        array_push($errors, "password is required");
    }

    if (!count($errors)) {
        $userExists = $mysqli->query("select * from users where email='$email' limit 1");

        if (!$userExists->num_rows) {
            array_push($errors, "Your email , $email does not exists in our records");
        }
        // اذا موجود
        else {
            // يعطينا الباسوورد الصح
            $foundUser = $userExists->fetch_assoc();

            //عمليه المقارنه مع الباسوورد الموجود في داتا بيس باستخدام password_verify
            if (password_verify($password, $foundUser['password'])) {

                $_SESSION['logged_in'] = true;
                $_SESSION['user_id'] = $foundUser['id'];
                $_SESSION['user_name'] = $foundUser['name'];
                $_SESSION['user_role'] = $foundUser['role'];

                if ($foundUser['role'] == 'admin') {
                    header('location:admin');
                } elseif ($foundUser['role'] == 'editor') {
                    header('location:admin');
                } else {
                    $_SESSION['success_message'] = "Welcome back , $foundUser[name] ";
                    header('location:index1.php');
                    die();
                }
            } else {
                array_push($errors, 'warning credentials');
            }
        }
    }
}
?>

<div id="login  ">
    <h3>Welcome back</h3>
    <h5 class="text-info">Please Fill the form below to login</h5>
    <hr>
    <?php require_once('template/errors.php') ?>
    <form action="" method="post">

        <div class="form-group mb-3 ">
            <label for="email">Your Email :</label>
            <input type="email" name="email" class="form-control" placeholder="Your Email" id="email" value="<?php echo $email ?>">
        </div>

        <div class="form-group mb-3">
            <label for="password">Your Password :</label>
            <input type="password" name="password" class="form-control" placeholder="Your password" id="password" value="<?php echo $password ?>">
        </div>

        <div class="form-group mb-3">
            <button class="btn btn-success">login!</button>
            <a href="password_reset.php">Forget your password</a>
        </div>

    </form>
</div>
<?php
require_once('template/footer.php');
?>