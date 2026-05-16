<?php
$conn = mysqli_connect("localhost", "root", "", "buku_tamu");

// pagination
$batas = 5;
$hal = isset($_GET['hal']) ? $_GET['hal'] : 1;
$hal_awal = ($hal - 1) * $batas;

$data = mysqli_query($conn, "SELECT * FROM tamu LIMIT $hal_awal, $batas");

while($row = mysqli_fetch_assoc($data)){
    echo $row['nama']." - ".$row['email']."<br>";
    echo $row['pesan']."<br><hr>";

     echo "<a href='edit.php?id=".$row['id']."'>Edit</a> | ";
    echo "<a href='hapus.php?id=".$row['id']."' 
    onclick='return confirm(\"Yakin hapus?\")'>Hapus</a>";

    echo "<hr>";
}
?>