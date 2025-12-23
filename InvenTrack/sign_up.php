<?php
session_start();
include "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Cek apakah username sudah ada
    $check = $conn->prepare("SELECT id FROM users WHERE username = ?");
    $check->bind_param("s", $username);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        // Username sudah digunakan
        echo "<script>alert('❌ Username sudah dipakai, silakan gunakan nama lain!'); window.location='sign_up.php';</script>";
    } else {

        // Jika aman → buat akun
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $role = "user";

        $sql = "INSERT INTO users (username, password, role) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $username, $hashedPassword, $role);

        if ($stmt->execute()) {
            echo "<script>alert('✅ Akun berhasil dibuat! Silakan login.'); window.location='login.php';</script>";
        } else {
            echo "<script>alert('❌ Terjadi error ketika menyimpan data!');</script>";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <style>
        body {
            margin: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            background: #333;
            font-family: Arial, sans-serif;
        }

        .signup-box {
            background: #e0e0e0;
            padding: 30px 40px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
            width: 300px;
        }

        .signup-link {
            display: block;
            /* biar bisa diatur posisi */
            text-align: center;
            /* posisikan ke tengah */
            margin-top: 10px;
            /* spasi 1 baris dari button */
            text-decoration: none;
            /* hilangkan underline */
            color: #4a90e2;
            /* warna link sama dengan tombol */
            font-weight: bold;
            /* biar konsisten */
        }

        .signup-link:hover {
            text-decoration: underline;
            /* opsional, kasih efek hover */
        }

        h2 {
            color: #fff;
            text-align: center;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 6px;
            font-size: 14px;
            color: #333;
        }

        input {
            width: 92%;
            padding: 10px;
            margin-bottom: 16px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 14px;
        }

        button {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 6px;
            background: #4a90e2;
            color: #fff;
            font-size: 15px;
            cursor: pointer;
            font-weight: bold;
            transition: background 0.2s ease;
        }

        button:hover {
            background: #357ab8;
        }
    </style>
</head>

<body>
    <h2>Sign Up</h2>
    <div class="signup-box">
        <form method="POST">
            <label for="username">Username</label>
            <input type="text" name="username" id="username" required placeholder="Masukkan username">

            <label for="password">Password</label>
            <input type="password" name="password" id="password" required placeholder="Masukkan password">

            <button type="submit">Sign Up</button>
            <a href="login.php" class="signup-link">Sudah Punya Akun?</a>
        </form>
    </div>
</body>

</html>