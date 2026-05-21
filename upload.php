<?php
$target_dir = __DIR__ . "/uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

// Periksa apakah berkas sudah ada
if (file_exists($target_file)) {
    echo "Maaf, berkas sudah ada.<br>";
    $uploadOk = 0;
}

// Periksa ukuran berkas (500KB)
if ($_FILES["fileToUpload"]["size"] > 500000) {
    echo "Maaf, berkas Anda terlalu besar.<br>";
    $uploadOk = 0;
}

// Catatan: Validasi ekstensi sengaja dimatikan (sesuai kode asli bawaan tugas) 
// agar website ini tetap rentan (vulnerable) terhadap upload webshell.php.

if ($uploadOk == 0) {
    echo "Maaf, berkas Anda tidak dapat diunggah.<br>";
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "<h2>Hasil Upload:</h2>";
        echo "Berkas ". htmlspecialchars(basename($_FILES["fileToUpload"]["name"])). " telah berhasil diunggah.<br><br>";
    } else {
        echo "Maaf, terjadi kesalahan saat mengunggah berkas Anda.<br>";
    }
}
echo "<a href='index.php'>Kembali ke Halaman Utama</a>";
?>