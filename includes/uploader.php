<?php
require_once('config/database.php');
$uploadDir = 'uploads';
function filterString($field)
{
  $field = filter_var(trim($field), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  if (empty($field)) {
    return false;
  } else {
    return $field;
  }
}

function filterEmail($field)
{
  $field = filter_var(trim($field), FILTER_SANITIZE_EMAIL);
  if (filter_var($field, FILTER_SANITIZE_EMAIL)) {
    return $field;
  } else {
    return false;
  }
}
function canUpload($file)
{
  //ulowed file type
  $arr = [
    'jpeg' => 'image/jpeg',
    'png' => 'image/png',
    'html' => 'text/html'
  ];
  $maxFailSize = 10 * 1024 * 1024;

  $typeFail = mime_content_type($file['tmp_name']);
  $failSize = $file['size'];

  if (!in_array($typeFail, $arr)) {
    return  'file type is not allowed';
  };
  // echo $_FILES['document']['name'];

  if ($failSize > $maxFailSize) {
    return 'file size is not allowed';
  }
  return true;
}

$nameError = $emailError = $messageError = $documentError = '';
$name = $email = $message = $fileName = '';
$services = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  //validate email address
  $services = $_POST['service_id'];
  $name = filterString($_POST['name']);
  if (!$name) {
    $_SESSION['contact_form']['name'] = '';
    $nameerror = 'Your name is required';
  } else {
    $_SESSION['contact_form']['name'] = $name;
  }
  $email = filterEmail($_POST['email']);
  if (!$email) {
    $_SESSION['contact_form']['email'] = '';
    $emailError = 'Your email is invalid';
  } else {
    $_SESSION['contact_form']['email'] = $email;
  }
  $message = filterString($_POST['massage']);
  if (!$message) {
    $_SESSION['contact_form']['massage'] = '';
    $messageError = 'You must enter a massage';
  } else {
    $_SESSION['contact_form']['massage'] = $message;
  }

  if (isset($_FILES['document']) && $_FILES['document']['error'] == 0) {
    $upload = canUpload($_FILES['document']);
    if ($upload === true) {
      //اذا كان مو موجود انشاء مجلد
      if (!is_dir($uploadDir)) {
        //umask(0);,0775F
        mkdir($uploadDir);
      }
      //رفع الملف upload file
      $fileName = time() . $_FILES['document']['name'];
      if (file_exists($uploadDir . '/' . $fileName)) {
        $documentError = 'file already exists';
      } else {
        move_uploaded_file($_FILES['document']['tmp_name'], $uploadDir . '/' . $fileName);
      }
    } else {
      $documentError = $upload;
    }
  }

  if (!$nameError && !$messageError && !$emailError && !$documentError) {
    //mime version ارسال اي شي مب اسكي اي انجليزي
    $fileName ? $filepath = $uploadDir . '/' . $fileName : $filepath = '';
    $services ? $Se = $services : $Se = '';

    $statement = $mysqli->prepare("insert into messages 
    ( contact_name , email , document , message , service_id)
    values( ?, ?, ?, ?, ?) ");
    $statement->bind_param('ssssi', $dbContactName, $dbEmail, $dbDocument, $dbMessage, $dbServiceId);

    $dbContactName  = $name;
    $dbEmail = $email;
    $dbDocument = $fileName;
    $dbMessage = $message;
    $dbServiceId = $services;

    $statement->execute();
    $headers = 'MIME-Version: 1.0' . "\r\n";
    //email send
    $headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
    $headers .= 'From: ' . $email . "\r\n" .
      'Reply-To: ' . $email . "\r\n" .
      'X-Mailer: PHP/' . phpversion();
    $htmlMessage = '<html><body>';
    $htmlMessage = '<p style="color:#ff0000;">' . $message . '</p>';
    $htmlMessage = '</html></body>';

    if (mail($setting['admin_email'], 'you have new massage', $htmlMessage, $headers)) {
      unset($_SESSION['contact_form']);
      header('Location:contact1.php');
      die();
    } else {
      echo "Error sending your email";
    }
  }
}
