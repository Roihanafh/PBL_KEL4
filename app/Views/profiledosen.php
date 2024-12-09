<?php
session_start();
include '../config/koneksi.php'; // Pastikan jalur ini sesuai

// Pastikan user sudah login
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'dosen') {
    echo "Anda harus login sebagai dosen untuk mengakses halaman ini.";
    exit();
}

$nip = $_SESSION['username']; // Ambil NIP dari sesi login

// Proses update data jika form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['namaDosen'] ?? '';
    $email = $_POST['emailDosen'] ?? '';
    $noTelp = $_POST['teleponDosen'] ?? '';
    $alamat = $_POST['alamatDosen'] ?? '';

    $updateSql = "UPDATE Dosen SET Nama = ?, Email = ?, NoTelp = ?, Alamat = ? WHERE Nip = ?";
    $params = array($nama, $email, $noTelp, $alamat, $nip);

    $updateStmt = sqlsrv_prepare($conn, $updateSql, $params);
    if ($updateStmt && sqlsrv_execute($updateStmt)) {
        $successMessage = "Data berhasil diperbarui.";
    } else {
        $errorMessage = "Terjadi kesalahan saat memperbarui data.";
    }
}

// Query untuk mengambil data dosen berdasarkan NIP
$sql = "SELECT * FROM Dosen WHERE Nip = ?";
$stmt = sqlsrv_prepare($conn, $sql, array(&$nip));

if ($stmt && sqlsrv_execute($stmt)) {
    $data = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
} else {
    echo "Terjadi kesalahan saat mengambil data dosen.";
    exit();
}
?>

<div class="profiledosen">
    <p>Profile Saya</p>
    <hr class="line">
    <?php if (isset($successMessage)) : ?>
        <div class="alert alert-success"><?= htmlspecialchars($successMessage) ?></div>
    <?php endif; ?>
    <?php if (isset($errorMessage)) : ?>
        <div class="alert alert-danger"><?= htmlspecialchars($errorMessage) ?></div>
    <?php endif; ?>
    <form method="POST">
        <!-- Nama Dosen dan NIP -->
        <div class="mb-3">
            <label for="namaDosen" class="form-label">Nama Dosen</label>
            <input type="text" id="namaDosen" name="namaDosen" class="form-control" 
                   value="<?= htmlspecialchars($data['Nama'] ?? '') ?>" required>
        </div>

        <div class="mb-3">
            <label for="nipDosen" class="form-label">NIP</label>
            <input type="text" id="nipDosen" class="form-control" 
                   value="<?= htmlspecialchars($data['Nip'] ?? '') ?>" disabled>
        </div>
        
        <!-- Email dan Nomor Telepon -->
        <div class="mb-3">
            <label for="emailDosen" class="form-label">Email</label>
            <input type="email" id="emailDosen" name="emailDosen" class="form-control" 
                   value="<?= htmlspecialchars($data['Email'] ?? '') ?>" required>
        </div>
        
        <div class="mb-3">
            <label for="teleponDosen" class="form-label">Nomor Telepon</label>
            <input type="text" id="teleponDosen" name="teleponDosen" class="form-control" 
                   value="<?= htmlspecialchars($data['NoTelp'] ?? '') ?>" required>
        </div>
        
        <!-- Alamat -->
        <div class="mb-3">
            <label for="alamatDosen" class="form-label">Alamat</label>
            <textarea id="alamatDosen" name="alamatDosen" class="form-control" rows="3" required><?= htmlspecialchars($data['Alamat'] ?? '') ?></textarea>
        </div>
        
        <!-- Tombol Aksi -->
        <div class="text-end">
            <button type="submit" class="btn btn-success">Simpan Perubahan</button>
        </div>
    </form>
</div>
