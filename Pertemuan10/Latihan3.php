<?php
$koneksi = mysqli_connect("localhost", "root", ""); 
mysqli_select_db($koneksi, "lat_dbase");

$sql = "CREATE TABLE tbl_mhs (
    mhsID int NOT NULL AUTO_INCREMENT,
    PRIMARY KEY (mhsID),
    FirstName varchar(15),
    LastName varchar(15),
    Age int
)";
mysqli_query($koneksi, $sql);


mysqli_query($koneksi, "insert into tbl_mhs(FirstName, LastName, Age) values('Anjar', 'Prabowo', 25)");

echo "Tabel tbl_mhs berhasil dibuat dan 1 data awal berhasil dimasukkan.";
?>