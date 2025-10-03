<?php
$title = 'Create product';
$icon = 'box';
include __DIR__ . '/../template/header.php';
require_once __DIR__ . '/../../classes/upload.php';

$name = '';
$description = '';
$price = '';
$errors = [];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $name = mysqli_real_escape_string($mysqli, $_POST['name']);
    $description = mysqli_real_escape_string($mysqli, $_POST['description']);
    $price = mysqli_real_escape_string($mysqli, $_POST['price']);



    $date = date('Ym');
    $upload = new Upload('rawah/p/' . $date);
    $upload->file = $_FILES['image'];
    $uploadResult = $upload->upload();

    // دمج أخطاء الرفع مع أخطاء الإدخال
    if (is_array($uploadResult)) {
        $errors = array_merge($errors, $uploadResult);
    }

    if (empty($name)) {
        array_push($errors, "Name is required");
    }
    if (empty($description)) {
        array_push($errors, "Description is   required");
    }
    if (empty($price)) {
        array_push($errors, "Price is required");
    }
    if (empty($_FILES['image']['name'])) {
        array_push($errors, 'Image is required');
    }

    if (empty($errors)) {
        $query = "INSERT INTO products (name, description, price, image) VALUES ('$name', '$description', '$price', '$upload->filePath')";
        try {
            $mysqli->query($query);
            echo "<script>location.href='index.php'</script>";
        } catch (mysqli_sql_exception $e) {
            $errors[] = $e->getMessage();
        }
    }
}

?>

<div class="card">
    <div class="content">
        <?php include __DIR__ . '/../template/errors.php'  ?>
        <form action="" method="post" enctype="multipart/form-data">

            <div class="form-group mb-3 pl-3 pr-3 mt-3">
                <label for="name"> Name :</label>
                <input type="text" name="name" class="form-control" placeholder=" name " id="name" value="<?php echo $name ?>">
            </div>

            <div class="form-group mb-3 pl-3 pr-3">
                <label for="description"> Description :</label>
                <textarea name="description" id="description" cols="30" rows="10" class="form-control"><?php echo $description ?></textarea>
            </div>

            <div class="form-group mb-3 pl-3 pr-3">
                <label for="price">Price :</label>
                <input type="number" name="price" class="form-control" id="price" value="<?php echo $price ?>">
            </div>

            <div class="form-group mb-3 pl-3 pr-3">
                <label for="price">Image :</label>
                <input type="file" name="image">
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