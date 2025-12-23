<?php
session_start();
include "config.php";

// Pastikan user sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$id = $_POST['id'];
$admin_id = $_SESSION['user_id'];
$alasan = mysqli_real_escape_string($conn, $_POST['keterangan_tolak']);

// Update laporan
mysqli_query($conn, "
    UPDATE laporan_peminjaman
    SET status = 'ditolak',
        admin_id = '$admin_id',
        keterangan_tolak = '$alasan',
        tanggal_diterima = NOW()
    WHERE id = $id
");

header("Location: kelola_laporan.php?msg=rejected");
exit;
?>
