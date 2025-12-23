<?php
include "config.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Query hapus
    $query = "DELETE FROM users WHERE id = '$id'";

    if (mysqli_query($conn, $query)) {
        echo "<script>
                alert('User berhasil dihapus!');
                window.location='kelola_user.php';
              </script>";
    } else {
        echo "Gagal menghapus user: " . mysqli_error($koneksi);
    }
} else {
    echo "ID tidak ditemukan!";
}
?>
