<?php
session_start();
$hostname = 'remotemysql.com';
$username = 'E786ozefXp';
$password = 'AJVykSfVuB';
$db = 'E786ozefXp';
$conn = mysqli_connect("$hostname", "$username", "$password", "$db");

date_default_timezone_set('Asia/Kolkata');
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}
?>