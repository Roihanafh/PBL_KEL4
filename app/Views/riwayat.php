<?php
// Include file koneksi
include '../config/koneksi.php';

// Mulai session untuk mendapatkan NIM mahasiswa yang login
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$nimLogin = $_SESSION['nim'];

// Query untuk mengambil data prestasi mahasiswa yang login dengan tahun dari TanggalMulai
$sql = "
    SELECT 
        PM.Nim,
        M.Nama,
        P.JudulPrestasi,
        P.TingkatPrestasi,
        P.Peringkat,
        YEAR(P.TanggalMulai) AS Tahun, -- Mengambil tahun dari TanggalMulai
        P.Status
    FROM 
        PrestasiMahasiswa PM
    JOIN 
        Mahasiswa M ON PM.Nim = M.Nim
    JOIN 
        Prestasi P ON PM.PrestasiId = P.PrestasiId
    WHERE 
        PM.Nim = ? -- Hanya mengambil data sesuai NIM mahasiswa yang login
    ORDER BY 
        P.TanggalMulai DESC;
";

// Eksekusi query menggunakan prepared statement
$params = array($nimLogin);
$stmt = sqlsrv_query($conn, $sql, $params);

// Cek jika query gagal
if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}
?>

<div class="riwayat">
    <div class="container mt-5">
        <p>Data Prestasi</p>
        <hr class="line">
        <div class="mb-3">
            <button class="button" onclick="redirectToFormPrestasi()">
                <i class="fas fa-plus"></i> 
                Data Baru
            </button>
        </div>
        <div class="table-responsive">
            <table id="dataPrestasi" class="table table-striped table-bordered">
                <thead class="table-primary text-center">
                    <tr>
                        <th>No</th>
                        <th>NIM</th>
                        <th>Nama</th>
                        <th>Judul Kompetisi</th>
                        <th>Tingkat</th>
                        <th>Peringkat</th>
                        <th>Tahun</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Loop untuk menampilkan data dari query
                    $no = 1;
                    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                        echo "<tr>";
                        echo "<td>" . $no++ . "</td>";
                        echo "<td>" . htmlspecialchars($row['Nim']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['Nama']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['JudulPrestasi']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['TingkatPrestasi']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['Peringkat']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['Tahun']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['Status']) . "</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
