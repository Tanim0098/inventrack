<?php
session_start();
include "config.php";
$page_title = "Notifikasi";
$active = "notifikasi";
include "layout.php";

// Pastikan user login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Ambil semua laporan milik user
$query = "
    SELECT laporan_peminjaman.*, barang.nama_barang 
    FROM laporan_peminjaman
    JOIN barang ON laporan_peminjaman.barang_id = barang.id
    WHERE laporan_peminjaman.user_id = '$user_id'
    ORDER BY laporan_peminjaman.id DESC
";

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Notifikasi Laporan</title>
</head>

<div class="container py-4">

    <h2 class="fw-bold mb-4">🔔 Notifikasi Laporan Anda</h3>

    <?php if (mysqli_num_rows($result) == 0): ?>
        <div class="alert alert-info">Anda belum mengajukan laporan peminjaman.</div>
    <?php endif; ?>

    <?php while ($row = mysqli_fetch_assoc($result)): ?>

        <div class="card shadow-sm mb-3">
            <div class="card-body">
                <h5 class="card-title"><?= $row['nama_barang'] ?></h5>

                <p class="mb-1">
                    <b>Jumlah:</b> <?= $row['jumlah'] ?>
                </p>

                <p class="mb-1">
                    <b>Status:</b>
                    <?php if ($row['status'] == "pending"): ?>
                        <span class="badge bg-secondary">Pending</span>

                    <?php elseif ($row['status'] == "diterima"): ?>
                        <span class="badge bg-success">Diterima</span>
                        <br><small class="text-muted">Tanggal diterima: <?= $row['tanggal_diterima'] ?></small>

                    <?php elseif ($row['status'] == "ditolak"): ?>
                        <span class="badge bg-danger">Ditolak</span>
                        <p class="mt-2"><b>Alasan Ditolak:</b> <?= $row['keterangan_tolak'] ?></p>
                        <small class="text-muted">Tanggal ditolak: <?= $row['tanggal_diterima'] ?></small>

                    <?php endif; ?>
                </p>
            </div>
        </div>

    <?php endwhile; ?>

</div>

</body>
</html>
