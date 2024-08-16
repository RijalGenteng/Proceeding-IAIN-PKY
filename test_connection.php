<?php
include 'config.php'; // Memasukkan file konfigurasi database

if ($pdo) {
    echo "Koneksi berhasil!";
} else {
    echo "Koneksi gagal!";
}
?>
