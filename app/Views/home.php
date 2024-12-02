<?php
// Include file koneksi
include '../config/koneksi.php';

// Query untuk mengambil data ranking mahasiswa
$sql = "
    SELECT 
        ROW_NUMBER() OVER (ORDER BY SUM(P.Poin) DESC) AS Ranking,
        M.Nama AS NamaMahasiswa,
        COUNT(*) AS JumlahLombaDiikuti,
        SUM(P.Poin) AS TotalPoin
    FROM 
        Mahasiswa M
    JOIN 
        Prestasi P ON M.Prestasi_PrestasiId = P.PrestasiId
    GROUP BY 
        M.Nama
    ORDER BY    
        TotalPoin DESC
";

$stmt = sqlsrv_query($conn, $sql);

// Cek jika query gagal
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
                    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                        echo "<tr>";
                        echo "<td>" . $row['Ranking'] . "</td>";
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
