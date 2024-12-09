<?php
require_once '../app/Controllers/MahasiswaController.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include '../config/koneksi.php';

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'mahasiswa') {
    header('Location: login.php');
    exit();
}

// Ambil NIM dari session
$nim = $_SESSION['nim'];
$successMessage = null;
$errorMessage = null;

// Inisialisasi controller
$mahasiswaController = new MahasiswaController($conn, $nim);

// Jika form disubmit, proses update data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $result = $mahasiswaController->processUpdate($_POST);
    if ($result) {
        $successMessage = "Data berhasil diperbarui.";
    } else {
        $errorMessage = "Terjadi kesalahan saat memperbarui data.";
    }
}

// Ambil data mahasiswa
$data = $mahasiswaController->getMahasiswaData();
?>

<div class="profilemhs">
    <p>Profile Saya</p>
    <hr class="line">
    <?php if ($successMessage) : ?>
        <div class="alert alert-success"><?= htmlspecialchars($successMessage) ?></div>
    <?php endif; ?>
    <?php if ($errorMessage) : ?>
        <div class="alert alert-danger"><?= htmlspecialchars($errorMessage) ?></div>
    <?php endif; ?>
    <form method="POST">
        <!-- Nama Mahasiswa -->
        <div class="mb-3">
            <label for="namaMahasiswa" class="form-label">Nama Mahasiswa</label>
            <input type="text" name="namaMahasiswa" id="namaMahasiswa" class="form-control" 
                   value="<?= htmlspecialchars($data['Nama']) ?>" disabled>
        </div>

        <!-- NIM -->
        <div class="mb-3">
            <label for="nimMahasiswa" class="form-label">NIM</label>
            <input type="text" name="nimMahasiswa" id="nimMahasiswa" class="form-control" 
                   value="<?= htmlspecialchars($data['Nim']) ?>" disabled>
        </div>

        <!-- Email -->
        <div class="mb-3">
            <label for="emailMahasiswa" class="form-label">Email</label>
            <input type="email" name="emailMahasiswa" id="emailMahasiswa" class="form-control" 
                   value="<?= htmlspecialchars($data['Email']) ?>" disabled>
        </div>

        <!-- Nomor Telepon -->
        <div class="mb-3">
            <label for="teleponMahasiswa" class="form-label">Nomor Telepon</label>
            <input type="text" name="teleponMahasiswa" id="teleponMahasiswa" class="form-control" 
                   value="<?= htmlspecialchars($data['NoTelp']) ?>" disabled>
        </div>

        <!-- Alamat -->
        <div class="mb-3">
            <label for="alamatMahasiswa" class="form-label">Alamat</label>
            <textarea name="alamatMahasiswa" id="alamatMahasiswa" class="form-control" rows="3" 
                      disabled><?= htmlspecialchars($data['Alamat']) ?></textarea>
        </div>

        <!-- Tombol Aksi -->
        <div class="text-end">
            <button type="button" id="ubahDataBtn" class="btn btn-primary">Ubah Data</button>
            <button type="submit" id="simpanDataBtn" class="btn btn-success" style="display: none;">Simpan Data</button>
        </div>
    </form>
</div>

<script>
    const ubahButton = document.getElementById('ubahDataBtn');
    const simpanButton = document.getElementById('simpanDataBtn');
    const inputs = document.querySelectorAll('#namaMahasiswa, #emailMahasiswa, #teleponMahasiswa, #alamatMahasiswa');

    ubahButton.addEventListener('click', function () {
        inputs.forEach(input => input.disabled = false);
        ubahButton.style.display = 'none';
        simpanButton.style.display = 'inline-block';
    });
</script>
