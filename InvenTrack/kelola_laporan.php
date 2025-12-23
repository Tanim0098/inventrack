<?php
$page_title = "Kelola Laporan";
$active = "laporan";
include "layout.php";
include "config.php";

// Ambil semua laporan peminjaman + relasi user & barang
$query = mysqli_query($conn, "
    SELECT lp.*, u.username, b.nama_barang
    FROM laporan_peminjaman lp
    LEFT JOIN users u ON lp.user_id = u.id
    LEFT JOIN barang b ON lp.barang_id = b.id
    ORDER BY lp.id DESC
");

if ($role != 'admin') {
    header("Location: dashboard.php");
    exit;
}

?>

<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">📄 Kelola Laporan Peminjaman</h2>
    </div>

    <div class="card card-custom p-4 mb-4">
        <div class="row g-3">
            <div class="col-md-4">
                <input type="text" id="searchInput" class="form-control search-box"
                    placeholder="🔍 Cari user / barang / status...">
            </div>
        </div>
    </div>

    <div class="card card-custom p-3">
        <div class="table-responsive">
            <table class="table table-hover align-middle" id="laporanTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>User</th>
                        <th>Barang</th>
                        <th>Jumlah</th>
                        <th>Tanggal Pengajuan</th>
                        <th>Keterangan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    $no = 1;
                    while ($row = mysqli_fetch_assoc($query)):

                        // Tentukan badge status
                        if ($row['status'] == "pending") {
                            $badge = "badge bg-secondary";
                        } elseif ($row['status'] == "diterima") {
                            $badge = "bg-success";
                        } else {
                            $badge = "bg-danger";
                        }
                        ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $row['username'] ?></td>
                            <td><?= $row['nama_barang'] ?></td>
                            <td><?= $row['jumlah'] ?></td>
                            <td><?= $row['tanggal_pengajuan'] ?></td>
                            <td><?= $row['keterangan'] ?></td>

                            <td>
                                <span class="badge <?= $badge ?>">
                                    <?= ucfirst($row['status']) ?>
                                </span>
                            </td>

                            <td>
                                <?php if ($row['status'] == "pending"): ?>
                                    <a href="terima_laporan.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-success"
                                        onclick="return confirm('Terima laporan ini?')">
                                        <i class="bi bi-check-lg"></i>
                                    </a>

                                    <a href="tolak_laporan.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger"
                                        onclick="return confirm('Tolak laporan ini?')">
                                        <i class="bi bi-x-lg"></i>
                                    </a>
                                <?php endif; ?>

                                <!-- Tombol Hapus Selalu Ada -->
                                <a href="hapus_laporan.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-dark"
                                    onclick="return confirm('Yakin ingin menghapus laporan ini?')">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

<script>
    // Search function
    document.getElementById("searchInput").addEventListener("keyup", function () {
        let filter = this.value.toLowerCase();
        let rows = document.querySelectorAll("#laporanTable tbody tr");

        rows.forEach(row => {
            let text = row.textContent.toLowerCase();
            row.style.display = text.includes(filter) ? "" : "none";
        });
    });
</script>