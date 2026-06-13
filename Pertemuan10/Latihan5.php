<?php

$koneksi = mysqli_connect("localhost", "root", "", "lat_dbase");

$hasil = mysqli_query($koneksi, "select * from tbl_mhs");

echo "<b>Daftar Mahasiswa (menggunakan fetch_row):</b><br>";
while($data = mysqli_fetch_row($hasil)) {
    
    echo "$data[0] | $data[1] $data[2] <br>";
}
?>