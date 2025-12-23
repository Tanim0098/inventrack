<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Barang</title>

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

        input[type="file"] {
            margin-top: 5px;
            font-size: 15px;
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
            text-decoration: none;
        }

        .btn-batal:hover {
            background-color: darkred;
        }

        .form-group input,
        .form-group select {
            width: 100% !important;
            box-sizing: border-box;
            margin: 0 !important;
            padding: 10px;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 15px;
        }
    </style>

</head>

<body>

    <div class="container">

        <div class="page-title">📦 Tambah Barang</div>

        <div class="card">

            <form action="proses_tambah_barang.php" method="POST" enctype="multipart/form-data">

                <div class="form-group">
                    <label>Nama Barang</label>
                    <input type="text" name="nama" required placeholder="Contoh: Beras Premium">
                </div>

                <div class="form-group">
                    <label>Kategori</label>
                    <select name="kategori" required>
                        <option value="">-- Pilih Kategori --</option>
                        <option value="1">Suku Cadang</option>
                        <option value="2">Gadget</option>
                        <option value="3">Alat Kebersihan</option>
                        <option value="4">Alat Berat</option>
                        <option value="5">Alat Keselamatan</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Stok Barang</label>
                    <input type="number" name="stok" required placeholder="Contoh: 20">
                </div>

                <div class="form-group">
                    <label>Satuan</label>
                    <select name="satuan" required>
                        <option value="">-- Pilih Satuan --</option>
                        <option value="Box">Box</option>
                        <option value="Pcs">Pcs</option>
                        <option value="Unit">Unit</option>
                        <option value="Pack">Pack</option>
                    </select>
                </div>

                <button type="submit" class="btn-submit">Simpan Barang</button>
                <a href="kelola_barang.php" class="btn-batal"
                    onclick="return confirm('Apakah Anda Tidak Jadi Menambahkan Barang?')">Batal</a>

            </form>

        </div>
    </div>

</body>

</html>