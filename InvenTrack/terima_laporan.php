<?php
session_start();
include "config.php";

$id = $_GET['id'];
$admin_id = $_SESSION['user_id'];

// Ambil data laporan
$lap = mysqli_fetch_assoc(mysqli_query($conn, "
    SELECT * FROM laporan_peminjaman WHERE id = $id
"));

$barang_id = $lap['barang_id'];
$jumlah = $lap['jumlah'];

// Cek stok terbaru dulu
$barang = mysqli_fetch_assoc(mysqli_query($conn, "SELECT stok FROM barang WHERE id = '$barang_id'"));
$stok_now = $barang['stok'];

if ($stok_now < $jumlah) {
    echo "<script>
        alert('Gagal menerima laporan! Stok tidak mencukupi.');
        window.location.href='kelola_laporan.php';
    </script>";
    exit;
}

// Kurangi stok barang
mysqli_query($conn, "
    UPDATE barang SET stok = stok - $jumlah WHERE id = $barang_id
");

// Update laporan
mysqli_query($conn, "
    UPDATE laporan_peminjaman
    SET status = 'diterima', admin_id = '$admin_id', tanggal_diterima = NOW()
    WHERE id = $id
");

header("Location: kelola_laporan.php?msg=approved");
exit;
?>
