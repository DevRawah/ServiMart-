<?php
$title = ' || Home page';
require_once('template/header.php');
require_once('classes/Service.php');
require_once('classes/product.php');
require_once('config/app.php');
require_once('config/database.php');

$Service = new Service;
$productObj = new Product;
$productObj->taxRate = .05;

?>
<?php if ($Service->available) {

?>
  <h1>Start shopping </h1>
  <?php $products = $mysqli->query("select * from products ")->fetch_all(MYSQLI_ASSOC); ?>
  <div class="row">
    <?php foreach ($products as  $product) { ?>
      <div class="col-md-4">
        <div class="card mb-3">
          <div class="custom-card-image" style="background-image: url('<?php echo $setting['app_url'] . $product['image'] ?>') "> </div>
          <div class="card-body">
            <div class="card-title"> <?php echo $product['name'] ?></div>
            <div> <?php echo $product['description'] ?></div>
            <div class="text-success pb-3"><?php echo $productObj->totalprice($product['price']) ?> SAR</div>

            <a href="#" class="btn btn-primary">اطلب الان</a>
          </div>
        </div>
      </div>
    <?php } ?>
  </div>
<?php
  $mysqli->close();
}

require_once('template/footer.php'); ?>
</div>