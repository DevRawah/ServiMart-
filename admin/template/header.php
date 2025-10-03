<html lang="en">
<?php
/*session_start();
//اتحقق من وظيفه المستخدم الشرط الاول انه اليور مش موجود اطلاقا و الثاني اذا موجوده ولكن ليست ادمن
if (!isset($_SESSION['user_role']) || !in_array($_SESSION['user_role'], ['admin', 'editor'])) {
    die('You are not allowed to access this page');
}*/

session_start();
require_once __DIR__ . '/../../config/app.php';
require_once __DIR__ . '/../../classes/user.php';

$user = new User;
if (!$user->isAdmin()) {
    die('You are not allowed to access this page');
}
?>
<?php require_once __DIR__ . '/../../config/database.php' ?>

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href=".<?php echo $setting['admin_assets'] ?>/img/apple-icon.png">
    <link rel="icon" type="image/png" href="<?php echo $setting['admin_assets'] ?>/img/favicon.ico">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title><?php echo $setting['app_name'] ?></title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" />
    <!-- CSS Files -->
    <link href="<?php echo $setting['admin_assets'] ?>/css/bootstrap.min.css" rel="stylesheet" />
    <link href="<?php echo $setting['admin_assets'] ?>/css/light-bootstrap-dashboard.css?v=2.0.0 " rel="stylesheet" />
    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link href="<?php echo $setting['admin_assets'] ?>/css/demo.css" rel="stylesheet" />
    <link href="<?php echo $setting['admin_assets'] ?>/css/all.min.css" rel="stylesheet" />


</head>

<body>
    <div class="wrapper">
        <div class="sidebar" data-color="blue">
            <?php include 'sidebar.php' ?>
            <!--
        Tip 1: You can change the color of the sidebar using: data-color="purple | blue | green | orange | red"

        Tip 2: you can also add an image using data-image tag
    -->

        </div>
        <div class="main-panel">
            <!-- Navbar -->
            <nav class="navbar navbar-expand-lg " color-on-scroll="500">
                <div class="container-fluid">
                    <a class="navbar-brand" href="#pablo"> <?php echo  $title ?> </a>
                    <button href="" class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-bar burger-lines"></span>
                        <span class="navbar-toggler-bar burger-lines"></span>
                        <span class="navbar-toggler-bar burger-lines"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-end" id="navigation">
                        <ul class="nav navbar-nav mr-auto">
                            <li class="nav-item">
                                <a href="#" class="nav-link" data-toggle="dropdown">
                                    <i class="fas fa-<?php echo $icon ?>"></i>
                                </a>
                            </li>

                        </ul>
                        <ul class="navbar-nav ml-auto">
                            <li class="nav-item">
                                <a class="nav-link" href="#pablo">
                                    <span class="no-icon"><?php echo $user->userName(); ?></span>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo $setting['app_url'].'logout.php' ?>">
                                    <span class="no-icon">Log out</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <div class="content">
                <div class="container-fluid">