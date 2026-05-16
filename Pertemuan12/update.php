<?php
$conn = mysqli_connect("localhost", "root", "", "buku_tamu");

mysqli_query($conn, "UPDATE tamu 
SET nama='Budi Update' 
WHERE id=1");

echo "Data berhasil diupdate";
?>