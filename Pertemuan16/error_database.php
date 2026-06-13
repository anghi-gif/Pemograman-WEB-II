<?php

$koneksi = mysqli_connect("localhost", "root", "", "db_salah");

if (!$koneksi) {
    die("Koneksi Database Gagal : " . mysqli_connect_error());
}

echo "Koneksi Berhasil";

?>