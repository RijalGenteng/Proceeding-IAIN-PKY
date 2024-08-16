<?php
session_start();
require 'config.php'; // Memuat konfigurasi database

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header('Location: login.html');
    exit();
}

// Ambil informasi pengguna dari database
$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT username FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    // Jika pengguna tidak ditemukan, hapus sesi dan arahkan kembali ke login
    session_unset();
    session_destroy();
    header('Location: login.html');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header class="header">
        <div class="title-container">
            <h1>Welcome, <?php echo htmlspecialchars($user['username']); ?>!</h1>
            <img src="logo_iain.png" class="logo">
        </div>
    </header>

    <nav class="navbar">
        <ul class="navbar-list">
            <li><a href="index.html">HOME</a></li>
            <li><a href="about.html">ABOUT</a></li>
            <li><a href="logout.php">LOGOUT</a></li>
            <li><a href="profile.html">PROFILE</a></li>
            <li><a href="settings.html">SETTINGS</a></li>
        </ul>
    </nav>

    <div class="content">
        <h2>Dashboard Overview</h2>
        <p>Here you can manage your profile, settings, and more.</p>
    </div>

    <footer class="container-ft">
        <h1 class="h1-ft">Lembaga Penelitian dan Pengabdian kepada Masyarakat</h1>
    </footer>
</body>
</html>
