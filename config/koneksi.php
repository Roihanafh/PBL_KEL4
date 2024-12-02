<?php
// Konfigurasi koneksi database
$serverName = "DESKTOP-1B5FK7F"; // Jangan lupa diganti punya masing" :)
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

echo "Koneksi berhasil ke database PBL_Lencana!";
?>
