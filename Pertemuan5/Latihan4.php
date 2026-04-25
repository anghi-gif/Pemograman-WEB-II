<html>
<head>
<title>Contoh Counter</title>
</head>
<body>

<?php
$nama_file = "counter.dat";

if (file_exists($nama_file)) {
    $berkas = fopen($nama_file, "r");
    $pencacah = (int)fgets($berkas);
    fclose($berkas);

    $pencacah++;
} else {
    $pencacah = 1;
}

// simpan ke file
$berkas = fopen($nama_file, "w");
fwrite($berkas, $pencacah);
fclose($berkas);

// tampilkan
echo "Anda pengunjung ke-$pencacah <br>";
?>

</body>
</html>