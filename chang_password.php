<?php
$title = ' || change password';
require_once('template/header.php');
require_once('config/database.php');
require_once('config/app.php');

if (isset($_SESSION['logged_in'])) {
    header('location:index1.php');
    die();
}
if (!isset($_GET['token']) || !$_GET['token']) {
    die('Token prameter is missing');
}
//التحقق من التوكن اذا موجوده و متاحه
//نقارن الوقت الحالي مع تاريخ الانتهاء
$now = date('Y-m-d H:i:s');
$stmt = $mysqli->prepare("select *from password_resets where token=? and expires_at>'$now'");
$stmt->bind_param('s', $token);
$token = $_GET['token'];
$stmt->execute();

$result = $stmt->get_result();
//اذا ما يوجد نتيجه
if (!$result->num_rows) {
    die('Token is not valid');
}
$errors = [];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //mysqli_real_escape_string هذه الداله تعمل ع تنظيفهم كامل مافي داعي ل prepare statement
    $password = mysqli_real_escape_string($mysqli, $_POST['password']);
    $password_confirm = mysqli_real_escape_string($mysqli, $_POST['password_confirmation']);

    if (empty($password)) {
        array_push($errors, "password is required");
    }
    if (empty($password_confirm)) {
        array_push($errors, "pssword confirmation is required");
    }
    if ($password != $password_confirm) {
        array_push($errors, "password don't match");
    }

    if (!count($errors)) {
        // تحديث الباسوورد حق المستخدم  
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $userid = $result->fetch_assoc()['user_id'];
        $mysqli->query("update users set password='$hash' where id=$userid");
        // حذف التوكن 
        $mysqli->query("delete from password_resets where user_id ='$userid'");

        $_SESSION['success_message'] = 'Your password has been changed , please log in ';
        header('location:login.php');
        die();
    }
}

?>

<div id="password_reset ">
    <h3>Create a new password</h3>
    <hr>
    <?php require_once('template/errors.php') ?>
    <form action="" method="post">

        <div class="form-group mb-3">
            <label for="password">New Password :</label>
            <input type="password" name="password" class="form-control" placeholder="Your new password" id="password">
        </div>
        <div class="form-group mb-3">
            <label for="password_confirmation">Confirm Password :</label>
            <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm Your password" id="password_confirmation">
        </div>

        <div class="form-group mb-3">
            <button class="btn btn-primary">Change Password reset link !</button>
        </div>

    </form>
</div>
<?php
require_once('template/footer.php');
?>