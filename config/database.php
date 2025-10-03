<?php
$dbs = [
    'server_name' => 'localhost',
    'user_name' => 'root',
    'password' => '2004',
    'dbname' => 'mydba'
];
$mysqli = new mysqli($dbs['server_name'], $dbs['user_name'], $dbs['password'], $dbs['dbname']);

if ($mysqli->connect_error) {
    die("error Connection to database" . $mysqli->connect_error);
}
