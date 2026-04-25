<?php
$file = fopen("test1.txt", "r"); // buka file mode read
echo fgets($file); // baca 1 baris
fclose($file); // tutup file
?>