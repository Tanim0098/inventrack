<?php
include "config.php";
session_start();

// Pastikan hanya admin yang boleh menghapus
if ($_SESSION['role'] != 'admin') {
    header("Location: dashboard.php");
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: kelola_laporan.php");
    exit;
}

$id = $_GET['id'];

// Hapus laporan berdasarkan ID
$query = mysqli_query($conn, "DELETE FROM laporan_peminjaman WHERE id = '$id'");

if ($query) {
    echo "<script>alert('Laporan berhasil dihapus!'); window.location='kelola_laporan.php';</script>";
} else {
    echo "<script>alert('Gagal menghapus laporan!'); window.location='kelola_laporan.php';</script>";
}
?>