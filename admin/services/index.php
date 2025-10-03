<?php

$title = 'Services';
$icon = 'cubes';
include __DIR__ . '/../template/header.php';
$services = $mysqli->query('select * from services order by id ')->fetch_all(MYSQLI_ASSOC);

//delete
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $st = $mysqli->prepare("delete from services where id=?");
    $st->bind_param('i', $serviceId);
    $serviceId = $_POST['service_id'];
    $st->execute();
    echo "<script>location.href='index.php'</script>";
}
?>
<div class="card">
    <div class="content">

        <a href="create.php" class="btn btn-success ml-3 mb-3 mt-3">Create a new Service </a>
        <p class="ml-3"> Services : <?php echo count($services) ?></p>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th> #</th>
                        <th>Name</th>
                        <th>description</th>
                        <th>Price</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($services as $service): ?>
                        <tr>
                            <td> <?php echo $service['id'] ?></td>
                            <td><?php echo $service['name'] ?></td>
                            <td><?php echo $service['description'] ?></td>
                            <td><?php echo $service['price'] ?></td>


                            <td style="display: flex; gap: 5px; align-items: center;">
                                <a href="edit.php?id=<?php echo $service['id'] ?>" class="btn btn-warning">Edit</a>

                                <form action="" method="post" style="margin: 0;">
                                    <input type="hidden" name="service_id" value="<?php echo $service['id'] ?>">
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
