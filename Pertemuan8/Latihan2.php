<html>
<head>
    <title>Contoh Penggunaan UDF</title>
</head>
<body>

<!-- Form Input -->
<form method="POST">
Masukkan Bilangan Pertama : <br>
<input type="text" name="A" size="10"> <br>

Masukkan Bilangan Kedua : <br>
<input type="text" name="B" size="10"> <br><br>

<input type="submit" value="Hitung">
</form>

<?php
if(isset($_POST['A']) && isset($_POST['B'])){

    $A = $_POST["A"];
    $B = $_POST["B"];

    function jumlah($A, $B){
        return $A + $B;
    }

    function kurang($A, $B){
        return $A - $B;
    }

    function kali($A, $B){
        return $A * $B;
    }

    function bagi($A, $B){
        return $A / $B;
    }

    echo "<br>";
    echo "Bilangan Pertama : $A <br>";
    echo "Bilangan Kedua : $B <br><br>";

    echo "Penjumlahan: $A + $B = " . jumlah($A,$B) . "<br>";
    echo "Pengurangan: $A - $B = " . kurang($A,$B) . "<br>";
    echo "Perkalian: $A * $B = " . kali($A,$B) . "<br>";
    echo "Pembagian: $A / $B = " . bagi($A,$B) . "<br>";
}
?>

</body>
</html>