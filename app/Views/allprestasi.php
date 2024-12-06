<?php
// Menggunakan koneksi yang telah didefinisikan
include '../config/koneksi.php'; // Pastikan file koneksi Anda bernama "koneksi.php"

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
    <!-- Bootstrap CSS -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-KyZXEAg3QhqLMpG8r+Knujsl5+5hb7Q6LBBI6T/mU6lWo8JLheJrHV8JQMb4J8I4"
        crossorigin="anonymous">
    <link rel="stylesheet" href="../assets/style4.css">
</head>

<body>
    <div class="container my-5">
        <div class="subjudul-wrapper">
            <h1 class="subjudul">Semua Prestasi Mahasiswa</h1>
        </div>
        <div class="table-responsive mt-4">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th class="align-middle p-3">No</th> <!-- Menambahkan padding -->
                        <th class="align-middle p-3">Judul Prestasi</th>
                        <th class="align-middle p-3">Tempat Kompetisi</th>
                        <th class="align-middle p-3">Tingkat Prestasi</th>
                        <th class="align-middle p-3">Tipe Prestasi</th>
                        <th class="align-middle p-3">Peringkat</th>
                        <th class="align-middle p-3">Tanggal Mulai</th>
                        <th class="align-middle p-3">Tanggal Berakhir</th>
                        <th class="align-middle p-3">Nama Mahasiswa</th>
                        <th class="align-middle p-3">Nama Dosen</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    ?>
                    <?php while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)): ?>
                        <tr>
                            <td class="p-3"><?php echo $no++; ?></td> <!-- Menambahkan padding -->
                            <td class="p-3"><?php echo htmlspecialchars($row['JudulPrestasi']); ?></td>
                            <td class="p-3"><?php echo htmlspecialchars($row['TempatKompetisi']); ?></td>
                            <td class="p-3"><?php echo htmlspecialchars($row['TingkatPrestasi']); ?></td>
                            <td class="p-3"><?php echo htmlspecialchars($row['TipePrestasi']); ?></td>
                            <td class="p-3"><?php echo htmlspecialchars($row['Peringkat']); ?></td>
                            <td class="p-3"><?php echo htmlspecialchars($row['TanggalMulai']->format('Y-m-d')); ?></td>
                            <td class="p-3"><?php echo htmlspecialchars($row['TanggalBerakhir']->format('Y-m-d')); ?></td>
                            <td class="p-3"><?php echo htmlspecialchars($row['NamaMahasiswa']); ?></td>
                            <td class="p-3"><?php echo htmlspecialchars($row['NamaDosen']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>


    </div>
    <!-- Bootstrap JS -->
    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AHRdPdzfAd8J4LgC3G24w3zEzzTVaUhHd2wv4U3UjQ8iGii5Fm9XY4oG2Z+me"
        crossorigin="anonymous"></script>
</body>

</html>