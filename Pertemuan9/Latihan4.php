<HTML>
<HEAD>
    <TITLE>Tanggal</TITLE>
</HEAD>
<BODY>
    <font size="10px">
        <?php
        // Mengatur zona waktu ke Waktu Indonesia Barat (WIB) agar jamnya akurat
        date_default_timezone_set("Asia/Jakarta");

        echo "Sekarang tanggal ";
        echo date('d-F-Y');
        echo "<br>dan jam ";
        echo date('h:i:s A');
        ?>
    </FONT>
</BODY>
</HTML>