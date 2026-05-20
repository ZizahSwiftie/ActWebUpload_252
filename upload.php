<?php
$target_dir = "upload/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

// Periksa apakah berkas sebenarnya adalah gambar atau bukan
/*if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        echo "Berkas adalah gambar - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "Berkas bukan gambar.";
        $uploadOk = 0;
    }
}
*/

// Periksa apakah berkas sudah ada
if (file_exists($target_file)) {
    echo "Maaf, berkas sudah ada.";
    $uploadOk = 0;
}

// Periksa ukuran berkas (dalam byte, 500000 byte = 500KB)
if ($_FILES["fileToUpload"]["size"] > 500000) {
    echo "Maaf, berkas Anda terlalu besar.";
    $uploadOk = 0;
}

// Hanya izinkan format berkas tertentu
/*
if($fileType != "jpg" && $fileType != "png" && $fileType != "jpeg"
&& $fileType != "gif" ) {
    echo "Maaf, hanya berkas JPG, JPEG, PNG & GIF yang diperbolehkan.";
    $uploadOk = 0;
}
*/

// Periksa apakah $uploadOk bernilai 0 karena kesalahan
if ($uploadOk == 0) {
    echo "Maaf, berkas Anda tidak dapat diunggah.";
// Jika semua oke, coba unggah berkas
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "Berkas ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " telah diunggah.";
    } else {
        echo "Maaf, terjadi kesalahan saat mengunggah berkas Anda.";
    }
}
?>