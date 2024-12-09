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

// Query untuk mendapatkan data mahasiswa dan prestasi mereka
$sqlMahasiswa = "
    SELECT 
        M.Nama AS NamaMahasiswa,
        M.Nim,
        M.Email,
        P.JudulPrestasi,
        P.TanggalMulai,
        P.TanggalBerakhir,
        P.Poin,
        P.TingkatPrestasi,
        P.TipePrestasi,
        p.BuktiSertif,
        p.PrestasiId
    FROM 
        Mahasiswa M
    JOIN 
        PrestasiMahasiswa PM ON M.Nim = PM.Nim
    JOIN 
        Prestasi P ON PM.PrestasiId = P.PrestasiId
    WHERE 
        P.Status = 'Valid' AND P.DosenNip = ?
    ORDER BY    
        M.Nama, P.TanggalMulai DESC;
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
                    <th>Judul Prestasi</th>
                    <th>Tanggal Mulai</th>
                    <th>Tanggal Berakhir</th>
                    <th>Poin</th>
                    <th>Tingkat</th>
                    <th>Tipe</th>
                    <th>Sertifikat</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                $currentNim = ''; // Variabel untuk melacak NIM terakhir
                while ($row = sqlsrv_fetch_array($stmtMahasiswa, SQLSRV_FETCH_ASSOC)) {
                    echo '<tr>';
                    if ($currentNim != $row['Nim']) {
                        echo "<td>{$no}</td>";
                        echo "<td>" . htmlspecialchars($row['NamaMahasiswa']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['Nim']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['Email']) . "</td>";
                        $currentNim = $row['Nim'];
                        $no++;
                    } else {
                        // Jika NIM sama, kolom nama mahasiswa, NIM, dan email dibiarkan kosong
                        echo '<td></td><td></td><td></td><td></td>';
                    }
                    echo "<td>" . htmlspecialchars($row['JudulPrestasi']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['TanggalMulai']->format('Y-m-d')) . "</td>";
                    echo "<td>" . htmlspecialchars($row['TanggalBerakhir']->format('Y-m-d')) . "</td>";
                    echo "<td>" . htmlspecialchars($row['Poin']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['TingkatPrestasi']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['TipePrestasi']) . "</td>";

                    // Tambahkan kolom untuk tombol download sertifikat
                    if (!empty($row['BuktiSertif'])) {
                        $encodedCert = base64_encode($row['BuktiSertif']);
                        echo "<td><a href='data:application/octet-stream;base64,$encodedCert' download='bukti_sertif_" . htmlspecialchars($row['PrestasiId']) . ".pdf' class='btn btn-primary btn-sm'>Download</a></td>";
                    } else {
                        echo "<td><span class='text-muted'>Tidak tersedia</span></td>";
                    }

                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
