<?php
// Menggunakan koneksi yang telah didefinisikan
include '../../config/koneksi.php'; // Pastikan file koneksi Anda bernama "koneksi.php"

header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=allprestasi-excel.xls");

// Query untuk mengambil semua prestasi yang telah tervalidasi
$sql = "
    SELECT 
    p.PrestasiId,
    p.JudulPrestasi,
    p.TempatKompetisi,
    p.TingkatPrestasi,
    p.TipePrestasi,
    p.Peringkat,
    p.TanggalMulai,
    p.TanggalBerakhir,
    m.Nama AS NamaMahasiswa,
    d.Nama AS NamaDosen
FROM 
    Prestasi p
JOIN PrestasiMahasiswa pm ON p.PrestasiId = pm.PrestasiId
JOIN Mahasiswa m ON pm.Nim = m.Nim
LEFT JOIN Dosen d ON p.DosenNip = d.Nip
WHERE 
    p.Status = 'Valid'
ORDER BY 
    p.TanggalMulai;

";

// Menjalankan query
$stmt = sqlsrv_query($conn, $sql);

// Cek jika query berhasil
if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Semua Prestasi Mahasiswa</title>
</head>

<body>
    <div class="container my-5">
        <div class="subjudul-wrapper">
            <h1 class="subjudul">Semua Prestasi Mahasiswa</h1>
        </div>
        <div class="table-responsive mt-4">
            <table border="1" style="border-collapse: collapse; width: 100%; font-family: Arial, sans-serif;">
                <thead>
                    <tr style="background-color: #f2f2f2; text-align: center;">
                        <th style="border: 1px solid #000; padding: 8px;">No</th>
                        <th style="border: 1px solid #000; padding: 8px;">Nama Mahasiswa</th>
                        <th style="border: 1px solid #000; padding: 8px;">Judul Prestasi</th>
                        <th style="border: 1px solid #000; padding: 8px;">Tempat Kompetisi</th>
                        <th style="border: 1px solid #000; padding: 8px;">Tingkat Prestasi</th>
                        <th style="border: 1px solid #000; padding: 8px;">Tipe Prestasi</th>
                        <th style="border: 1px solid #000; padding: 8px;">Peringkat</th>
                        <th style="border: 1px solid #000; padding: 8px;">Tanggal Mulai</th>
                        <th style="border: 1px solid #000; padding: 8px;">Tanggal Berakhir</th>
                        <th style="border: 1px solid #000; padding: 8px;">Nama Dosen</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                        echo "<tr>";
                        echo "<td style='border: 1px solid #000; padding: 8px; text-align: left;'>" . $no++ . "</td>";
                        echo "<td style='border: 1px solid #000; padding: 8px; text-align: left;'>" . htmlspecialchars($row['NamaMahasiswa']) . "</td>";
                        echo "<td style='border: 1px solid #000; padding: 8px; text-align: left;'>" . htmlspecialchars($row['JudulPrestasi']) . "</td>";
                        echo "<td style='border: 1px solid #000; padding: 8px; text-align: left;'>" . htmlspecialchars($row['TempatKompetisi']) . "</td>";
                        echo "<td style='border: 1px solid #000; padding: 8px; text-align: left;'>" . htmlspecialchars($row['TingkatPrestasi']) . "</td>";
                        echo "<td style='border: 1px solid #000; padding: 8px; text-align: left;'>" . htmlspecialchars($row['TipePrestasi']) . "</td>";
                        echo "<td style='border: 1px solid #000; padding: 8px; text-align: left;'>" . htmlspecialchars($row['Peringkat']) . "</td>";
                        echo "<td style='border: 1px solid #000; padding: 8px; text-align: left;'>" . htmlspecialchars($row['TanggalMulai']->format('Y-m-d')) . "</td>";
                        echo "<td style='border: 1px solid #000; padding: 8px; text-align: left;'>" . htmlspecialchars($row['TanggalBerakhir']->format('Y-m-d')) . "</td>";
                        echo "<td style='border: 1px solid #000; padding: 8px; text-align: left;'>" . htmlspecialchars($row['NamaDosen']) . "</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>