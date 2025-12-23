<?php
$page_title = "Dashboard";
$active = "dashboard";
include "layout.php";
include "config.php";

// Hitung total
$result = mysqli_query($conn, "SELECT SUM(stok) AS total_stok FROM barang");
$data = mysqli_fetch_assoc($result);
$jumlah_barang = $data['total_stok'];
$jumlah_user = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM users"));
$stok_habis = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM barang WHERE stok = 0"));

$query = "
    SELECT lp.*, u.username, b.nama_barang
    FROM laporan_peminjaman lp
    LEFT JOIN users u ON lp.user_id = u.id
    LEFT JOIN barang b ON lp.barang_id = b.id
    ORDER BY lp.tanggal_pengajuan DESC
    LIMIT 5
";
$aktivitas = mysqli_query($conn, $query);

if ($role != 'admin') {
    header("Location: dashboard.php");
    exit;
}

?>

<style>
    .card-stat {
        border-radius: 12px;
        transition: 0.2s;
        cursor: pointer;
    }

    .card-stat:hover {
        transform: translateY(-5px);
        box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.15);
    }

    .icon-box {
        width: 50px;
        height: 50px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        margin-right: 10px;
        color: white;
    }
</style>

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">📊 Dashboard Overview</h2>
    </div>

    <div class="row">

        <!-- Total Barang -->
        <div class="col-md-4 mb-3">
            <div class="card p-3 shadow-sm card-stat d-flex flex-row align-items-center">
                <div class="icon-box bg-primary"><i class="bi bi-box-seam"></i></div>
                <div>
                    <h6 class="text-secondary">Total Barang</h6>
                    <h2><?= $jumlah_barang ?></h2>
                </div>
            </div>
        </div>

        <!-- Total Users -->
        <div class="col-md-4 mb-3">
            <div class="card p-3 shadow-sm card-stat d-flex flex-row align-items-center">
                <div class="icon-box bg-success"><i class="bi bi-people"></i></div>
                <div>
                    <h6 class="text-secondary">Total User</h6>
                    <h2><?= $jumlah_user ?></h2>
                </div>
            </div>
        </div>

        <!-- Stok Habis -->
        <div class="col-md-4 mb-3">
            <div class="card p-3 shadow-sm card-stat d-flex flex-row align-items-center">
                <div class="icon-box bg-danger"><i class="bi bi-exclamation-triangle-fill"></i></div>
                <div>
                    <h6 class="text-secondary">Barang Stok Habis</h6>
                    <h2><?= $stok_habis ?></h2>
                </div>
            </div>
        </div>

    </div>

    <hr class="my-4">

    <h3 class="mb-3">📦 Status Stok Barang</h3>

    <div class="row">

        <!-- Stok Menipis -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm p-3">
                <h5 class="mb-3"><i class="bi bi-arrow-down-circle text-warning"></i> Barang Stok Menipis</h5>

                <?php
                $stok_menipis = mysqli_query($conn, "SELECT * FROM barang WHERE stok < 5 AND stok > 0 ORDER BY stok ASC LIMIT 5");
                ?>

                <table class="table table-hover">
                    <thead class="table-warning">
                        <tr>
                            <th>Nama Barang</th>
                            <th>Stok</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (mysqli_num_rows($stok_menipis) > 0) { ?>
                            <?php while ($row = mysqli_fetch_assoc($stok_menipis)) { ?>
                                <tr>
                                    <td><?= $row['nama_barang'] ?></td>
                                    <td><span class="badge bg-warning text-dark"><?= $row['stok'] ?></span></td>
                                </tr>
                            <?php } ?>
                        <?php } else { ?>
                            <tr>
                                <td colspan="2" class="text-center">Tidak ada data</td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Stok Habis -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm p-3">
                <h5 class="mb-3"><i class="bi bi-x-circle text-danger"></i> Barang Stok Habis</h5>

                <?php
                $habis = mysqli_query($conn, "SELECT * FROM barang WHERE stok = 0 LIMIT 5");
                ?>

                <table class="table table-hover">
                    <thead class="table-danger">
                        <tr>
                            <th>Nama Barang</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (mysqli_num_rows($habis) > 0) { ?>
                            <?php while ($row = mysqli_fetch_assoc($habis)) { ?>
                                <tr>
                                    <td><?= $row['nama_barang'] ?></td>
                                    <td><span class="badge bg-danger">Habis</span></td>
                                </tr>
                            <?php } ?>
                        <?php } else { ?>
                            <tr>
                                <td colspan="2" class="text-center">Tidak ada data</td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <hr class="my-4">

    <h3 class="mb-3">📝 Aktivitas Terbaru</h3>

    <div class="card">
        <div class="card-body p-0">
            <table class="table table-hover">
                <thead class="table-primary">
                    <tr>
                        <th>User</th>
                        <th>Judul</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (mysqli_num_rows($aktivitas) == 0): ?>
                        <tr>
                            <td colspan="3" class="text-center">Belum ada aktivitas</td>
                        </tr>
                    <?php else: ?>
                        <?php while ($row = mysqli_fetch_assoc($aktivitas)): ?>
                            <tr>
                                <td><?php echo $row['username']; ?></td>
                                <td>
                                    <?php
                                    if ($row['status'] == 'pending') {
                                        echo "Pengajuan peminjaman : " . $row['nama_barang'];
                                    } elseif ($row['status'] == 'diterima') {
                                        echo "Peminjaman disetujui : " . $row['nama_barang'];
                                    } elseif ($row['status'] == 'ditolak') {
                                        echo "Peminjaman ditolak : " . $row['nama_barang'];
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    echo date('d-m-Y', strtotime($row['tanggal_pengajuan']));
                                    ?>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>