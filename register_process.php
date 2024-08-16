<?php
session_start();
require 'config.php'; // Konfigurasi PDO

// Ambil data dari form
$username = $_POST['username'];
$email = $_POST['email'];
$age = $_POST['age'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash password

try {
    // Debugging: Cetak email yang dicoba
    echo "Email yang dicoba: " . htmlspecialchars($email) . "<br>";

    // Cek apakah email sudah ada
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        // Debugging: Cetak hasil query
        echo "Hasil query: " . print_r($result, true) . "<br>";
        throw new Exception("Email sudah terdaftar, silakan pilih email lain.");
    }

    // Menyimpan data pengguna baru ke database
    $stmt = $pdo->prepare("INSERT INTO users (username, email, age, password) VALUES (?, ?, ?, ?)");
    $stmt->execute([$username, $email, $age, $password]);

    $_SESSION['user_id'] = $pdo->lastInsertId();
    header('Location: login.html');
    exit();
} catch (PDOException $e) {
    echo "Kesalahan database: " . $e->getMessage();
} catch (Exception $e) {
    echo "Terjadi kesalahan: " . $e->getMessage();
}
?>
