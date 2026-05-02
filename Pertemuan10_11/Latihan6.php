<?php
$koneksi = mysqli_connect("localhost", "root", "");
mysqli_select_db($koneksi, "lat_dbase");
$hasil = mysqli_query($koneksi, "select * from tbl_mhs");

echo "<b>Daftar Mahasiswa (menggunakan fetch_array):</b><br>";
while($data = mysqli_fetch_array($hasil)) {
    echo "$data[FirstName] $data[LastName] - Umur: $data[Age] <br>";
}
?>