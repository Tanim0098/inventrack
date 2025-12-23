<?php
session_start();
include "config.php";
$page_title = "Ajukan Peminjaman";
$active = "pinjam";
include "layout.php";

// Query barang (hanya barang yang tidak dihapus)
$barang = mysqli_query($conn, "
    SELECT * FROM barang 
    WHERE is_deleted = 0 
    ORDER BY nama_barang ASC
");
?>

<div class="container py-4">
    <h2 class="fw-bold mb-4">📝 Ajukan Peminjaman Barang</h2>

    <div class="card p-4">
        <form action="proses_ajukan_pinjam.php" method="POST">

            <div class="mb-3">
                <label class="form-label">Barang</label>
                <select name="barang_id" class="form-select" required>
                    <option value="">-- Pilih Barang --</option>
                    <?php
                    while ($b = mysqli_fetch_assoc($barang)):
                        if ($b['stok'] <= 0)
                            continue; // barang habis tidak bisa dipilih
                        ?>
                        <option value="<?= $b['id'] ?>">
                            <?= $b['nama_barang'] ?> (Stok: <?= $b['stok'] ?>)
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Jumlah</label>
                <input type="number" name="jumlah" class="form-control" min="1" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Keterangan</label>
                <textarea name="keterangan" class="form-control" rows="3"></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Ajukan</button>
        </form>
    </div>
</div>
