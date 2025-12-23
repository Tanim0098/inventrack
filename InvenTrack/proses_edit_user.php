<?php
session_start();
include "config.php";

if (!isset($_SESSION['username']) || $_SESSION['role'] != "admin") {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $id = $_POST['id'];
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $role = $_POST['role'];

    // Validasi
    if (trim($username) == "") {
        $_SESSION['pesan'] = "Username tidak boleh kosong!";
        header("Location: kelola_user.php");
        exit();
    }

    // Cek duplikasi
    $cek = mysqli_query($conn, "SELECT * FROM users WHERE username='$username' AND id != '$id'");
    if (mysqli_num_rows($cek) > 0) {
        $_SESSION['pesan'] = "Username sudah digunakan!";
        header("Location: kelola_user.php");
        exit();
    }

    // Update
    $query = "UPDATE users SET username='$username', role='$role' WHERE id='$id'";
    mysqli_query($conn, $query);

    $_SESSION['pesan'] = "User berhasil diperbarui!";
    header("Location: kelola_user.php");
    exit();
}
?>