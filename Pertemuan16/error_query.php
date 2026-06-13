<?php

$koneksi = mysqli_connect("localhost","root","","mysql");

if(!$koneksi){
    die("Koneksi Gagal : " . mysqli_connect_error());
}

$query = "SELECT * FROM tabel_salah";

$hasil = mysqli_query($koneksi,$query);

if(!$hasil){
    die("Query Error : " . mysqli_error($koneksi));
}

?>