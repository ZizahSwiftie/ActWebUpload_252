<?php
if (isset($_GET['file'])) {
    $filename = basename($_GET['file']);
    $filepath = __DIR__ . "/uploads/" . $filename;

    // Pastikan file ada sebelum dihapus
    if (file_exists($filepath)) {
        if (unlink($filepath)) {
            echo "<h2>Hasil Delete:</h2>";
            echo "Berkas <strong>" . htmlspecialchars($filename) . "</strong> telah berhasil dihapus dari server.<br><br>";
        } else {
            echo "Gagal menghapus berkas.<br><br>";
        }
    } else {
        echo "Berkas tidak ditemukan atau sudah dihapus.<br><br>";
    }
    echo "<a href='index.php'>Kembali ke Halaman Utama</a>";
} else {
    header("Location: index.php");
}
?>