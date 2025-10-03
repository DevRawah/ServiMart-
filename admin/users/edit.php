<?php
$title = 'Edit user';
$icon = 'users';
include __DIR__ . '/../template/header.php';

if (!isset($_GET['id']) || !$_GET['id']) {
    die('Missing id parameter');
}
$st = $mysqli->prepare("select *from users where id=? ");
$st->bind_param('i', $userid);
$userid = $_GET['id'];
$st->execute();

$user = $st->get_result()->fetch_assoc();

$name = $user['name'];
$email = $user['email'];
$role = $user['role'];
$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (empty($_POST['email'])) {
        array_push($errors, "Email is required");
    }
    if (empty($_POST['name'])) {
        array_push($errors, "name is required");
    }
    if (empty($_POST['role'])) {
        array_push($errors, "Role is   required");
    }
    if (!count($errors)) {

        $st = $mysqli->prepare("update users set name = ? , email = ? ,role = ?, password = ?  where id = ?");
        $st->bind_param('ssssi', $dbName, $dbEmail, $dbRole, $dbRassword, $dbId);
        $dbName = $_POST['name'];
        $dbEmail = $_POST['email'];
        $dbRole = $_POST['role'];
        $_POST['password'] ? $dbPassword = password_hash($_POST['password'], PASSWORD_DEFAULT) : $dbpassword = $user['password'];
        $dbId = $_GET['id'];

        try {
            $st->execute();
            echo "<script>location.href='index.php' </script>";
        } catch (mysqli_sql_exception $e) {
            array_push($errors, $e->getMessage()); // هذا يكتب الخطأ تلقائيًا من نفسه
        }
    }
}
?>
<div class="card">
    <div class="content">
        <form action="" method="post">
            <?php include __DIR__ . '/../template/errors.php'  ?>

            <div class="form-group mb-3 pl-3 pt-4 pr-3">
                <label for="email">Your Email :</label>
                <input type="email" name="email" class="form-control" placeholder="Your Email" id="email" value="<?php echo $email ?>">
            </div>

            <div class="form-group mb-3 pl-3 pr-3">
                <label for="name">Your Name :</label>
                <input type="text" name="name" class="form-control" placeholder="Your name " id="name" value="<?php echo $name ?>">
            </div>

            <div class="form-group mb-3 pl-3 pr-3">
                <label for="password">Your Password :</label>
                <input type="password" name="password" class="form-control" placeholder="Your password" id="password" value="<?php ?>">
            </div>
            <div class="form-group mb-3 pl-3 pr-3">
                <label for="role"> Role:</label>
                <select name="role" id="role" class="form-control">
                    <option value="user"
                        <?php if ($role == 'user') echo 'selected' ?>>User </option>
                    <option value="admin"
                        <?php if ($role == 'admin') echo 'selected' ?>>Admin </option>
                    <option value="editor"
                        <?php if ($role == 'editor') echo 'selected' ?>>Editor </option>

                    <select name="role" id="role" class="form-control">
                    </select>

            </div>

            <div class="form-group mb-3 pl-3">
                <button class="btn btn-success">Update</button>
            </div>

        </form>
    </div>
</div>
<?php
include __DIR__ . '/../template/footer.php';
