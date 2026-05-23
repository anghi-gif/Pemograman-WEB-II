<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Mahasiswa</title>

    <style>
        body{
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
        }

        .container{
            width: 600px;
            margin: 50px auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        h2{
            text-align: center;
            color: orange;
            margin-bottom: 30px;
        }

        table{
            width: 100%;
        }

        td{
            padding: 12px;
        }

        input, select{
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .button-group{
            text-align: center;
            margin-top: 20px;
        }

        button{
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin: 5px;
        }

        .submit{
            background-color: #4CAF50;
            color: white;
        }

        .cancel{
            background-color: #f44336;
            color: white;
        }

        button:hover{
            opacity: 0.8;
        }
    </style>
</head>

<body>

    <div class="container">
        <h2>Form Input Data Mahasiswa</h2>

        <form>
            <table>
                <tr>
                    <td>ID Mahasiswa / NIM</td>
                    <td><input type="text" name="nim"></td>
                </tr>

                <tr>
                    <td>Nama</td>
                    <td><input type="text" name="nama"></td>
                </tr>

                <tr>
                    <td>Jurusan</td>
                    <td>
                        <select>
                            <option>- Pilih Jurusan -</option>
                            <option>Teknik Informatika</option>
                            <option>Sistem Informasi</option>
                            <option>Manajemen Informatika</option>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td>Alamat</td>
                    <td><input type="text" name="alamat"></td>
                </tr>

                <tr>
                    <td>No. Telp</td>
                    <td><input type="text" name="telp"></td>
                </tr>
            </table>

            <div class="button-group">
                <button type="submit" class="submit">Submit</button>
                <button type="reset" class="cancel">Cancel</button>
            </div>
        </form>
    </div>

</body>
</html>