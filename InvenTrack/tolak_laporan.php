<?php
session_start();
include "config.php";
$page_title = "Tolak Laporan";

// Pastikan id laporan ada
if (!isset($_GET['id'])) {
    header("Location: kelola_laporan.php");
    exit;
}

$id = $_GET['id'];

// Ambil data laporan
$laporan = mysqli_fetch_assoc(mysqli_query($conn, "
    SELECT laporan_peminjaman.*, barang.nama_barang, users.username
    FROM laporan_peminjaman
    JOIN barang ON laporan_peminjaman.barang_id = barang.id
    JOIN users ON laporan_peminjaman.user_id = users.id
    WHERE laporan_peminjaman.id = $id
"));
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tolak Laporan</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow-sm p-4">
        <h3 class="mb-3">Tolak Laporan Peminjaman</h3>
        <p><b>Nama Peminjam:</b> <?= $laporan['username']; ?></p>
        <p><b>Barang:</b> <?= $laporan['nama_barang']; ?></p>
        <p><b>Jumlah:</b> <?= $laporan['jumlah']; ?></p>

        <hr>

        <form action="proses_tolak_laporan.php" method="POST">
            <input type="hidden" name="id" value="<?= $id ?>">
            
            <div class="mb-3">
                <label class="form-label">Alasan Penolakan</label>
                <textarea name="keterangan_tolak" class="form-control" required rows="4" placeholder="Tulis alasan Anda menolak laporan ini..."></textarea>
            </div>

            <button type="submit" class="btn btn-danger">Tolak Laporan</button>
            <a href="kelola_laporan.php" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>

</body>
</html>
