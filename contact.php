<?php
$title = ' || Contact';
require_once('template/header.php');
require_once('classes/Service.php');
require_once('includes/uploader.php');
require_once('config/database.php');

if (isset($_SESSION['contact_form'])) {
}
$s = new Service;
$s->taxRate = .05;

$stm = $mysqli->prepare("select id , name , price from services order by name");
$stm->execute();
$services = $stm->get_result()->fetch_all(MYSQLI_ASSOC);
?>
<?php if ($s->available) { ?>
    <h1>Contact Us </h1>
    <div class="card shadow p-4">
        <h2 class="text-center text-primary mb-4">نموذج التسجيل</h2>
        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">

            <div class="mb-3">
                <label for="name" class="form-label">الاسم الكامل</label>
                <input type="text" name="name" value="<?php if (isset($_SESSION['contact_form']['name'])) echo  $_SESSION['contact_form']['name'] ?>" class="form-control" id="name" placeholder="أدخل اسمك">
                <span class="text-danger"><?php echo $nameError ?></span>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">البريد الإلكتروني</label>
                <input type="email" name="email" value="<?php if (isset($_SESSION['contact_form']['email']))  echo  $_SESSION['contact_form']['email'] ?>" class="form-control" id="email" placeholder="example@email.com">
                <span class="text-danger"><?php echo $emailError ?></span>
            </div>

            <div class="mb-3">
                <label for="document">your document</label>
                <input type="file" name="document" class="form-control" id="file" placeholder="fail">
                <span class="text-danger"><?php echo $documentError ?></span>
            </div>
            <div class="form-group">
                <label for="services">Services </label>
                <select name="service_id" id="services" class="form-control">
                    <?php foreach ($services as $service) { ?>
                        <option value="<?php echo $service['id'] ?>">
                            <?php echo $service['name'] ?>
                            {<?php echo $s->totalprice($service['price']) ?>}SAR
                        </option>
                    <?php } ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="massage" class="form-label"></label>
                <textarea name="massage" class="form-control"><?php if (isset($_SESSION['contact_form']['massage'])) echo  $_SESSION['contact_form']['massage'] ?></textarea>
                <span class="text-danger"><?php echo $messageError ?></span>
            </div>
            <button class="btn btn-primary w-100 ">تسجيل</button>
        </form>


    </div>


<?php } ?>
<?php require_once('template/footer.php') ?>