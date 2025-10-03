<?php

$title = 'Create user';
$icon = 'users';
include __DIR__ . '/../template/header.php';
?>
<?php

$errors = [];
$email = '';
$name = '';
$role = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $email = mysqli_real_escape_string($mysqli, $_POST['email']);
    $name = mysqli_real_escape_string($mysqli, $_POST['name']);
    $password = mysqli_real_escape_string($mysqli, $_POST['password']);
    $role = mysqli_real_escape_string($mysqli, $_POST['role']);

    if (empty($email)) {
        array_push($errors, "Email is required");
    }
    if (empty($name)) {
        array_push($errors, "name is required");
    }
    if (empty($password)) {
        array_push($errors, "password is required");
    }
    if (empty($role)) {
        array_push($errors, "Role is   required");
    }

    //create a new user

    if (!count($errors)) {
        $password = password_hash($password, PASSWORD_DEFAULT);
        $query = "insert into users ( email , name, password , role) values('$email','$name','$password' ,'$role')";

        //handel mysql errors

        try {
            $mysqli->query($query);
            echo "<script>location.href='index.php' </script>";
        } catch (mysqli_sql_exception $e) {
            array_push($errors, $e->getMessage()); // هذا يكتب الخطأ تلقائيًا من نفسه
        }
    }
}
?>

<div class="card">
    <div class="content">
        <?php include __DIR__ . '/../template/errors.php'  ?>
        <form action="" method="post">

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

                </select>

            </div>

            <div class="form-group mb-3 pl-3">
                <button class="btn btn-success">Create</button>
            </div>

        </form>
    </div>
</div>
<?php
include __DIR__ . '/../template/footer.php';
?>