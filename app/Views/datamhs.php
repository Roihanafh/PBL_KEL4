<?php
// Memulai sesi
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Periksa apakah dosen sudah login
if (!isset($_SESSION['nip'])) {
    // Jika belum login, redirect ke halaman login
    header("Location: ../public");
    exit();
}

// Sambungkan ke database
include '../config/koneksi.php';

// Mendapatkan NIP dosen yang login dari sesi
$nipDosen = $_SESSION['nip'];

// Mendapatkan Nama Dosen dari tabel Dosen
$sqlDosen = "SELECT Nama FROM Dosen WHERE Nip = ?";
$stmtDosen = sqlsrv_prepare($conn, $sqlDosen, [$nipDosen]);
sqlsrv_execute($stmtDosen);

// Mendapatkan data nama dosen
$namaDosen = '';
if ($rowDosen = sqlsrv_fetch_array($stmtDosen, SQLSRV_FETCH_ASSOC)) {
    $namaDosen = $rowDosen['Nama'];
}

// Query untuk mendapatkan mahasiswa bimbingan dan prestasi
$sqlMahasiswa = "
    SELECT 
        ROW_NUMBER() OVER (ORDER BY SUM(P.Poin) DESC) AS Ranking,
        M.Nama AS NamaMahasiswa,
        M.Nim,
        M.Email,
        COUNT(PM.PrestasiId) AS JumlahLombaDiikuti,
        SUM(P.Poin) AS TotalPoin
    FROM 
        Mahasiswa M
    JOIN 
        PrestasiMahasiswa PM ON M.Nim = PM.Nim
    JOIN 
        Prestasi P ON PM.PrestasiId = P.PrestasiId
    WHERE 
        P.Status = 'Valid' AND P.DosenNip = ?
    GROUP BY 
        M.Nama, M.Nim, M.Email
    ORDER BY    
        TotalPoin DESC;
";

$stmtMahasiswa = sqlsrv_prepare($conn, $sqlMahasiswa, [$nipDosen]);
sqlsrv_execute($stmtMahasiswa);

// Cek jika query gagal
if ($stmtMahasiswa === false) {
    die(print_r(sqlsrv_errors(), true));
}
?>

<!-- Halaman Index Dosen dengan Data Mahasiswa dan Prestasi -->
<div class="index-dosen">
    <p class="title">Profile Dosen</p>
    <hr class="line">
    <form class="profile-form">
        <!-- Nama Dosen dan NIP -->
        <div class="mb-3">
            <label for="namaDosen" class="form-label">Nama Dosen</label>
            <input type="text" id="namaDosen" class="form-control" placeholder="Nama Dosen" value="<?php echo htmlspecialchars($namaDosen); ?>" disabled>
        </div>

        <div class="mb-3">
            <label for="nipDosen" class="form-label">NIP</label>
            <input type="text" id="nipDosen" class="form-control" placeholder="NIP" value="<?php echo htmlspecialchars($nipDosen); ?>" disabled>
        </div>
    </form>

    <h3 class="subtitle">Mahasiswa Bimbingan</h3>
    <div class="table-container">
        <table class="table-mahasiswa">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Mahasiswa</th>
                    <th>NIM</th>
                    <th>Email</th>
                    <th>Jumlah Lomba Diikuti</th>
                    <th>Total Poin</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                while ($row = sqlsrv_fetch_array($stmtMahasiswa, SQLSRV_FETCH_ASSOC)) {
                    echo "<tr>";
                    echo "<td>" . $no++ . "</td>";
                    echo "<td>" . htmlspecialchars($row['NamaMahasiswa']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['Nim']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['Email']) . "</td>";
                    echo "<td>" . $row['JumlahLombaDiikuti'] . "</td>";
                    echo "<td>" . $row['TotalPoin'] . "</td>";
                    echo "</tr>";
                }

                sqlsrv_free_stmt($stmtMahasiswa);
                ?>
            </tbody>
        </table>
    </div>
</div>
