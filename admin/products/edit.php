<?php
$title = 'Edit product';
$icon = 'box';
include __DIR__ . '/../template/header.php';
require_once __DIR__ . '/../../classes/upload.php';

if (!isset($_GET['id']) || !$_GET['id']) {
    die('Missing id parameter');
}

// استرجاع بيانات المنتج
$productId = $_GET['id'];
$st = $mysqli->prepare("SELECT * FROM products WHERE id = ?");
$st->bind_param('i', $productId);
$st->execute();
$product = $st->get_result()->fetch_assoc();

$name = $product['name'];
$description = $product['description'];
$price = $product['price'];
$image = $product['image']; // الصورة القديمة
$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $dbName = $_POST['name'];
    $dbDescription = $_POST['description'];
    $dbPrice = $_POST['price'];
    $dbImage = $image; // نبدأ بالصورة القديمة
    $dbId = $productId;

    // التحقق من المدخلات
    if (empty($dbName)) {
        array_push($errors, "Name is required");
    }
    if (empty($dbDescription)) {
        array_push($errors, "Description is   required");
    }
    if (empty($dbPrice)) {
        array_push($errors, "Price is   required");
    }

    // رفع صورة جديدة إن وُجدت
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $upload = new Upload('uploads/p');
        $upload->file = $_FILES['image'];
        $uploadResult = $upload->upload();

        if ($uploadResult === true) {
            // حذف الصورة القديمة
            $oldImagePath = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . $image;
            if (!empty($image) && file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }
            // تعيين الصورة الجديدة
            $dbImage = $upload->filePath;
        } elseif (is_array($uploadResult)) {
            $errors = array_merge($errors, $uploadResult);
        }
    }

    // تنفيذ التحديث
    if (empty($errors)) {
        $st = $mysqli->prepare("UPDATE products SET name = ?, description = ?, price = ?, image = ? WHERE id = ?");
        $st->bind_param('ssdsi', $dbName, $dbDescription, $dbPrice, $dbImage, $dbId);

        try {
            $st->execute();
            echo "<script>location.href='index.php'</script>";
        } catch (mysqli_sql_exception $e) {
            $errors[] = $e->getMessage();
        }
    }
}
?>

<!-- واجهة النموذج -->
<div class="card">
    <div class="content">
        <?php include __DIR__ . '/../template/errors.php'; ?>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="form-group mb-3 pl-3 pr-3 mt-3">
                <label for="name">Name:</label>
                <input type="text" name="name" class="form-control" id="name" value="<?php echo htmlspecialchars($name); ?>">
            </div>

            <div class="form-group mb-3 pl-3 pr-3">
                <label for="description">Description:</label>
                <textarea name="description" id="description" class="form-control"><?php echo htmlspecialchars($description); ?></textarea>
            </div>

            <div class="form-group mb-3 pl-3 pr-3">
                <label for="price">Price:</label>
                <input type="number" name="price" class="form-control" id="price" value="<?php echo htmlspecialchars($price); ?>">
            </div>

            <div class="form-group mb-3 pl-3 pr-3">
                <label>Current Image:</label><br>
                <?php if (!empty($image) && file_exists($_SERVER['DOCUMENT_ROOT'] . '/' . $image)): ?>
                    <img src="/<?php echo $image ?>" width="150" alt="Product Image"><br><br>
                <?php else: ?>
                    <p>لا توجد صورة حالية</p>
                <?php endif; ?>
                <label for="image">Upload New Image:</label>
                <input type="file" name="image" id="image">
            </div>

            <div class="form-group mb-3 pl-3">
                <button class="btn btn-success">Update</button>
            </div>
        </form>
    </div>
</div>

<?php include __DIR__ . '/../template/footer.php'; ?>