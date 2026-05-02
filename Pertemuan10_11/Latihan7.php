<?php
$koneksi = mysqli_connect("localhost", "root", "");
mysqli_select_db($koneksi, "lat_dbase");
$hasil = mysqli_query($koneksi, "select * from tbl_mhs");

$hit = mysqli_num_rows($hasil);
echo "Jumlah record saat ini adalah: $hit";
?>