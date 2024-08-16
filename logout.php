<?php
session_start();
require 'config.php'; // Konfigurasi database

// Hapus sesi dari database
$session_id = session_id();
$sql = "DELETE FROM sessions WHERE session_id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$session_id]);

// Hapus sesi dari server
session_unset();
session_destroy();

// Redirect ke halaman login
header('Location: login.html');
exit();
?>
