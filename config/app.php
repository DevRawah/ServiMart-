<?php

include_once 'database.php';
$config = $mysqli->query("select * from setting where id = 1")->fetch_assoc();

if (count($config)) {
    $app_name = $config['app_name'];
    $admin_email = $config['admin_email'];
} else {
    $app_name = 'Service app';
    $admin_email = 'rawahprogrammer@gmail.com';
}
$setting = [
    'app_name' => $app_name,
    'admin_email' => $admin_email,
    'lang' => 'en',
    'dir' => 'ltr',
    'dir' => 'ltr',
    'app_url' => 'http://project.test/',
    'upload_dir' => 'uploads/',
    'admin_assets' => 'http://project.test/admin/template/assets'
];
