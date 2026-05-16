<!DOCTYPE html>
<html>
<head>
    <title>Buku Tamu</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to right, #36a949, #15811c);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background: white;
            padding: 30px;
            border-radius: 15px;
            width: 350px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            text-align: center;
        }

        h2 {
            margin-bottom: 20px;
            color: #12872a;
        }

        input, textarea {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            border: 1px solid #ccc;
            border-radius: 8px;
            outline: none;
        }

        input:focus, textarea:focus {
            border-color: #0b7520;
        }

        button {
            width: 100%;
            padding: 10px;
            background: #098709;
            border: none;
            color: white;
            font-weight: bold;
            border-radius: 8px;
            cursor: pointer;
            margin-top: 10px;
        }

        button:hover {
            background: #0ca413;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Buku Tamu</h2>

    <form action="simpan.php" method="post">
        <input type="text" name="nama" placeholder="Masukkan Nama" required>

        <input type="email" name="email" placeholder="Masukkan Email" required>

        <textarea name="pesan" placeholder="Tulis pesan..." rows="4" required></textarea>

        <button type="submit">Kirim</button>
    </form>
</div>

</body>
</html>