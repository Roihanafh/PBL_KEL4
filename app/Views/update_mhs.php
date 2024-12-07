<?php
// Koneksi ke database
include '../../config/koneksi.php';

// Ambil data dari form
$nim = $_POST['Nim'] ?? null;
$nama = $_POST['Nama'] ?? null;
$email = $_POST['Email'] ?? null;
$password = $_POST['Password'] ?? null;
$programStudi = $_POST['ProgramStudi'] ?? null;
$angkatan = $_POST['Angkatan'] ?? null;

if ($nim === null || $nama === null || $email === null || $password === null || $programStudi === null || $angkatan === null) {
    die("Data tidak lengkap.");
}

// Update data mahasiswa
$sql = "UPDATE Mahasiswa SET Nama = ?, Email = ?, Password = ?, ProgramStudi = ?, Angkatan = ? WHERE Nim = ?";
$params = [$nama, $email, $password, $programStudi, $angkatan, $nim];
$stmt = sqlsrv_query($conn, $sql, $params);

if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}

// Redirect ke halaman data mahasiswa
header("Location: /PBL_KEL4/public/indexadmin.php?page=dataallmhs");
exit;
?>
