<?php

$title = 'Setting';
$icon = 'cog';
include __DIR__ . '/../template/header.php';
require_once __DIR__ . '/../../classes/user.php';

$user = new User;
if (!$user->isEditorClosed()) {
    die('You are not allowed to access this page');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $st = $mysqli->prepare("update setting set admin_email=? , app_name=?  where id = 1 ");
    $st->bind_param('ss', $dbEmail, $dbName);
    $dbEmail = $_POST['admin_email'];
    $dbName = $_POST['app_name'];
    $st->execute();

    echo "<script>location.href='index.php'</script>";
}
?>
<div class="card">
    <div class="content">
        <h3 class=" mb-3 pl-3 pr-3 mt-3">Update setting</h3>
        <form action="" method="post">

            <div class="form-group mb-3 pl-3 pr-3 mt-3">
                <label for="app_name"> Application name :</label>
                <input type="text" name="app_name" class="form-control" id="app_name" value="<?php echo $config['app_name'] ?>">
            </div>
            <div class="form-group mb-3 pl-3 pr-3 mt-3">
                <label for="admin_email"> Admin email :</label>
                <input type="email" name="admin_email" class="form-control" id="admin_email" value="<?php echo $config['admin_email'] ?>">
            </div>
            <div class="form-group mb-3 pl-3 pr-3 mt-3">
                <button class="btn btn-success">Update</button>
            </div>

        </form>
    </div>
</div>

<?php
include __DIR__ . '/../template/footer.php';
