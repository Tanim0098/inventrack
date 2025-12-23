<?php
include "config.php";

$id = $_POST['id_barang'];
$nama = $_POST['nama'];
$kategori = $_POST['kategori'];
$stok = $_POST['stok'];
$satuan = $_POST['satuan'];

$query = "UPDATE barang SET 
            nama_barang='$nama',
            kategori_id='$kategori',
            stok='$stok',
            satuan='$satuan'
          WHERE id='$id'";

mysqli_query($conn, $query);

header("Location: kelola_barang.php?edit=1");
exit;
?>