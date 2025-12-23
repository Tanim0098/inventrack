<?php
include "config.php";

// CEK APAKAH ADA ID BARANG
if (!isset($_GET['id'])) {
    die("ID Barang tidak ditemukan!");
}

$id = $_GET['id'];

// AMBIL DATA BARANG
$query = mysqli_query($conn, "SELECT * FROM barang WHERE id = '$id'");
$barang = mysqli_fetch_assoc($query);

if (!$barang) {
    die("Barang tidak ditemukan!");
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Barang</title>

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
            width: 100% !important;
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

        <div class="page-title">✏️ Edit Barang</div>

        <div class="card">

            <form action="proses_edit_barang.php" method="POST">

                <input type="hidden" name="id_barang" value="<?= $barang['id']; ?>">

                <div class="form-group">
                    <label>Nama Barang</label>
                    <input type="text" name="nama" value="<?= $barang['nama_barang']; ?>" required>
                </div>

                <div class="form-group">
                    <label>Kategori</label>
                    <select name="kategori" required>
                        <option value="">-- Pilih Kategori --</option>

                        <?php
                        $kat = mysqli_query($conn, "SELECT * FROM kategori");
                        while ($row = mysqli_fetch_assoc($kat)) {
                            $selected = ($row['id'] == $barang['kategori_id']) ? "selected" : "";
                            echo "<option value='{$row['id']}' $selected>{$row['nama_kategori']}</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Stok Barang</label>
                    <input type="number" name="stok" value="<?= $barang['stok']; ?>" required>
                </div>

                <div class="form-group">
                    <label>Satuan</label>
                    <select name="satuan" required>
                        <option value="">-- Pilih Satuan --</option>

                        <?php
                        $satuanOptions = ["Box", "Pcs", "Unit", "Pack"];

                        foreach ($satuanOptions as $s) {
                            $selected = ($s == $barang['satuan']) ? "selected" : "";
                            echo "<option value='$s' $selected>$s</option>";
                        }
                        ?>
                    </select>
                </div>

                <button type="submit" class="btn-submit">Simpan Perubahan</button>
                <a href="kelola_barang.php" class="btn-batal" onclick="return confirm('Batalkan perubahan?')">Batal</a>

            </form>

        </div>
    </div>

</body>

</html>