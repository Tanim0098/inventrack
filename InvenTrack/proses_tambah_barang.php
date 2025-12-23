<?php
include "config.php";

$nama = $_POST['nama'];
$kategori = $_POST['kategori'];
$stok = $_POST['stok'];
$satuan = $_POST['satuan'];

$query = "INSERT INTO `barang` (nama_barang, kategori_id, stok, satuan)
          VALUES ('$nama', '$kategori', '$stok', '$satuan')";

mysqli_query($conn, $query);

header("Location: kelola_barang.php?sukses=1");
?>