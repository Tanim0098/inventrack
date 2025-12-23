<?php
if (!isset($_SESSION))
    session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();

}
$role = $_SESSION['role']; // admin / user
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $page_title ?? "App Inventory" ?></title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background-color: #f4f4f4;
            margin: 0;
            }

        .brand-name {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            }


        /* HEADER */
        .header {
            background-color: #595959;
            padding: 20px;
            color: white;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1000;
            font-size: 20px;
            display: flex;
            align-items: center;
            font-family: 'Inter', sans-serif;
        }

        /* SIDEBAR */
        .sidebar {
            width: 230px;
            background: #2b2b2b;
            position: fixed;
            top: 65px;
            left: 0;
            height: calc(100vh - 65px);
            padding-top: 20px;
            color: white;
            overflow-y: auto;
            overflow-x: hidden;
            scrollbar-width: none;
        }

        .sidebar a {
            display: block;
            padding: 18px 25px;
            color: white;
            text-decoration: none;
            font-size: 16px;
            transition: 0.25s;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background: #575757;
        }

        .logout_btn {
            margin-top: 30px;
            display: block;
            padding: 15px 25px;
            background: red;
            border-radius: 5px;
            font-weight: bold;
        }

        /* CONTENT */
        .content {
            margin-left: 235px;
            margin-top: 90px;
            padding: 20px;
        }
    </style>
</head>

<body>

    <div class="header">
        <span class="brand-name">InvenTrack</span>
    </div>

    <div class="sidebar">
        <?php if ($role == 'admin'): ?>
            <a href="dashboard.php" class="<?= $active == 'dashboard' ? 'active' : '' ?>">Dashboard</a>
        <?php endif; ?>
        <a href="stok_barang.php" class="<?= $active == 'stok' ? 'active' : '' ?>">Stok Barang</a>
        <a href="ajukan_pinjam.php" class="<?= $active == 'pinjam' ? 'active' : '' ?>">Ajukan Peminjaman</a>
        <a href="notifikasi.php" class="<?= $active == 'notifikasi' ? 'active' : '' ?>">Notifikasi</a>
        <?php if ($role == 'admin'): ?>
            <a href="kelola_barang.php" class="<?= $active == 'barang' ? 'active' : '' ?>">Kelola Barang</a>
            <a href="kelola_user.php" class="<?= $active == 'user' ? 'active' : '' ?>">Kelola User</a>
            <a href="kelola_laporan.php" class="<?= $active == 'laporan' ? 'active' : '' ?>">Kelola Laporan</a>
        <?php endif; ?>
        <a href="logout.php" class="logout_btn" onclick="return confirm('Logout?')">Logout</a>
    </div>

    <div class="content">