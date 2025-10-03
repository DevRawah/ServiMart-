<?php
$title = 'Products';
$icon = 'box';
include __DIR__ . '/../template/header.php';
$products = $mysqli->query('select * from products order by id ')->fetch_all(MYSQLI_ASSOC);

//delete
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $st = $mysqli->prepare("delete from products where id=?");
    $st->bind_param('i', $productId);
    $productId = $_POST['product_id'];
    $st->execute();
    if ($_POST['image']) {
        unlink($_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . $_POST['image']);
    }
    echo "<script>location.href='index.php'</script>";
}
?>
<div class="card">
    <div class="content">

        <a href="create.php" class="btn btn-success ml-3 mb-3 mt-3">Create a new product </a>
        <p class="ml-3"> Products : <?php echo count($products) ?></p>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th> #</th>
                        <th>Name</th>
                        <th>description</th>
                        <th>Price</th>
                        <th>Image</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $product): ?>
                        <tr>
                            <td> <?php echo $product['id'] ?></td>
                            <td><?php echo $product['name'] ?></td>
                            <td><?php echo $product['description'] ?></td>
                            <td><?php echo $product['price'] ?></td>
                            <td><img src="<?php echo $setting['app_url'] . '/' . $product['image']  ?>" width="50"></td>


                            <td style="display: flex; gap: 5px; align-items: center;">
                                <a href="edit.php?id=<?php echo $product['id'] ?>" class="btn btn-warning">Edit</a>

                                <form action="" method="post" style="margin: 0;">

                                    <input type="hidden" name="product_id" value="<?php echo $product['id'] ?>">
                                    <input type="hidden" name="image" value="<?php echo $product['image'] ?>">
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
