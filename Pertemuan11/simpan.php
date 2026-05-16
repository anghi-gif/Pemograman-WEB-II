<?php
$conn = mysqli_connect("localhost", "root", "", "buku_tamu");

$nama = $_POST['nama'];
$email = $_POST['email'];
$pesan = $_POST['pesan'];

mysqli_query($conn, "INSERT INTO tamu (nama,email,pesan)
VALUES ('$nama','$email','$pesan')");

echo "Data berhasil disimpan!";
?>