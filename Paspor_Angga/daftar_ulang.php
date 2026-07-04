<?php
require_once 'config.php';

$pesan = '';
$edit_data = null;

if (isset($_POST['simpan'])) {
    $no_daftar  = mysqli_real_escape_string($conn, trim($_POST['no_daftar']));
    $nama       = mysqli_real_escape_string($conn, trim($_POST['nama_pemohon']));
    $keperluan  = mysqli_real_escape_string($conn, trim($_POST['keperluan']));
    $hari_harus = $_POST['hari_harus_datang'];
    $tgl_harus  = $_POST['tgl_harus_datang'];
    $hari_dtg   = $_POST['hari_datang'];
    $tgl_dtg    = $_POST['tgl_datang'];
    $ktp        = $_POST['ktp']  == 'Ada' ? 'Ada' : 'Tidak';
    $kk         = $_POST['kk']   == 'Ada' ? 'Ada' : 'Tidak';
    $ijazah     = $_POST['ijazah_akte'] == 'Ada' ? 'Ada' : 'Tidak';
    $edit_id    = !empty($_POST['edit_id']) ? (int)$_POST['edit_id'] : 0;

    $keterangan = ($ktp=='Ada' && $kk=='Ada' && $ijazah=='Ada') ? 'OK' : 'tidak';

    // No antrian: ambil MAX yang sudah ada, +1
    $no_ant_val = 'NULL';
    if ($keterangan == 'OK') {
        $ex = $edit_id ? "AND id != $edit_id" : "";
        $r_max = dbQuery($conn, "SELECT IFNULL(MAX(no_antrian),0)+1 as next_ant FROM daftar_ulang WHERE keterangan='OK' $ex");
        $no_antrian = (int)mysqli_fetch_assoc($r_max)['next_ant'];
        $no_ant_val = $no_antrian;
    }

    if ($edit_id) {
        dbQuery($conn, "UPDATE daftar_ulang SET
            no_daftar='$no_daftar', nama_pemohon='$nama', keperluan='$keperluan',
            hari_harus_datang='$hari_harus', tgl_harus_datang='$tgl_harus',
            hari_datang='$hari_dtg', tgl_datang='$tgl_dtg',
            ktp='$ktp', kk='$kk', ijazah_akte='$ijazah',
            keterangan='$keterangan', no_antrian=$no_ant_val
            WHERE id=$edit_id");

        if ($keterangan == 'OK') {
            $r_p = dbQuery($conn, "SELECT id FROM pengurusan WHERE no_daftar='$no_daftar'");
            if (mysqli_num_rows($r_p) > 0)
                dbQuery($conn, "UPDATE pengurusan SET no_antrian=$no_antrian, nama_pemohon='$nama', berkas='lengkap', status='diterima', keterangan='OK', pembayaran=355000 WHERE no_daftar='$no_daftar'");
            else
                dbQuery($conn, "INSERT INTO pengurusan (no_antrian,no_daftar,nama_pemohon,berkas,status,keterangan,pembayaran) VALUES ($no_antrian,'$no_daftar','$nama','lengkap','diterima','OK',355000)");
        }
        $pesan = 'update';
    } else {
        dbQuery($conn, "INSERT INTO daftar_ulang
            (no_daftar,nama_pemohon,keperluan,hari_harus_datang,tgl_harus_datang,hari_datang,tgl_datang,ktp,kk,ijazah_akte,keterangan,no_antrian)
            VALUES ('$no_daftar','$nama','$keperluan','$hari_harus','$tgl_harus','$hari_dtg','$tgl_dtg','$ktp','$kk','$ijazah','$keterangan',$no_ant_val)");

        if ($keterangan == 'OK')
            dbQuery($conn, "INSERT INTO pengurusan (no_antrian,no_daftar,nama_pemohon,berkas,status,keterangan,pembayaran) VALUES ($no_antrian,'$no_daftar','$nama','lengkap','diterima','OK',355000)");
        $pesan = 'simpan';
    }
    header("Location: daftar_ulang.php?pesan=$pesan"); exit;
}

if (isset($_GET['hapus'])) {
    $id  = (int)$_GET['hapus'];
    $r   = dbQuery($conn, "SELECT no_daftar FROM daftar_ulang WHERE id=$id");
    $d   = mysqli_fetch_assoc($r);
    if ($d) dbQuery($conn, "DELETE FROM pengurusan WHERE no_daftar='" . mysqli_real_escape_string($conn,$d['no_daftar']) . "'");
    dbQuery($conn, "DELETE FROM daftar_ulang WHERE id=$id");
    header("Location: daftar_ulang.php?pesan=hapus"); exit;
}

if (isset($_GET['edit'])) {
    $r = dbQuery($conn, "SELECT * FROM daftar_ulang WHERE id=" . (int)$_GET['edit']);
    $edit_data = mysqli_fetch_assoc($r);
}

$alert = ['simpan'=>'<div class="alert alert-success">Data berhasil disimpan.</div>',
          'update'=>'<div class="alert alert-success">Data berhasil diperbarui.</div>',
          'hapus' =>'<div class="alert alert-error">Data berhasil dihapus.</div>'];
if (isset($_GET['pesan'])) $pesan = $alert[$_GET['pesan']] ?? '';

$res_nd   = dbQuery($conn, "SELECT no_daftar, nama_pemohon FROM pendaftaran ORDER BY no_daftar ASC");
$hari_list = ['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'];
$res       = dbQuery($conn, "SELECT * FROM daftar_ulang ORDER BY id ASC");

// Kumpulkan opsi dropdown ke array agar bisa dipakai dua kali
$nd_rows = [];
while ($r = mysqli_fetch_assoc($res_nd)) $nd_rows[] = $r;
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Pengajuan Paspor - Daftar Ulang</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2 class="judul">PENGAJUAN PASPOR</h2>
    <div class="sub-judul">Kantor Imigrasi Cabang</div>
    <div class="programmer">Programmer: Angga Firman Hidayat</div>
    <nav>
        <a href="daftar.php">Daftar</a>
        <a href="daftar_ulang.php" class="active">Daftar Ulang</a>
        <a href="pengurusan.php">Pengurusan</a>
    </nav>

    <?php echo $pesan; ?>

    <h3 class="section-title">Input Daftar Ulang</h3>
    <form method="POST" action="daftar_ulang.php">
        <?php if ($edit_data): ?>
            <input type="hidden" name="edit_id" value="<?= $edit_data['id'] ?>">
        <?php endif; ?>

        <div class="form-group">
            <label>No. Daftar</label>
            <select name="no_daftar" required style="width:180px;" onchange="isiNama(this)">
                <option value="">-- Pilih --</option>
                <?php foreach ($nd_rows as $nd):
                    $sel = ($edit_data && $edit_data['no_daftar']==$nd['no_daftar']) ? 'selected' : ''; ?>
                    <option value="<?= $nd['no_daftar'] ?>" data-nama="<?= htmlspecialchars($nd['nama_pemohon']) ?>" <?= $sel ?>>
                        <?= htmlspecialchars($nd['no_daftar']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label>Nama Pemohon</label>
            <input type="text" name="nama_pemohon" id="nama_pemohon" readonly class="readonly-field"
                value="<?= $edit_data ? htmlspecialchars($edit_data['nama_pemohon']) : '' ?>">
        </div>
        <div class="form-group">
            <label>Hari Harus Datang</label>
            <select name="hari_harus_datang" style="width:130px;">
                <?php foreach ($hari_list as $h): ?>
                    <option value="<?= $h ?>" <?= ($edit_data && $edit_data['hari_harus_datang']==$h)?'selected':'' ?>><?= $h ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label>Tgl Harus Datang</label>
            <input type="date" name="tgl_harus_datang" value="<?= $edit_data ? $edit_data['tgl_harus_datang'] : date('Y-m-d') ?>">
        </div>
        <div class="form-group">
            <label>Hari Datang</label>
            <select name="hari_datang" style="width:130px;">
                <?php foreach ($hari_list as $h): ?>
                    <option value="<?= $h ?>" <?= ($edit_data && $edit_data['hari_datang']==$h)?'selected':'' ?>><?= $h ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label>Tgl Datang</label>
            <input type="date" name="tgl_datang" value="<?= $edit_data ? $edit_data['tgl_datang'] : date('Y-m-d') ?>">
        </div>
        <div class="form-group">
            <label>Berkas</label>
            <div class="checkbox-group">
                <label>KTP</label>
                <select name="ktp" style="width:80px;">
                    <option value="Ada"   <?= ($edit_data && $edit_data['ktp']=='Ada')   ?'selected':'' ?>>Ada</option>
                    <option value="Tidak" <?= (!$edit_data || $edit_data['ktp']=='Tidak') ?'selected':'' ?>>Tidak</option>
                </select>
                <label>KK</label>
                <select name="kk" style="width:80px;">
                    <option value="Ada"   <?= ($edit_data && $edit_data['kk']=='Ada')    ?'selected':'' ?>>Ada</option>
                    <option value="Tidak" <?= (!$edit_data || $edit_data['kk']=='Tidak')  ?'selected':'' ?>>Tidak</option>
                </select>
                <label>Ijazah/Akte</label>
                <select name="ijazah_akte" style="width:80px;">
                    <option value="Ada"   <?= ($edit_data && $edit_data['ijazah_akte']=='Ada')   ?'selected':'' ?>>Ada</option>
                    <option value="Tidak" <?= (!$edit_data || $edit_data['ijazah_akte']=='Tidak') ?'selected':'' ?>>Tidak</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label>Keperluan</label>
            <input type="text" name="keperluan" style="width:220px;" placeholder="Contoh: Umroh, Wisata, dll"
                value="<?= $edit_data ? htmlspecialchars($edit_data['keperluan']) : '' ?>">
        </div>

        <button type="submit" name="simpan" class="btn btn-primary"><?= $edit_data ? 'Update' : 'Simpan' ?></button>
        <?php if ($edit_data): ?><a href="daftar_ulang.php" class="btn">Batal</a><?php endif; ?>
    </form>

    <h3 class="section-title">Data Pendaftar Ulang</h3>
    <table>
        <thead>
            <tr><th>No. Daftar</th><th>Nama Pemohon</th><th>Keperluan</th><th>KTP</th><th>KK</th><th>Ijazah/Akte</th><th>Keterangan</th><th>No. Antrian</th><th>Action</th></tr>
        </thead>
        <tbody>
        <?php $no=0; while ($row = mysqli_fetch_assoc($res)): $no++; ?>
            <tr>
                <td><?= htmlspecialchars($row['no_daftar']) ?></td>
                <td style="text-align:left"><?= htmlspecialchars($row['nama_pemohon']) ?></td>
                <td><?= htmlspecialchars($row['keperluan']) ?></td>
                <td><?= $row['ktp'] ?></td>
                <td><?= $row['kk'] ?></td>
                <td><?= $row['ijazah_akte'] ?></td>
                <td><?= $row['keterangan']=='OK' ? '<span class="badge-ok">OK</span>' : '<span class="badge-tidak">tidak</span>' ?></td>
                <td><?= $row['no_antrian'] ?: '-' ?></td>
                <td>
                    <a class="action-link" href="daftar_ulang.php?edit=<?= $row['id'] ?>">edit</a>
                    <a class="action-link hapus" href="daftar_ulang.php?hapus=<?= $row['id'] ?>" onclick="return confirm('Hapus?')">hapus</a>
                </td>
            </tr>
        <?php endwhile; ?>
        <?php if ($no==0): ?><tr><td colspan="9" style="text-align:center;color:#999;">Belum ada data daftar ulang</td></tr><?php endif; ?>
        </tbody>
    </table>
</div>
<script>
function isiNama(sel) {
    document.getElementById('nama_pemohon').value = sel.options[sel.selectedIndex].getAttribute('data-nama') || '';
}
window.onload = function() {
    var sel = document.querySelector('select[name="no_daftar"]');
    if (sel) { var f = document.getElementById('nama_pemohon'); if (f && !f.value) f.value = sel.options[sel.selectedIndex].getAttribute('data-nama') || ''; }
};
</script>
</body>
</html>
