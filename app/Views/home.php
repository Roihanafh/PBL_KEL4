<?php
// Include file koneksi
include '../config/koneksi.php';
// Fungsi untuk menghitung poin
function hitungPoin($tingkat, $peringkat) {
    $poin = 0;

    // Trim spasi di sekitar peringkat
    $peringkat = trim($peringkat);

    switch ($tingkat) {
        case "Internasional":
            switch ($peringkat) {
                case 1: $poin = 30; break;
                case 2: $poin = 29; break;
                case 3: $poin = 28; break;
                case 4: $poin = 27; break;
                case 5: $poin = 26; break;
                default: $poin = 0; break;
            }
            break;

        case "Nasional":
            switch ($peringkat) {
                case 1: $poin = 20; break;
                case 2: $poin = 19; break;
                case 3: $poin = 18; break;
                case 4: $poin = 17; break;
                case 5: $poin = 16; break;
                default: $poin = 0; break;
            }
            break;

        case "Provinsi":
            switch ($peringkat) {
                case 1: $poin = 15; break;
                case 2: $poin = 14; break;
                case 3: $poin = 13; break;
                case 4: $poin = 12; break;
                case 5: $poin = 11; break;
                default: $poin = 0; break;
            }
            break;

        case "Kabupaten/Kota":
            switch ($peringkat) {
                case 1: $poin = 10; break;
                case 2: $poin = 9; break;
                case 3: $poin = 8; break;
                case 4: $poin = 7; break;
                case 5: $poin = 6; break;
                default: $poin = 0; break;
            }
            break;

        default:
            $poin = 0; // Jika tingkat tidak valid
            break;
    }

    return $poin;
}
//mengambil data prestasi
$sql = "
    SELECT 
        M.Nim AS NimMahasiswa,
        P.PrestasiId,
        P.TingkatPrestasi,
        P.Peringkat
    FROM 
        Mahasiswa M
    JOIN 
        PrestasiMahasiswa PM ON M.Nim = PM.Nim
    JOIN 
        Prestasi P ON PM.PrestasiId = P.PrestasiId
    WHERE 
        P.Status = 'Valid';
";

// Query untuk mengambil data ranking mahasiswa
$sqlTampilRank = "
    SELECT 
        ROW_NUMBER() OVER (ORDER BY SUM(P.Poin) DESC) AS Peringkat,
        M.Nama AS NamaMahasiswa,
        M.Nim AS NimMahasiswa,
        COUNT(*) AS JumlahLombaDiikuti,
        SUM(P.Poin) AS TotalPoin
    FROM 
        Mahasiswa M
    JOIN 
        PrestasiMahasiswa PM ON M.Nim = PM.Nim  -- Menghubungkan Mahasiswa dan Prestasi melalui PrestasiMahasiswa
    JOIN 
        Prestasi P ON PM.PrestasiId = P.PrestasiId  -- Menghubungkan PrestasiMahasiswa dengan Prestasi
    WHERE 
        P.Status = 'Valid'  -- Hanya mengambil Prestasi yang statusnya 'Valid'
    GROUP BY 
        M.Nama, M.Nim
    ORDER BY    
        TotalPoin DESC;
";


// Eksekusi query untuk mendapatkan data
$stmt = sqlsrv_query($conn, $sql);

// Cek jika query gagal
if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}

// Simpan Poin dalam tabel Prestasi
while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    $nim = $row['NimMahasiswa'];
    $poin= hitungPoin($row['TingkatPrestasi'], $row['Peringkat']);
    $prestasiId = $row['PrestasiId'];

    // Update Poin di tabel Prestasi berdasarkan NimMahasiswa dan PrestasiId
    $updateSql = "
        UPDATE P SET 
            P.Poin = ?
        FROM Prestasi P
        JOIN PrestasiMahasiswa PM ON P.PrestasiId = PM.PrestasiId
        WHERE PM.Nim = ? AND P.Status = 'Valid' AND P.PrestasiId = ?;
    ";

    $params = [$poin, $nim, $prestasiId];
    $updateStmt = sqlsrv_query($conn, $updateSql, $params);

    if ($updateStmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }
}

// Jalankan query untuk menampilkan data setelah update
$stmt = sqlsrv_query($conn, $sqlTampilRank);  // Jalankan kembali query untuk menampilkan data terbaru
if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}


?>

<div class="content-wrapper">
    <div class="container mt-5">
        <h2 class="text-center text-primary">Ranking Mahasiswa Berprestasi</h2>
        <div class="subjudul-wrapper">
            <h4 class="subjudul">POLINEMA RANKING PRESTASI MAHASISWA</h4>
        </div>
        <div class="table-responsive mt-4">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Ranking</th>
                        <th>Nama</th>
                        <th>Jumlah Lomba Diikuti</th>
                        <th>Poin</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Loop untuk menampilkan data dari query
                    sqlsrv_execute($stmt); // Jalankan ulang query untuk display
                    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                        echo "<tr>";
                        echo "<td>" . $row['Peringkat'] . "</td>";
                        echo "<td>" . htmlspecialchars($row['NamaMahasiswa']) . "</td>";
                        echo "<td>" . $row['JumlahLombaDiikuti'] . "</td>";
                        echo "<td>" . $row['TotalPoin'] . "</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>