<h3> Upload Dokumen</h3>

<form action="" method="POST" enctype="multipart/form-data">
<b>File Upload</b> <input type="file" name="Namafile">
<input type="submit" name="proses" value="Upload">
</form>

<?php
// Koneksi ke database
$koneksi = mysqli_connect("localhost", "root", "", "web_proceeding");

// Periksa apakah tombol submit di klik
if (isset($_POST['proses'])) {
    // Direktori tempat file akan disimpan
    $direktori = "berkas/";
    
    // Cek apakah file berhasil diunggah tanpa error
    if (isset($_FILES['Namafile']) && $_FILES['Namafile']['error'] === UPLOAD_ERR_OK) {
        // Nama file
        $file_name = $_FILES['Namafile']['name'];
        
        // Pindahkan file yang diunggah ke direktori yang ditentukan
        move_uploaded_file($_FILES['Namafile']['tmp_name'], $direktori . $file_name);
        
        // Simpan informasi file ke database
        mysqli_query($koneksi, "INSERT INTO dokumen (file) VALUES ('$file_name')");
        
        echo "<b>File berhasil diupload</b>";
    } else {
        echo "<b>Gagal mengupload file. Silakan coba lagi.</b>";
    }
}
?>
