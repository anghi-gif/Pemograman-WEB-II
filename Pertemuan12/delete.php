<?php
$conn = mysqli_connect("localhost", "root", "", "buku_tamu");

mysqli_query($conn, "DELETE FROM tamu WHERE id=1");

echo "Data berhasil dihapus";
?>