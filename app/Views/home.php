<?php
// Include file koneksi
include '../config/koneksi.php';

// Query untuk mengambil data ranking mahasiswa
$sql = "
    SELECT 
        ROW_NUMBER() OVER (ORDER BY SUM(
            CASE 
                WHEN P.TingkatPrestasi = 'Kabupaten/Kota' THEN 
                    CASE 
                        WHEN P.Peringkat BETWEEN 1 AND 5 THEN 6 - P.Peringkat
                        ELSE 0 
                    END
                WHEN P.TingkatPrestasi = 'Provinsi' THEN 
                    CASE 
                        WHEN P.Peringkat BETWEEN 1 AND 5 THEN 11 - P.Peringkat
                        ELSE 0 
                    END
                WHEN P.TingkatPrestasi = 'Nasional' THEN 
                    CASE 
                        WHEN P.Peringkat BETWEEN 1 AND 5 THEN 16 - P.Peringkat
                        ELSE 0 
                    END
                WHEN P.TingkatPrestasi = 'Internasional' THEN 
                    CASE 
                        WHEN P.Peringkat BETWEEN 1 AND 5 THEN 31 - P.Peringkat
                        ELSE 0 
                    END
                ELSE 0
            END
        ) DESC) AS Peringkat,
        M.Nama AS NamaMahasiswa,
        M.Nim AS NimMahasiswa,
        COUNT(*) AS JumlahLombaDiikuti,
        SUM(
            CASE 
                WHEN P.TingkatPrestasi = 'Kabupaten/Kota' THEN 
                    CASE 
                        WHEN P.Peringkat BETWEEN 1 AND 5 THEN 6 - P.Peringkat
                        ELSE 0 
                    END
                WHEN P.TingkatPrestasi = 'Provinsi' THEN 
                    CASE 
                        WHEN P.Peringkat BETWEEN 1 AND 5 THEN 11 - P.Peringkat
                        ELSE 0 
                    END
                WHEN P.TingkatPrestasi = 'Nasional' THEN 
                    CASE 
                        WHEN P.Peringkat BETWEEN 1 AND 5 THEN 16 - P.Peringkat
                        ELSE 0 
                    END
                WHEN P.TingkatPrestasi = 'Internasional' THEN 
                    CASE 
                        WHEN P.Peringkat BETWEEN 1 AND 5 THEN 31 - P.Peringkat
                        ELSE 0 
                    END
                ELSE 0
            END
        ) AS TotalPoin
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

// Simpan TotalPoin ke kolom Poin dalam tabel Prestasi
while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    $nim = $row['NimMahasiswa'];
    $totalPoin = $row['TotalPoin'];

    // Update Poin di tabel Prestasi berdasarkan NimMahasiswa dan PrestasiId
    $updateSql = "
        UPDATE P SET 
            P.Poin = ?
        FROM Prestasi P
        JOIN PrestasiMahasiswa PM ON P.PrestasiId = PM.PrestasiId
        WHERE PM.Nim = ? AND P.Status = 'Valid';
    ";

    $params = [$totalPoin, $nim];
    $updateStmt = sqlsrv_query($conn, $updateSql, $params);

    if ($updateStmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }
}

// Jalankan query untuk menampilkan data setelah update
$stmt = sqlsrv_query($conn, $sql);  // Jalankan kembali query untuk menampilkan data terbaru
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