<?php
// Path ke file yang ingin didownload
$file = 'berkas/Template Article.docx';

// Cek jika file ada
if (file_exists($file)) {
    // Set header agar browser tahu ini adalah file yang bisa diunduh
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . basename($file) . '"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));

    // Flush output buffer
    flush();
    
    // Baca file dan kirim ke browser
    readfile($file);
    exit;
} else {
    echo "File tidak ditemukan.";
}
?>
