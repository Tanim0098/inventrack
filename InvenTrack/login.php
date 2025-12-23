<?php
session_start();

// Include database connection
include "config.php"; // Make sure this file contains your database connection

// Check if connection exists
if (!isset($conn)) {
  die("Database connection failed. Please check your index.php file.");
}

$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = trim($_POST['username']);
  $password = trim($_POST['password']);

  // cek user berdasarkan username
  $sql = "SELECT * FROM users WHERE username = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s", $username);
  $stmt->execute();
  $result = $stmt->get_result();

  // cek apakah ada user
  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    // cek password (plain text comparison)
    if (password_verify($password, $row['password'])) {
      $_SESSION['user_id'] = $row['id'];
      $_SESSION['username'] = $row['username'];
      $_SESSION['role'] = $row['role'];

      // arahkan sesuai role
      if ($row['role'] == 'admin') {
        header("Location: dashboard.php");
      } else {
        header("Location: stok_barang.php");
      }
      exit();
    } else {
      $error_message = "❌ Password salah!";
    }
  } else {
    $error_message = "❌ Username tidak ditemukan!";
  }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>Login</title>
  <style>
    body {
      margin: 0;
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      flex-direction: column;
      background: #333;
      /* background gelap */
      font-family: Arial, sans-serif;
    }

    h2 {
      color: #fff;
      margin-bottom: 20px;
      font-weight: 600;
      text-decoration: none;
    }

    .login-box {
      background: #e0e0e0;
      padding: 30px 40px;
      border-radius: 12px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
      width: 300px;
    }

    .login-box label {
      display: block;
      margin-bottom: 6px;
      font-size: 14px;
      color: #333;
    }

    .login-box input {
      width: 92%;
      padding: 10px;
      margin-bottom: 16px;
      border: 1px solid #ccc;
      border-radius: 6px;
      font-size: 14px;
    }

    .login-box button {
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

    .login-box button:hover {
      background: #357ab8;
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

    .error-message {
      color: #d9534f;
      background: #f2dede;
      border: 1px solid #ebccd1;
      border-radius: 4px;
      padding: 10px;
      margin-bottom: 15px;
      font-size: 14px;
      text-align: center;
    }
  </style>
</head>

<body>

  <h2>Login</h2>

  <div class="login-box">
    <form method="POST">
      <?php if (!empty($error_message)): ?>
        <div class="error-message">
          <?php echo htmlspecialchars($error_message); ?>
        </div>
      <?php endif; ?>

      <label for="username">Username</label>
      <input type="text" id="username" name="username" placeholder="Masukkan username" required>

      <label for="password">Password</label>
      <input type="password" id="password" name="password" placeholder="Masukkan password" required>

      <button type="submit">Login</button>
      <a href="sign_up.php" class="signup-link">Buat Akun Baru</a>
  </div>
  </form>

</body>

</html>