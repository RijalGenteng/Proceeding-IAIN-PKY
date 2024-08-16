<?php
session_start();
require 'config.php'; // Konfigurasi database

// Ambil data dari form
$username = $_POST['username'];
$password = $_POST['password'];

// Validasi login (contoh)
$sql = "SELECT id, password FROM users WHERE username = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$username]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user && password_verify($password, $user['password'])) {
    // Login berhasil
    $_SESSION['user_id'] = $user['id'];

    // Ambil session_id dan IP address
    $session_id = session_id();
    $ip_address = $_SERVER['REMOTE_ADDR'];
    $user_agent = $_SERVER['HTTP_USER_AGENT'];
    $created_at = date('Y-m-d H:i:s');
    $last_activity = $created_at;

    // Hapus session_id yang sudah ada
    $sql = "DELETE FROM sessions WHERE session_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$session_id]);

    // Simpan sesi ke database
    $sql = "INSERT INTO sessions (session_id, user_id, ip_address, user_agent, created_at, last_activity)
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$session_id, $_SESSION['user_id'], $ip_address, $user_agent, $created_at, $last_activity]);

    // Redirect ke dashboard atau halaman utama
    header('Location: dashboard.php');
} else {
    // Login gagal
    header('Location: login.html');
}
?>
