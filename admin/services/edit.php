<?php
$title = 'Edit services';
$icon = 'cubes';
include __DIR__ . '/../template/header.php';

if(!isset($_GET['id']) || !$_GET['id'] ){
    die('Missing id parameter');
}
//update
$st=$mysqli->prepare("select *from services where id=? ");
$st->bind_param('i',$servicesId);
$servicesId=$_GET['id'];
$st->execute();

$service=$st->get_result()->fetch_assoc();

$name=$service['name'];
$description=$service['description'];
$price=$service['price'];
$errors=[];

if($_SERVER['REQUEST_METHOD'] == 'POST'){

   
    if (empty($_POST['name'])) {
        array_push($errors, "name is required");
    }
    if (empty($_POST['description'])) {
        array_push($errors, "Description is   required");
    }

     if (empty($_POST['price'])) {
        array_push($errors, "Price is   required");
    }


    if(!count($errors)){

    $st=$mysqli->prepare("update services set name = ? , description = ? ,price = ? where id = ?");
    $st->bind_param('ssii', $dbName, $dbDescription , $dbPrice, $dbId);
    $dbName=$_POST['name'];
    $dbDescription=$_POST['description'];
    $dbPrice=$_POST['price'];
    $dbId=$_GET['id'];
     
   
     try {
            $st->execute();
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

            <div class="form-group mb-3 pl-3">
                <button class="btn btn-success">Update</button>
            </div>

        </form>
    </div>
</div>
<?php
include __DIR__ . '/../template/footer.php';
