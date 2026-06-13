<?php

session_start();

echo "<h2>Session Berhasil Dibuat</h2>";

$_SESSION['nama'] = "Angga";

echo "Nama : ".$_SESSION['nama'];

?>