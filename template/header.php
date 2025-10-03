<?php
session_start();
setcookie('is_admin', '', time() + 3600);

require_once('config/app.php');
?>
<!DOCTYPE html>
<html dir="<?php echo $setting['dir'] ?>" lang="<?php echo $setting['lang'] ?>">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="bootstrap.min.css">
  <script src="bootstrap.bundle.min.js"></script>
  <title> <?php echo $setting['app_name'] . $title ?></title>
  <style>
    .custom-card-image {
      height: 200px;
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
    }
  </style>

</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-dark br-secondary bg-dark shadow">
    <div class="container-fluid">
      <a class="navbar-brand" href="/index.php"><?php echo $setting['app_name'] ?></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="index.php">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="contact.php">Contact</a>
          </li>
        </ul>
      </div>
      <ul class="navbar-nav ml-auto">
        <?php if (!isset($_SESSION['logged_in'])): ?>
          <li class="nav-item">
            <a class="nav-link" href=" login.php">Login</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="register.php">Register</a>
          </li>
        <?php else: ?>
          <li class="nav-item">
            <a class="nav-link">Hello, <?php echo $_SESSION['user_name'] ?></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="logout.php">logout</a>
          </li>
        <?php endif; ?>
      </ul>
    </div>
  </nav>
  <div class="container pt-5">
    <?php include('message.php'); ?>