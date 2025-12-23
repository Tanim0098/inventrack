<?php
$page_title = "Kelola User";
$active = "user";
include "layout.php";
include "config.php";

// Ambil semua user
$query = mysqli_query($conn, "SELECT * FROM users ORDER BY id DESC");

if ($role != 'admin') {
    header("Location: dashboard.php");
    exit;
}

?>

<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">👤 Kelola User</h2>
    </div>

    <div class="card card-custom p-4 mb-4">
        <div class="row g-3">
            <div class="col-md-4">
                <input type="text" id="searchInput" class="form-control search-box"
                       placeholder="🔍 Cari username...">
            </div>
        </div>
    </div>

    <div class="card card-custom p-3">
        <div class="table-responsive">
            <table class="table table-hover align-middle" id="userTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Role</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    $no = 1;

                    if (mysqli_num_rows($query) > 0):
                        while ($row = mysqli_fetch_assoc($query)):
                    ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $row['username'] ?></td>
                                <td><span class="badge bg-primary"><?= $row['role'] ?></span></td>

                                <td>
                                    <a href="edit_user.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <a href="hapus_user.php?id=<?= $row['id'] ?>"
                                        onclick="return confirm('Yakin ingin menghapus user ini?')"
                                        class="btn btn-sm btn-danger">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </td>
                            </tr>
                    <?php
                        endwhile;
                    else:
                    ?>
                        <tr>
                            <td colspan="4" class="text-center">Tidak ada data user</td>
                        </tr>
                    <?php endif; ?>
                </tbody>

            </table>
        </div>
    </div>
</div>

<script>
    document.getElementById("searchInput").addEventListener("keyup", function () {
        let filter = this.value.toLowerCase();
        let rows = document.querySelectorAll("#userTable tbody tr");

        rows.forEach(row => {
            row.style.display = row.textContent.toLowerCase().includes(filter) ? "" : "none";
        });
    });
</script>
