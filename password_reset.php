<?php
$title = ' || login';
require_once('template/header.php');
require_once('config/database.php');
require_once('config/app.php');

if (isset($_SESSION['logged_in'])) {
    header('location:index1.php');
    die();
}

$errors = [];
$email = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = mysqli_real_escape_string($mysqli, $_POST['email']);
    if (empty($email)) {
        array_push($errors, "Email is required");
    }

    if (!count($errors)) {
        $userExists = $mysqli->query("select id , email , name  from users where email='$email' limit 1");

        if ($userExists->num_rows) {
            $userid = $userExists->fetch_assoc()['id'];
            // اي توكن موجود في داتا بيس لنفس المستخدم نحذف 
            $tokenExists = $mysqli->query("delete from password_resets where user_id='$userid'");

            //random bytes تضهر ك باينري لا يمكن تخزينه في داتا بيس 
            //لهذا نضيف bin2hex تحوله ل سترنج او اسكي 
            $token = bin2hex(random_bytes(16));

            $expires_at = date('Y-m-d H:i:s', strtotime('+1 day'));

            $mysqli->query("insert into password_resets (user_id , token , expires_at)
      values('$userid', '$token' , '$expires_at');
      ");
            $chang_passwordUrl = $setting['app_url'] . 'change_password.php?token=' . $token;

            $headers = 'MIME-Version: 1.0' . "\r\n";
            //نوع الايميل 
            $headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
            $headers .= 'From: ' . $setting['admin_email'] . "\r\n" .
                'Reply-To: ' . $setting['admin_email'] . "\r\n" .
                'X-Mailer: PHP/' . phpversion();
            $htmlMessage = '<html><body>';
            $htmlMessage = '<p style="color:#ff0000;">' . $chang_passwordUrl . '</p>';
            $htmlMessage = '</html></body>';
            //مسح السشن من الفورم 
            // 
            //مسح بيانات المستخدم كامله
            mail($email, 'password reset link', $htmlMessage, $headers);
        }
        // اذا موجود
        $_SESSION['success_message'] = 'Please check your email for password reset link';
        header('location:password_reset.php');
        die();
    }
}

?>

<div id="password_reset ">
    <h3>Welcome back</h3>
    <h5 class="text-info">Fill in your email to reset your password</h5>
    <hr>
    <?php require_once('template/errors.php') ?>
    <form action="" method="post">

        <div class="form-group mb-3 ">
            <label for="email">Your Email :</label>
            <input type="email" name="email" class="form-control" placeholder="Your Email" id="email" value="<?php echo $email ?>">
        </div>

        <div class="form-group mb-3">
            <button class="btn btn-primary">Request Password reset link !</button>
        </div>

    </form>
</div>
<?php
require_once('template/footer.php');
?>