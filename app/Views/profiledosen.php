<?php
session_start();
include '../config/koneksi.php'; // Pastikan jalur ini sesuai

// Pastikan user sudah login
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'dosen') {
    echo "Anda harus login sebagai dosen untuk mengakses halaman ini.";
    exit();
}

$nip = $_SESSION['username']; // Ambil NIP dari sesi login

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
    <form>
        <!-- Nama Dosen dan NIP -->
        <div class="mb-3">
            <label for="namaDosen" class="form-label">Nama Dosen</label>
            <input type="text" id="namaDosen" class="form-control" 
                   value="<?= htmlspecialchars($data['Nama'] ?? 'Tidak ditemukan') ?>" disabled>
        </div>

        <div class="mb-3">
            <label for="nipDosen" class="form-label">NIP</label>
            <input type="text" id="nipDosen" class="form-control" 
                   value="<?= htmlspecialchars($data['Nip'] ?? 'Tidak ditemukan') ?>" disabled>
        </div>
        
        <!-- Email dan Nomor Telepon -->
        <div class="mb-3">
            <label for="emailDosen" class="form-label">Email</label>
            <input type="email" id="emailDosen" class="form-control" 
                   value="<?= htmlspecialchars($data['Email'] ?? 'Tidak ditemukan') ?>" disabled>
        </div>
        
        <div class="mb-3">
            <label for="teleponDosen" class="form-label">Nomor Telepon</label>
            <input type="text" id="teleponDosen" class="form-control" 
                   value="<?= htmlspecialchars($data['NoTelp'] ?? 'Tidak ditemukan') ?>" disabled>
        </div>
        
        <!-- Alamat -->
        <div class="mb-3">
            <label for="alamatDosen" class="form-label">Alamat</label>
            <textarea id="alamatDosen" class="form-control" rows="3" disabled><?= htmlspecialchars($data['Alamat'] ?? 'Tidak ditemukan') ?></textarea>
        </div>
        
        <!-- Tombol Aksi -->
        <div class="text-end">
            <button type="button" id="ubahDataDosenBtn" class="btn btn-primary">Ubah Data</button>
        </div>
    </form>
</div>

<script>
    const buttonDosen = document.getElementById('ubahDataDosenBtn');
    const inputsDosen = document.querySelectorAll('#namaDosen, #nipDosen, #emailDosen, #teleponDosen, #alamatDosen');

    buttonDosen.addEventListener('click', function () {
        if (buttonDosen.textContent === 'Ubah Data') {
            // Aktifkan elemen dengan menghapus atribut disabled
            inputsDosen.forEach(input => {
                input.disabled = false;
            });
            buttonDosen.textContent = 'Simpan Data'; // Ubah teks tombol
        } else {
            // Simpan data dan kunci kembali elemen
            inputsDosen.forEach(input => {
                input.disabled = true;
            });
            alert('Data berhasil disimpan!'); // Notifikasi
            buttonDosen.textContent = 'Ubah Data'; // Ubah kembali teks tombol
        }
    });
</script>
