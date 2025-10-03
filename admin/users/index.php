<?php
$title = 'Users';
$icon = 'users';
include __DIR__ . '/../template/header.php';
require_once __DIR__ . '/../../classes/user.php';

$user = new User;
if (!$user->isEditorClosed()) {
    die('You are not allowed to access this page');
}

$users = $mysqli->query('select * from users order by id ')->fetch_all(MYSQLI_ASSOC);
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $st = $mysqli->prepare("delete from users where id=?");
    $st->bind_param('i', $userid);
    $userid = $_POST['user_id'];
    $st->execute();
    echo "<script>location.href='index.php'</script>";
}
?>
<div class="card">
    <div class="content">

        <a href="create.php" class="btn btn-success ml-3 mb-3 mt-3">Create a new user </a>
        <p class="ml-3"> Users: <?php echo count($users) ?></p>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th> #</th>
                        <th>Email</th>
                        <th>Name</th>
                        <th>Role</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td> <?php echo $user['id'] ?></td>
                            <td><?php echo $user['email'] ?></td>
                            <td><?php echo $user['name'] ?></td>
                            <td><?php echo $user['role'] ?></td>


                            <td style="display: flex; gap: 5px; align-items: center;">
                                <a href="edit.php?id=<?php echo $user['id'] ?>" class="btn btn-warning">Edit</a>

                                <form action="" method="post" style="margin: 0;">
                                    <input type="hidden" name="user_id" value="<?php echo $user['id'] ?>">
                                    <button onclick="return confirm('You are sure?')" type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php
include __DIR__ . '/../template/footer.php';
