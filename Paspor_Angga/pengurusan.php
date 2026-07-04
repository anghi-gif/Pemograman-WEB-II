<?php
require_once 'config.php';

if (isset($_GET['hapus'])) {
    dbQuery($conn, "DELETE FROM pengurusan WHERE id=" . (int)$_GET['hapus']);
    header("Location: pengurusan.php?pesan=hapus"); exit;
}

$alert = ['hapus'=>'<div class="alert alert-error">Data berhasil dihapus.</div>'];
$pesan = isset($_GET['pesan']) ? ($alert[$_GET['pesan']] ?? '') : '';

$res     = dbQuery($conn, "SELECT * FROM pengurusan ORDER BY no_antrian ASC");
$r_total = dbQuery($conn, "SELECT IFNULL(SUM(pembayaran),0) as total FROM pengurusan WHERE status='diterima'");
$total   = number_format((int)mysqli_fetch_assoc($r_total)['total'], 0, ',', '.');
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Pengajuan Paspor - Pengurusan</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2 class="judul">PENGAJUAN PASPOR</h2>
    <div class="sub-judul">Kantor Imigrasi Cabang</div>
    <div class="programmer">Programmer: Angga Firman Hidayat</div>
    <nav>
        <a href="daftar.php">Daftar</a>
        <a href="daftar_ulang.php">Daftar Ulang</a>
        <a href="pengurusan.php" class="active">Pengurusan</a>
    </nav>

    <?php echo $pesan; ?>

    <h3 class="section-title">Data Pengurusan Paspor</h3>
    <p class="note" style="margin-bottom:8px;">
        Data otomatis dari Daftar Ulang. Berkas <strong>lengkap</strong> jika KTP+KK+Ijazah/Akte semua Ada → status <strong>diterima</strong>, pembayaran <strong>Rp 355.000</strong>.
    </p>

    <table>
        <thead>
            <tr><th>No. Antrian</th><th>No. Daftar</th><th>Nama Pemohon</th><th>Berkas</th><th>Status</th><th>Keterangan</th><th>Pembayaran</th><th>Action</th></tr>
        </thead>
        <tbody>
        <?php $no=0; while ($row = mysqli_fetch_assoc($res)): $no++; ?>
            <tr>
                <td><?= $row['no_antrian'] ?></td>
                <td><?= htmlspecialchars($row['no_daftar']) ?></td>
                <td style="text-align:left"><?= htmlspecialchars($row['nama_pemohon']) ?></td>
                <td><?= $row['berkas']=='lengkap' ? '<span class="badge-lengkap">lengkap</span>' : '<span class="badge-tidak">tidak lengkap</span>' ?></td>
                <td><?= $row['status']=='diterima' ? '<span class="badge-diterima">diterima</span>' : '<span class="badge-tidak">ditolak</span>' ?></td>
                <td><?= $row['keterangan']=='OK' ? '<span class="badge-ok">OK</span>' : '<span class="badge-tidak">tidak</span>' ?></td>
                <td><?= $row['pembayaran']>0 ? 'Rp '.number_format($row['pembayaran'],0,',','.') : '-' ?></td>
                <td>
                    <a class="action-link hapus" href="pengurusan.php?hapus=<?= $row['id'] ?>" onclick="return confirm('Hapus?')">hapus</a>
                </td>
            </tr>
        <?php endwhile; ?>
        <?php if ($no==0): ?><tr><td colspan="8" style="text-align:center;color:#999;">Belum ada data. Lengkapi berkas di menu Daftar Ulang.</td></tr><?php endif; ?>
        </tbody>
    </table>

    <div class="pendapatan-box">
        Pendapatan: <span style="color:#155724;">Rp <?= $total ?></span>
        <span class="note" style="font-weight:normal;margin-left:10px;">(Total dari pemohon diterima)</span>
    </div>
</div>
</body>
</html>
