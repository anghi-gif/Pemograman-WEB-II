<html>
<body>

<form method="post">
Nilai 1: <input type="number" name="n1"><br>
Nilai 2: <input type="number" name="n2"><br><br>

<input type="submit" value="Hitung">
</form>

<?php
if(isset($_POST['n1']) && isset($_POST['n2'])){

$n1 = $_POST['n1'];
$n2 = $_POST['n2'];

$jumlah = $n1 + $n2;
$kali = $n1 * $n2;

echo "<br>Hasil Penjumlahan: $jumlah";
echo "<br>Hasil Perkalian: $kali";
}
?>

</body>
</html>