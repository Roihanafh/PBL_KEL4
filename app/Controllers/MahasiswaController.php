// controllers/MahasiswaController.php
<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include '../config/koneksi.php';
include '../app/Models/MahasiswaModel.php';

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'mahasiswa') {
    header('Location: login.php');
    exit();
}

// Ambil NIM dari session
$nim = $_SESSION['nim'];
$message = null;

// Inisialisasi objek Mahasiswa
$mahasiswa = new Mahasiswa($conn, $nim);

// Jika form disubmit, proses update data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['namaMahasiswa'];
    $email = $_POST['emailMahasiswa'];
    $telepon = $_POST['teleponMahasiswa'];
    $alamat = $_POST['alamatMahasiswa'];

    $message = $mahasiswa->updateData($nama, $email, $telepon, $alamat);
}

// Ambil data mahasiswa
$data = $mahasiswa->getData();
?>
