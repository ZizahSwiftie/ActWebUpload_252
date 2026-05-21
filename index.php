<?php
// =========================================================================
// LOGIKA PROSES HARUS DI PALING ATAS AGAR TIDAK TERJADI BENTROK HEADER PHP
// =========================================================================

// Lokasi direktori folder penampung file upload kamu
$upload_dir = __DIR__ . "/upload/";

// 1. FITUR UNDUH + VALIDASI (LOGIKA PROSES DOWNLOAD)
if (isset($_GET['action']) && $_GET['action'] == 'download' && isset($_GET['file'])) {
    $file_to_download = basename($_GET['file']);
    $download_path = $upload_dir . $file_to_download;

    if (file_exists($download_path)) {
        $ext = strtolower(pathinfo($download_path, PATHINFO_EXTENSION));
        $allowed_exts = array("jpg", "jpeg", "png", "gif");
        $is_image = @getimagesize($download_path);

        // Validasi: Ekstensi harus termasuk list di atas DAN data internalnya valid sebagai gambar asli
        if (in_array($ext, $allowed_exts) && $is_image !== false) {
            // Bersihkan output buffer untuk mencegah file rusak
            if (ob_get_level()) { ob_end_clean(); }
            
            header('Content-Description: File Transfer');
            header('Content-Type: ' . $is_image['mime']);
            header('Content-Disposition: attachment; filename="' . $file_to_download . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($download_path));
            
            flush(); 
            readfile($download_path);
            exit; // Hentikan skrip agar sisa HTML di bawah tidak ikut terunduh
        } else {
            // Jika bukan gambar, set session atau variable untuk notifikasi error di bawah
            $error_message = "❌ <strong>Look What You Made Me Do!</strong> Akses ditolak. Fitur unduh diproteksi khusus untuk berkas IMAGE (*.png, *.jpg, *.jpeg, *.gif) saja!";
        }
    } else {
        $error_message = "Berkas tidak ditemukan di server.";
    }
}

// 2. FITUR HAPUS (LOGIKA PROSES DELETE)
$delete_message = "";
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['file'])) {
    $file_to_delete = basename($_GET['file']);
    $delete_path = $upload_dir . $file_to_delete;
    
    if (file_exists($delete_path)) {
        if (unlink($delete_path)) {
            $delete_message = "✨ <strong>" . htmlspecialchars($file_to_delete) . "</strong> has been shaken off! (Berhasil dihapus).";
        }
    }
}

// 3. JIKA ADA PROSES POST UPLOAD BERKAS
$upload_message = "";
$upload_success = false;
if (isset($_POST['submit_upload']) && isset($_FILES['fileToUpload'])) {
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    $target_file = $upload_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;

    if (file_exists($target_file)) {
        $upload_message = "Maaf, berkas dengan nama tersebut sudah ada di server.";
        $uploadOk = 0;
    }

    if ($_FILES["fileToUpload"]["size"] > 500000) {
        $upload_message = "Maaf, ukuran berkas terlalu besar (Maksimal 500KB).";
        $uploadOk = 0;
    }

    if ($uploadOk == 1) {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            $upload_message = "✨ Berkas <strong>" . htmlspecialchars(basename($_FILES["fileToUpload"]["name"])) . "</strong> telah berhasil diunggah!";
            $upload_success = true;
        } else {
            $upload_message = "Terjadi kesalahan saat mengunggah berkas Anda.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Act Web Upload ✨ Taylor's Version</title>
    <style>
        /* CSS Theme: Taylor Swift Custom Lover x Reputation Vibe */
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            background: linear-gradient(135deg, #ffe5ec 0%, #f0e6ff 50%, #e8dbfc 100%); 
            color: #4a3b40; 
            margin: 0; 
            padding: 30px 15px;
            min-height: 100vh;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            padding: 35px;
            border-radius: 24px;
            box-shadow: 0 12px 35px rgba(233, 170, 185, 0.35);
            border: 1px solid rgba(255, 255, 255, 0.7);
        }
        .header-card { text-align: center; margin-bottom: 30px; }
        h1 { font-family: 'Georgia', serif; color: #d4a373; font-size: 30px; margin-bottom: 5px; }
        .subtitle { font-style: italic; color: #9a8c98; font-size: 13px; }
        h2 { font-family: 'Georgia', serif; color: #b5838d; border-bottom: 2px dashed #ffb6c1; padding-bottom: 8px; margin-top: 35px; font-size: 20px; }
        
        .upload-box { background: white; padding: 25px; border-radius: 18px; border: 2px dashed #ffcad4; text-align: center; }
        .file-input-wrapper { margin: 15px 0; }
        input[type="file"] { padding: 10px; background: #fff5f7; border-radius: 30px; border: 1px solid #ffe3e8; color: #6d5959; font-size: 14px; }
        
        .preview-area { margin: 20px auto; display: none; }
        #imgPreview { max-width: 220px; border-radius: 12px; border: 4px solid #fff; box-shadow: 0 4px 15px rgba(181,131,141,0.2); padding: 3px; background: white; }
        
        .btn-submit { padding: 12px 35px; background: linear-gradient(45deg, #ffb6c1, #b5838d); color: white; border: none; border-radius: 50px; cursor: pointer; font-weight: bold; box-shadow: 0 4px 12px rgba(181, 131, 141, 0.3); transition: all 0.3s ease; }
        .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 6px 18px rgba(181, 131, 141, 0.45); }
        
        .table-responsive { overflow-x: auto; margin-top: 15px; border-radius: 14px; }
        table { width: 100%; border-collapse: collapse; background-color: rgba(255, 255, 255, 0.95); }
        th, td { padding: 15px; text-align: left; }
        th { background: linear-gradient(to right, #ffcad4, #f4acb7); color: #6d5959; font-family: 'Georgia', serif; font-weight: bold; font-size: 15px; }
        td { border-bottom: 1px solid #ffe5ec; color: #5c5052; font-size: 14px; }
        tr:hover { background-color: #ffeef2; }
        
        .action-btn { padding: 7px 15px; text-decoration: none; color: white; border-radius: 20px; font-size: 12px; font-weight: bold; display: inline-block; }
        .btn-download { background-color: #a2d2ff; color: #2b2d42; margin-right: 6px; }
        .btn-download:hover { background-color: #bde0fe; }
        .btn-delete { background-color: #ffafcc; color: #6d5959; }
        .btn-delete:hover { background-color: #ffc2d1; }
        
        .status-box { padding: 15px; margin-bottom: 20px; border-radius: 10px; font-size: 14px; font-weight: 500; border-left: 5px solid; }
        .status-danger { background-color: #fff3f5; color: #e05753; border-left-color: #f28482; }
        .status-success { background-color: #e8f5e9; color: #2e7d32; border-left-color: #81c784; }
        .text-empty { color: #9a8c98; font-style: italic; text-align: center; padding: 25px; }
    </style>
</head>
<body>

<div class="container">

    <div class="header-card">
        <h1>💘 Act Web Upload (Taylor's Version) 👑</h1>
        <div class="subtitle">"Cause we never go out of style..." — Taylor Swift</div>
    </div>

    <?php
    // Menampilkan pesan error download jika ada
    if (isset($error_message)) {
        echo "<div class='status-box status-danger'>$error_message</div>";
    }

    // Menampilkan pesan hasil delete jika ada
    if (!empty($delete_message)) {
        echo "<div class='status-box status-success'>$delete_message</div>";
    }

    // Menampilkan pesan hasil upload jika ada
    if (!empty($upload_message)) {
        $class = $upload_success ? 'status-success' : 'status-danger';
        echo "<div class='status-box $class'>$upload_message</div>";
    }
    ?>

    <h2>🎤 Lover File Input Area</h2>
    <div class="upload-box">
        <form action="index.php" method="post" enctype="multipart/form-data">
            <div class="file-input-wrapper">
                <input type="file" name="fileToUpload" id="fileToUpload" onchange="runLivePreview()" required>
            </div>
            
            <div class="preview-area" id="previewArea">
                <p style="font-size: 13px; font-weight: bold; color: #b5838d;">✨ Pratinjau Berkas Gambar Kamu: ✨</p>
                <img id="imgPreview" src="#" alt="Pratinjau Gambar">
            </div>
            
            <button type="submit" name="submit_upload" class="btn-submit">Unggah File</button>
        </form>
    </div>

    <h2>Discography 💿 Daftar Berkas Server</h2>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>Nama Berkas</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (is_dir($upload_dir)) {
                    $files = array_diff(scandir($upload_dir), array('.', '..'));
                    if (count($files) > 0) {
                        foreach ($files as $file) {
                            echo "<tr>";
                            echo "<td>🎵 " . htmlspecialchars($file) . "</td>";
                            echo "<td>";
                            echo "<a href='?action=download&file=" . urlencode($file) . "' class='action-btn btn-download'>Unduh</a>";
                            echo "<a href='?action=delete&file=" . urlencode($file) . "' class='action-btn btn-delete' onclick='return confirm(\"Apakah kamu yakin ingin menghapus berkas ini?\")'>Hapus</a>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='2' class='text-empty'>\"The room is empty now...\"<br>Belum ada berkas terunggah di folder /upload/.</td></tr>";
                    }
                } else {
                    echo "<tr><td colspan='2' class='text-empty'>Folder penampung /upload/ belum tersedia di server.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

</div>

<script>
    function runLivePreview() {
        const fileInput = document.getElementById('fileToUpload');
        const previewArea = document.getElementById('previewArea');
        const imgPreview = document.getElementById('imgPreview');
        const file = fileInput.files[0];
        const reader = new FileReader();

        reader.onloadend = function () {
            imgPreview.src = reader.result;
            previewArea.style.display = "block";
        }

        if (file) {
            reader.readAsDataURL(file);
        } else {
            imgPreview.src = "";
            previewArea.style.display = "none";
        }
    }
</script>

</body>
</html>