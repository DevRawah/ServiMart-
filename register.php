<?php
$title = ' || Register';
require_once('template/header.php');
require_once('config/database.php');
require_once('config/app.php');
// التجقق من المستخدم اذا موجود
if (isset($_SESSION['logged_in'])) {
    header('location:index1.php');
    die();
}
$errors = [];
$name = '';
$email = '';
$password = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //mysqli_real_escape_string هذه الداله تعمل ع تنظيفهم كامل مافي داعي ل prepare statement
    $email = mysqli_real_escape_string($mysqli, $_POST['email']);
    $name = mysqli_real_escape_string($mysqli, $_POST['name']);
    $password = mysqli_real_escape_string($mysqli, $_POST['password']);
    $password_cinfirm = mysqli_real_escape_string($mysqli, $_POST['password_confirmation']);

    if (empty($email)) {
        array_push($errors, "Email is required");
    }
    if (empty($name)) {
        array_push($errors, "name is required");
    }
    if (empty($password) || strlen($password) < 5) {
        array_push($errors, "password is required ");
    }
    if (empty($password_cinfirm)) {
        array_push($errors, "password confirmation is required");
    }

    if ($password != $password_cinfirm) {
        array_push($errors, "password don't match");
    }
    //التحقق من اليوسر مو موجود في database
    if (!count($errors)) {
        $userExists = $mysqli->query("select id, email from users where email='$email' limit 1");
        if ($userExists->num_rows) {
            array_push($errors, "Email already registered");
        }
    }

    //create a new user
    if (!count($errors)) {
        $password = password_hash($password, PASSWORD_DEFAULT);
        $query = "insert into users ( email , name, password) values('$email','$name','$password')";
        $mysqli->query($query);
        //تسجيل دخول نستخدم session
        $_SESSION['logged_in'] = true;
        $_SESSION['user_id'] = $mysqli->insert_id;
        $_SESSION['user_name'] = $name;
        $_SESSION['success_message'] = "Welcome to our website $name";

        header('location:index1.php');
        die();
    }
}
?>

<div id="register">
    <h3>Welcome to our Website</h3>
    <h5 class="text-info">Please Fill the form below to register a new account </h5>
    <hr>
    <?php require_once('template/errors.php') ?>
    <form action="" method="post">

        <div class="form-group mb-3 ">
            <label for="email">Your Email :</label>
            <input type="email" name="email" class="form-control" placeholder="Your Email" id="email" value="<?php echo $email ?>">
        </div>

        <div class="form-group mb-3">
            <label for="name">Your Name :</label>
            <input type="text" name="name" class="form-control" placeholder="Your name " id="name" value="<?php echo $name ?>">
        </div>

        <div class="form-group mb-3">
            <label for="password">Your Password :</label>
            <input type="password" name="password" class="form-control" placeholder="Your password" id="password" value="<?php echo $password ?>">
        </div>

        <div class="form-group mb-3">
            <label for="password_confirmation">Confirm Password :</label>
            <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm Your password" id="password_confirmation">
        </div>

        <div class="form-group mb-3">
            <button class="btn btn-success">Register!</button>
            <a href="login.php">Already have an account ? login here</a>
        </div>

    </form>
</div>
<?php
require_once('template/footer.php');
?>