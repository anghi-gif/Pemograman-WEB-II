<?php
$con = mysqli_connect("localhost", "root", "");
if (!$con) {
    die('Could not connect: ' . mysqli_connect_error());
}
mysqli_select_db($con, "lat_dbase");


$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$age = $_POST['age'];


$sql = "INSERT INTO tbl_mhs (FirstName, LastName, Age) VALUES ('$firstname', '$lastname', '$age')";

if (!mysqli_query($con, $sql)) {
    die('Error: ' . mysqli_error($con));
}

echo "Mantap! 1 data mahasiswa bernama $firstname berhasil ditambahkan dari form.<br><br>";
echo "<a href='Latihan6.php'>Klik di sini untuk melihat daftar mahasiswa</a>";

mysqli_close($con);
?>