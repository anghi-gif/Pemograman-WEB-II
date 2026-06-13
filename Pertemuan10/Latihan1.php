<?php

$servername = 'localhost';

$dbusername = 'root';
$dbpassword = '';


$link = mysqli_connect($servername, $dbusername, $dbpassword);


if (!$link) {
    die("Not able to connect to server: " . mysqli_connect_error());
}


echo "ok....koneksi berhasil";
?>