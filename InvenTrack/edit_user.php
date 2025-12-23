<?php
include "config.php";

// CEK ID
if (!isset($_GET['id'])) {
    die("ID tidak ditemukan!");
}

$id = $_GET['id'];

// AMBIL DATA USER BERDASARKAN ID
$query = mysqli_query($conn, "SELECT * FROM users WHERE id = '$id'");
$user = mysqli_fetch_assoc($query);

if (!$user) {
    die("User tidak ditemukan!");
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f2f2f2;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 70%;
            margin: 40px auto;
        }

        .page-title {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .card {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            margin-bottom: 18px;
        }

        label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }

        .card input[type="text"],
        .card input[type="number"],
        .card select {
            width: 100%;
            padding: 10px;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 15px;
            box-sizing: border-box;
        }

        .btn-submit {
            background-color: #007bff;
            color: white;
            padding: 12px 22px;
            border-radius: 8px;
            font-size: 16px;
            border: none;
            cursor: pointer;
        }

        .btn-submit:hover {
            background-color: #0069d9;
        }

        .btn-batal {
            background-color: red;
            color: white;
            padding: 12px 22px;
            border-radius: 8px;
            font-size: 16px;
            border: none;
            cursor: pointer;
            text-decoration: none;
        }

        .btn-batal:hover {
            background-color: darkred;
        }
    </style>

</head>

<body>

    <div class="container">

        <div class="page-title">👤 Edit User</div>

        <div class="card">

            <form action="proses_edit_user.php" method="POST">

                <input type="hidden" name="id" value="<?= $user['id']; ?>">

                <div class="form-group">
                    <label>ID (tidak bisa diubah)</label>
                    <input type="number" value="<?= $user['id']; ?>" disabled>
                </div>


                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="username" value="<?= $user['username']; ?>" required>
                </div>

                <div class="form-group">
                    <label>Role</label>
                    <select name="role" required>
                        <option value="admin" <?= $user['role'] == 'admin' ? "selected" : "" ?>>Admin</option>
                        <option value="user" <?= $user['role'] == 'user' ? "selected" : "" ?>>User</option>
                    </select>
                </div>

                <button type="submit" class="btn-submit">Simpan Perubahan</button>
                <a href="kelola_user.php" class="btn-batal" onclick="return confirm('Batalkan perubahan?')">Batal</a>

            </form>

        </div>
    </div>

</body>

</html>