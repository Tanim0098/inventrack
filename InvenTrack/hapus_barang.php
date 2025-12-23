<?php
include "config.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Cek apakah data dengan ID ini ada
    $check = mysqli_query($conn, "SELECT * FROM barang WHERE id = '$id' AND is_deleted = 0");

    if (mysqli_num_rows($check) > 0) {

        // Lakukan soft delete
        $query = mysqli_query($conn, "
            UPDATE barang SET is_deleted = 1 WHERE id = '$id'
        ");

        if ($query) {
            header("Location: kelola_barang.php?hapus=1");
            exit;
        } else {
            echo "Gagal menghapus data!";
        }

    } else {
        echo "Data tidak ditemukan atau sudah dihapus!";
    }
} else {
    echo "ID tidak ditemukan!";
}
?>
