<?php
session_start();
include "config.php";

$user_id = $_SESSION['user_id'];
$barang_id = $_POST['barang_id'];
$jumlah = $_POST['jumlah'];
$keterangan = $_POST['keterangan'];

// Ambil stok barang
$barang = mysqli_fetch_assoc(mysqli_query($conn, "SELECT stok FROM barang WHERE id = '$barang_id'"));
$stok = $barang['stok'];

// Cek jika stok habis
if ($stok <= 0) {
    echo "<script>
        alert('Gagal! Stok barang habis.');
        window.location.href='ajukan_pinjam.php';
    </script>";
    exit;
}

// Cek jika user meminta lebih banyak dari stok
if ($jumlah > $stok) {
    echo "<script>
        alert('Gagal! Jumlah yang diminta melebihi stok yang tersedia.');
        window.location.href='ajukan_pinjam.php';
    </script>";
    exit;
}

// Jika aman, simpan laporan
$query = mysqli_query($conn, "
    INSERT INTO laporan_peminjaman (user_id, barang_id, jumlah, tanggal_pengajuan, keterangan, status)
    VALUES ('$user_id', '$barang_id', '$jumlah', NOW(), '$keterangan', 'pending')
");

if ($query) {
    echo "<script>
        alert('Laporan peminjaman berhasil diajukan!, Mohon tunggu respon admin');
        window.location.href='ajukan_pinjam.php';
    </script>";
} else {
    echo "<script>
        alert('Terjadi kesalahan saat mengajukan laporan.');
        window.location.href='ajukan_pinjam.php';
    </script>";
}
?>
