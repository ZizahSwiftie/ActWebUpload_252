<?php
if (isset($_GET['file'])) {
    $filename = basename($_GET['file']);
    $filepath = __DIR__ . "/uploads/" . $filename;

    if (file_exists($filepath)) {
        // Validasi: Dapatkan ekstensi file
        $fileType = strtolower(pathinfo($filepath, PATHINFO_EXTENSION));
        $allowedTypes = array("jpg", "jpeg", "png", "gif");

        // Cek ekstensi & cek isi berkas menggunakan getimagesize untuk keamanan tambahan
        $checkImage = @getimagesize($filepath);

        if (in_array($fileType, $allowedTypes) && $checkImage !== false) {
            // Jika valid gambar, teruskan proses unduh
            header('Content-Description: File Transfer');
            header('Content-Type: ' . $checkImage['mime']);
            header('Content-Disposition: attachment; filename="' . $filename . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($filepath));
            
            flush(); 
            readfile($filepath);
            exit;
        } else {
            echo "<h2>Akses Ditolak:</h2>";
            echo "Maaf, fitur unduh ini didesain validasi khusus untuk berkas gambar saja!<br><br>";
            echo "<a href='index.php'>Kembali ke Halaman Utama</a>";
        }
    } else {
        echo "Berkas tidak ditemukan.<br><br>";
        echo "<a href='index.php'>Kembali ke Halaman Utama</a>";
    }
} else {
    header("Location: index.php");
}
?>