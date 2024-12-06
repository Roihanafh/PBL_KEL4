<?php
// Menggunakan koneksi yang telah didefinisikan
include '../config/koneksi.php'; // Pastikan file koneksi Anda bernama "koneksi.php"

// Query untuk mengambil semua prestasi yang telah tervalidasi
$sql =
    "SELECT p.PrestasiId, p.JudulPrestasi, p.TingkatPrestasi, p.TipePrestasi, p.Status, 
    m.Nim, m.Nama
    FROM Prestasi p
    INNER JOIN PrestasiMahasiswa pm ON p.PrestasiId = pm.PrestasiId
    INNER JOIN Mahasiswa m ON pm.Nim = m.Nim
    WHERE p.Status = 'Menunggu Validasi';
";


// Menjalankan query
$stmt = sqlsrv_query($conn, $sql);

// Cek jika query berhasil
if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validasi Prestasi</title>

    <!-- Link ke Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/style4.css">

</head>

<body>

    <!-- Konten PHP dan tabel Anda -->
    <div class="container mt-4">
        <div class="subjudul-wrapper mt-5">
            <h1 class="subjudul">Prestasi Mahasiswa yang Belum Divalidasi</h1>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th class="align-middle text-center p-3">No</th>
                        <th class="align-middle text-center p-3">NIM</th>
                        <th class="align-middle text-center p-3">Nama Mahasiswa</th>
                        <th class="align-middle text-center p-3">Judul Prestasi</th>
                        <th class="align-middle text-center p-3">Tingkat Prestasi</th>
                        <th class="align-middle text-center p-3">Tipe Prestasi</th>
                        <th class="align-middle text-center p-3">Status</th>
                        <th class="align-middle text-center p-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    ?>
                    <?php
                    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)):
                    ?>
                        <tr>
                            <td class="text-center p-3"><?php echo $no++; ?></td>
                            <td class="text-center p-3"><?php echo htmlspecialchars($row['Nim']); ?></td>
                            <td class="p-3"><?php echo htmlspecialchars($row['Nama']); ?></td>
                            <td class="p-3"><?php echo htmlspecialchars($row['JudulPrestasi']); ?></td>
                            <td class="text-center p-3"><?php echo htmlspecialchars($row['TingkatPrestasi']); ?></td>
                            <td class="text-center p-3"><?php echo htmlspecialchars($row['TipePrestasi']); ?></td>
                            <td class="text-center p-3">
                                <div class="status-btn <?php echo $row['Status'] == 'Menunggu Validasi' ? 'status-invalid' : ''; ?>">
                                    <?php echo $row['Status']; ?>
                                </div>
                            </td>
                            <td class="text-center p-3">
                                <a href="../app/Views/detailPrestasi.php?prestasi_id=<?= urlencode($row['PrestasiId']); ?>" class="btn btn-success">
                                    Detail
                                </a>


                            </td>

                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Link ke Bootstrap JS dan Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>

</html>