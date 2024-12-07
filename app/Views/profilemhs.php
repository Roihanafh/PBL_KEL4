<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include '../config/koneksi.php';

// Periksa apakah user sudah login sebagai mahasiswa
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'mahasiswa') {
    header('Location: login.php');
    exit();
}

// Ambil NIM dari session
$nim = $_SESSION['nim'];

// Query untuk mengambil data mahasiswa
$sql = "SELECT * FROM Mahasiswa WHERE Nim = ?";
$stmt = sqlsrv_prepare($conn, $sql, array(&$nim));
$data = null;

if (sqlsrv_execute($stmt)) {
    $data = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
} else {
    echo "Terjadi kesalahan saat mengambil data mahasiswa: ";
    print_r(sqlsrv_errors());
    exit();
}
?>

<div class="profilemhs">
    <p>Profile Saya</p>
    <hr class="line">
    <form>
        <!-- Nama Mahasiswa dan NIM -->
        <div class="mb-3">
            <label for="namaMahasiswa" class="form-label">Nama Mahasiswa</label>
            <input type="text" id="namaMahasiswa" class="form-control" value="<?php echo $data['Nama']; ?>" disabled>
        </div>

        <div class="mb-3">
            <label for="nimMahasiswa" class="form-label">NIM</label>
            <input type="text" id="nimMahasiswa" class="form-control" value="<?php echo $data['Nim']; ?>" disabled>
        </div>
        
        <!-- Email dan Nomor Telepon -->
        <div class="mb-3">
            <label for="emailMahasiswa" class="form-label">Email</label>
            <input type="email" id="emailMahasiswa" class="form-control" value="<?php echo $data['Email']; ?>" disabled>
        </div>
        
        <div class="mb-3">
            <label for="teleponMahasiswa" class="form-label">Nomor Telepon</label>
            <input type="text" id="teleponMahasiswa" class="form-control" value="" disabled>
        </div>
        
        <!-- Alamat -->
        <div class="mb-3">
            <label for="alamatMahasiswa" class="form-label">Alamat</label>
            <textarea id="alamatMahasiswa" class="form-control" rows="3" disabled></textarea>
        </div>
        
        <!-- Tombol Aksi -->
        <div class="text-end">
            <button type="button" id="ubahDataBtn" class="btn btn-primary">Ubah Data</button>
        </div>
    </form>
</div>

<script>
    const button = document.getElementById('ubahDataBtn');
    const inputs = document.querySelectorAll('#namaMahasiswa, #nimMahasiswa, #emailMahasiswa, #teleponMahasiswa, #alamatMahasiswa');

    button.addEventListener('click', function () {
        if (button.textContent === 'Ubah Data') {
            // Aktifkan elemen dengan menghapus atribut disabled
            inputs.forEach(input => {
                input.disabled = false;
            });
            // Ubah teks tombol menjadi "Simpan Data"
            button.textContent = 'Simpan Data';
        } else {
            // Simpan data dan kunci kembali elemen
            inputs.forEach(input => {
                input.disabled = true;
            });
            alert('Data berhasil disimpan!'); // Notifikasi sederhana
            button.textContent = 'Ubah Data'; // Ubah kembali teks tombol
        }
    });
</script>
