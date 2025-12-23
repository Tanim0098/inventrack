<?php
$page_title = "Stok Barang";
$active = "barang";
include "layout.php";
include "config.php";

$query = mysqli_query($conn, "
    SELECT b.*, k.nama_kategori 
    FROM barang b
    LEFT JOIN kategori k ON b.kategori_id = k.id
    WHERE b.is_deleted = 0
    ORDER BY b.id ASC
");

if ($role != 'admin') {
    header("Location: dashboard.php");
    exit;
}

?>

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">📦 Kelola Barang</h2>
        <a href="tambah_barang.php" class="btn btn-primary add-btn">
            <i class="bi bi-plus-lg"></i> Tambah Barang
        </a>
    </div>

    <!-- Filter / Search Box -->
    <div class="card card-custom p-4 mb-4">
        <div class="row g-3">
            <div class="col-md-4">
                <input type="text" id="searchInput" class="form-control search-box"
                    placeholder="🔍 Cari nama barang...">
            </div>
            <div class="col-md-3">
                <select id="kategoriFilter" class="form-select search-box">
                    <option value="">Semua Kategori</option>
                    <?php
                    $kategori = mysqli_query($conn, "SELECT * FROM kategori");
                    while ($k = mysqli_fetch_assoc($kategori)) {
                        echo "<option>{$k['nama_kategori']}</option>";
                    }
                    ?>
                </select>
            </div>
        </div>
    </div>

    <!-- Tabel Barang -->
    <div class="card card-custom p-3">
        <div class="table-responsive">
            <table class="table table-hover align-middle" id="barangTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Barang</th>
                        <th>Kategori</th>
                        <th>Jumlah Stok</th>
                        <th>Satuan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    while ($row = mysqli_fetch_assoc($query)):
                        $status = ($row['stok'] > 0) ? "Tersedia" : "Habis";
                        $badge = ($row['stok'] > 0) ? "bg-success" : "bg-danger";
                        ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $row['nama_barang'] ?></td>
                            <td><?= $row['nama_kategori'] ?></td>
                            <?php
                            if ($row['stok'] == 0) {
                                $stok_badge = "bg-danger"; // merah
                            } elseif ($row['stok'] <= 5) {
                                $stok_badge = "bg-warning text-dark"; // kuning
                            } else {
                                $stok_badge = "bg-success"; // hijau
                            }
                            ?>
                            <td><span class="badge <?= $stok_badge ?>"><?= $row['stok'] ?></span></td>
                            <td><?= $row['satuan'] ?></td>

                            <td><span class="badge <?= $badge ?>"><?= $status ?></span></td>
                            <td>
                                <a href="edit_barang.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <a href="hapus_barang.php?id=<?= $row['id'] ?>"
                                    onclick="return confirm('Yakin ingin menghapus?')" class="btn btn-sm btn-danger">
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
    // ==============================================
    // FILTER PENCARIAN + KATEGORI (REAL-TIME)
    // ==============================================
    let searchInput = document.getElementById("searchInput");
    let kategoriFilter = document.getElementById("kategoriFilter");

    function filterTable() {
        let searchText = searchInput.value.toLowerCase();
        let kategoriText = kategoriFilter.value.toLowerCase();
        let rows = document.querySelectorAll("#barangTable tbody tr");

        rows.forEach(row => {
            let rowText = row.textContent.toLowerCase();
            let kategoriKolom = row.children[2].textContent.toLowerCase(); // kolom kategori

            let matchSearch = rowText.includes(searchText);
            let matchKategori = (kategoriText === "") || (kategoriKolom === kategoriText);

            row.style.display = (matchSearch && matchKategori) ? "" : "none";
        });
    }

    searchInput.addEventListener("keyup", filterTable);
    kategoriFilter.addEventListener("change", filterTable);
</script>