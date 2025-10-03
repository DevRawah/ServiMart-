<?php
$title = ' || Messages page';
require_once('template/header.php');
require_once('config/database.php');
require_once('config/app.php');
require_once('classes/user.php');
$user = new User;
if (!$user->isAdmin()) {
    die('no accesses dis page');
}

$st = $mysqli->prepare("select * , m.id as message_id ,
s.id as service_id from messages m 
left join services s
on m.service_id=s.id
order by m.id limit ?");

$st->bind_param('i', $limit);

isset($_GET['limit']) ? $limit = $_GET['limit'] : $limit = 10;
$st->execute();
$messages = $st->get_result()->fetch_all(MYSQLI_ASSOC);

if (!isset($_GET['id'])) {
?>
    <h2>Received Messsages</h2>
    <div class="table-responsive">
        <table class="table table-hover table-striped">
            <thead>
                <tr>
                    <th> # </th>
                    <th>Sender Name</th>
                    <th> Sender Email </th>
                    <th>Service </th>
                    <th> Document </th>
                    <th> Action </th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($messages as $message) {
                ?>
                    <tr>
                        <td><?php echo $message['message_id'] ?> </td>
                        <td><?php echo $message['contact_name'] ?> </td>
                        <td><?php echo $message['email'] ?> </td>
                        <td><?php echo $message['name'] ?> </td>
                        <td><?php echo $message['document'] ?> </td>
                        <td>
                            <a href="?id=<?php echo $message['message_id'] ?>" class="btn btn-primary">View</a>
                            <form onsubmit="return confirm('Are you sure?') " action="" method="post" style="display: inline-block">
                                <input type="hidden" name="message_id" value="<?php echo $message['message_id'] ?>">
                                <button class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php }
                ?>
            </tbody>
        </table>
    </div>
<?php
} else {

    $messageQuery = $mysqli->prepare("select *from messages m
    left join services s
    on m.service_id=s.id
    where m.id=? limit 1");
    $messageQuery->bind_param('i', $id);
    $id = $_GET['id'];
    $messageQuery->execute();
    $message = $messageQuery->get_result()->fetch_array(MYSQLI_ASSOC);
?>
    <div class="card">
        <h5 class="card-header">
            Message from:<?php echo $message['contact_name'] ?>
            <div class="small"><?php echo $message['email'] ?></div>
        </h5>
        <div class="card-body">
            <div>Service: <?php if ($message['name']) {
                                echo $message['name'];
                            } else {
                                echo  'No Service';
                            }
                            ?></div>
            <?php echo $message['message'] ?>

        </div>
        <!-- فتح الملف  -->
        <?php if ($message['document']) { ?>
            <div class="card-footer">
                Attachment :<a href="<?php
                                        echo $setting['app_url']
                                            . $setting['upload_dir']
                                            . $message['document'];  ?>">Download attachment</a>
            </div>
        <?php } ?>
    </div>
<?php }

if (isset($_POST['message_id'])) {
    $st = $mysqli->prepare("delete from messages where id=?");
    $st->bind_param('i', $messageid);
    $messageid = $_POST['message_id'];
    $st->execute();

    echo "<script>
location.href ='messages.php' </script>";
}
require_once('template/footer.php');
