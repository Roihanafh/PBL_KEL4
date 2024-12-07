<?php
// Koneksi ke database
include '../../config/koneksi.php';

// Ambil NIM dari parameter URL
$nim = $_GET['nim'] ?? null;

// Periksa apakah NIM ada
if ($nim === null) {
    die("NIM tidak ditemukan.");
}

// Hapus data di tabel PrestasiMahasiswa terlebih dahulu
$sql_prestasi = "DELETE FROM PrestasiMahasiswa WHERE Nim = ?";
$params_prestasi = [$nim];
$stmt_prestasi = sqlsrv_query($conn, $sql_prestasi, $params_prestasi);

if ($stmt_prestasi === false) {
    die(print_r(sqlsrv_errors(), true));
}

// Setelah data terkait dihapus, hapus data di tabel Mahasiswa
$sql_mahasiswa = "DELETE FROM Mahasiswa WHERE Nim = ?";
$params_mahasiswa = [$nim];
$stmt_mahasiswa = sqlsrv_query($conn, $sql_mahasiswa, $params_mahasiswa);

if ($stmt_mahasiswa === false) {
    die(print_r(sqlsrv_errors(), true));
}

// Redirect kembali ke halaman utama
header("Location: /PBL_KEL4/public/indexadmin.php?page=dataallmhs");
exit;
