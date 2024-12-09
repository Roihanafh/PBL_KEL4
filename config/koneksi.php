<?php
// Konfigurasi koneksi database
$serverName = "DESKTOP-VHL7MV3"; // Server SQL Server Anda
$connectionOptions = [
    "Database" => "PBL_Lencana", // Nama database
    "Uid" => "",    // Username SQL Server
    "PWD" => ""     // Password SQL Server
];

// Membuat koneksi
$conn = sqlsrv_connect($serverName, $connectionOptions);

// Cek koneksi
if ($conn === false) {
    die(print_r(sqlsrv_errors(), true)); // Menampilkan pesan error jika koneksi gagal
}
?>