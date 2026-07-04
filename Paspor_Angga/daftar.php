<?php
require_once 'config.php';

$pesan = '';
$edit_data = null;

if (isset($_POST['simpan'])) {
    $nama = mysqli_real_escape_string($conn, trim($_POST['nama_pemohon']));
    $tgl  = $_POST['tanggal_daftar'];
    $cek_tgl   = $tgl;
    $kapasitas = 5;
    $edit_id   = !empty($_POST['edit_id']) ? (int)$_POST['edit_id'] : 0;

    // Cek kapasitas, geser ke hari berikutnya jika penuh
    do {
        $ex = $edit_id ? "AND id != $edit_id" : "";
        $r  = dbQuery($conn, "SELECT COUNT(*) as jml FROM pendaftaran WHERE tanggal_daftar='$cek_tgl' $ex");
        $jml = (int)mysqli_fetch_assoc($r)['jml'];
        if ($jml >= $kapasitas) $cek_tgl = date('Y-m-d', strtotime($cek_tgl . ' +1 day'));
    } while ($jml >= $kapasitas);

    $hari_arr = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
    $hari = $hari_arr[date('w', strtotime($cek_tgl))];
    $jam  = date('H:i:s');

    if ($edit_id) {
        dbQuery($conn, "UPDATE pendaftaran SET nama_pemohon='$nama', tanggal_daftar='$cek_tgl', hari='$hari', jam='$jam' WHERE id=$edit_id");
        $pesan = 'update';
    } else {
        $r_no  = dbQuery($conn, "SELECT IFNULL(MAX(id),0)+1 as next_id FROM pendaftaran");
        $next  = (int)mysqli_fetch_assoc($r_no)['next_id'];
        $no_baru = 'DF-' . str_pad($next, 4, '0', STR_PAD_LEFT);
        dbQuery($conn, "INSERT INTO pendaftaran (no_daftar,nama_pemohon,tanggal_daftar,hari,jam) VALUES ('$no_baru','$nama','$cek_tgl','$hari','$jam')");
        $pesan = 'simpan';
    }
    header("Location: daftar.php?pesan=$pesan"); exit;
}

if (isset($_GET['hapus'])) {
    dbQuery($conn, "DELETE FROM pendaftaran WHERE id=" . (int)$_GET['hapus']);
    header("Location: daftar.php?pesan=hapus"); exit;
}

if (isset($_GET['edit'])) {
    $r = dbQuery($conn, "SELECT * FROM pendaftaran WHERE id=" . (int)$_GET['edit']);
    $edit_data = mysqli_fetch_assoc($r);
}

$alert = ['simpan'=>'<div class="alert alert-success">Data berhasil disimpan.</div>',
          'update'=>'<div class="alert alert-success">Data berhasil diperbarui.</div>',
          'hapus' =>'<div class="alert alert-error">Data berhasil dihapus.</div>'];
if (isset($_GET['pesan'])) $pesan = $alert[$_GET['pesan']] ?? '';

$res = dbQuery($conn, "SELECT * FROM pendaftaran ORDER BY tanggal_daftar ASC, jam ASC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Pengajuan Paspor - Daftar</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2 class="judul">PENGAJUAN PASPOR</h2>
    <div class="sub-judul">Kantor Imigrasi Cabang</div>
    <div class="programmer">Programmer: Angga Firman Hidayat</div>
    <nav>
        <a href="daftar.php" class="active">Daftar</a>
        <a href="daftar_ulang.php">Daftar Ulang</a>
        <a href="pengurusan.php">Pengurusan</a>
    </nav>

    <?php echo $pesan; ?>

    <h3 class="section-title">Input Pendaftaran</h3>
    <form method="POST" action="daftar.php">
        <?php if ($edit_data): ?>
            <input type="hidden" name="edit_id" value="<?= $edit_data['id'] ?>">
        <?php endif; ?>
        <div class="form-group">
            <label>No. Daftar</label>
            <input type="text" class="readonly-field" readonly style="width:120px;"
                value="<?= $edit_data ? htmlspecialchars($edit_data['no_daftar']) : '(otomatis)' ?>">
        </div>
        <div class="form-group">
            <label>Nama Pemohon</label>
            <input type="text" name="nama_pemohon" required style="width:220px;"
                value="<?= $edit_data ? htmlspecialchars($edit_data['nama_pemohon']) : '' ?>">
        </div>
        <div class="form-group">
            <label>Tanggal Daftar</label>
            <input type="date" name="tanggal_daftar" required
                value="<?= $edit_data ? $edit_data['tanggal_daftar'] : date('Y-m-d') ?>">
            <span class="note" style="margin-left:8px;">Kapasitas 5 orang/hari, jika penuh otomatis ke hari berikutnya</span>
        </div>
        <button type="submit" name="simpan" class="btn btn-primary"><?= $edit_data ? 'Update' : 'Simpan' ?></button>
        <?php if ($edit_data): ?><a href="daftar.php" class="btn">Batal</a><?php endif; ?>
    </form>

    <h3 class="section-title">Data Pendaftar</h3>
    <table>
        <thead>
            <tr><th>No. Daftar</th><th>Nama Pemohon</th><th>Tgl Daftar</th><th>Hari</th><th>Tanggal</th><th>Jam</th><th>Action</th></tr>
        </thead>
        <tbody>
        <?php $no=0; while ($row = mysqli_fetch_assoc($res)): $no++; ?>
            <tr>
                <td><?= htmlspecialchars($row['no_daftar']) ?></td>
                <td style="text-align:left"><?= htmlspecialchars($row['nama_pemohon']) ?></td>
                <td><?= date('d/m/Y', strtotime($row['tanggal_daftar'])) ?></td>
                <td><?= $row['hari'] ?></td>
                <td><?= date('d/m/Y', strtotime($row['tanggal_daftar'])) ?></td>
                <td><?= substr($row['jam'],0,5) ?></td>
                <td>
                    <a class="action-link" href="daftar.php?edit=<?= $row['id'] ?>">edit</a>
                    <a class="action-link hapus" href="daftar.php?hapus=<?= $row['id'] ?>" onclick="return confirm('Hapus?')">hapus</a>
                </td>
            </tr>
        <?php endwhile; ?>
        <?php if ($no==0): ?><tr><td colspan="7" style="text-align:center;color:#999;">Belum ada data pendaftaran</td></tr><?php endif; ?>
        </tbody>
    </table>
</div>
</body>
</html>
