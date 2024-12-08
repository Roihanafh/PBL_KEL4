<?php
include '../../config/koneksi.php';

// Ambil ID Prestasi dari URL
$prestasiId = $_GET['prestasi_id'] ?? null;

if (!$prestasiId) {
    die("ID Prestasi tidak ditemukan!");
}

// Query untuk mendapatkan data prestasi
$sql = "
    SELECT p.PrestasiId, p.JudulPrestasi, p.TingkatPrestasi, p.TipePrestasi, p.Status, 
        p.TempatKompetisi, p.Url, p.TanggalMulai, p.TanggalBerakhir, p.Peringkat, 
        m.Nim, m.Nama, m.ProgramStudi, d.Nama AS NamaDosen
        FROM Prestasi p
        INNER JOIN PrestasiMahasiswa pm ON p.PrestasiId = pm.PrestasiId
        INNER JOIN Mahasiswa m ON pm.Nim = m.Nim
        INNER JOIN Dosen d ON p.DosenNip = d.Nip
        WHERE p.PrestasiId = ?";
$params = [$prestasiId];
$stmt = sqlsrv_query($conn, $sql, $params);

if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}

$data = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
if (!$data) {
    die("Data tidak ditemukan!");
}

// Proses jika tombol Terima atau Tolak ditekan
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $status = $_POST['status'] ?? null;
    
    if ($status === 'terima') {
        $statusQuery = "UPDATE Prestasi SET Status = 'Valid' WHERE PrestasiId = ?";
    } elseif ($status === 'tolak') {
        $statusQuery = "UPDATE Prestasi SET Status = 'Tidak Valid' WHERE PrestasiId = ?";
    }

    if (isset($statusQuery)) {
        $statusStmt = sqlsrv_query($conn, $statusQuery, $params);
        if ($statusStmt === false) {
            die(print_r(sqlsrv_errors(), true));
        }
        // Redirect untuk memastikan perubahan berhasil
        header("Location: ../../public/indexadmin.php?page=validasi");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Prestasi Mahasiswa</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
</head>

<body>

    <div class="container mt-5">
        <h2>Detail Prestasi Mahasiswa</h2>
        <form method="POST">
            <!-- Form data dari database -->
            <div class="mb-3">
                <label for="nim" class="form-label">NIM</label>
                <input type="text" class="form-control" id="nim" value="<?= htmlspecialchars($data['Nim']); ?>" readonly>
            </div>

            <div class="mb-3">
                <label for="namaMahasiswa" class="form-label">Nama Mahasiswa</label>
                <input type="text" class="form-control" id="namaMahasiswa" value="<?= htmlspecialchars($data['Nama']); ?>" readonly>
            </div>

            <div class="mb-3">
                <label for="programStudi" class="form-label">Program Studi</label>
                <input type="text" class="form-control" id="programStudi" value="<?= htmlspecialchars($data['ProgramStudi']); ?>" readonly>
            </div>

            <div class="mb-3">
                <label for="judulKompetisi" class="form-label">Judul Kompetisi</label>
                <input type="text" class="form-control" id="judulKompetisi" value="<?= htmlspecialchars($data['JudulPrestasi']); ?>" readonly>
            </div>

            <div class="mb-3">
                <label for="tempatKompetisi" class="form-label">Tempat Kompetisi</label>
                <input type="text" class="form-control" id="tempatKompetisi" value="<?= htmlspecialchars($data['TempatKompetisi']); ?>" readonly>
            </div>

            <div class="mb-3">
                <label for="namaPembimbing" class="form-label">Nama Pembimbing</label>
                <input type="text" class="form-control" id="namaPembimbing" value="<?= htmlspecialchars($data['NamaDosen']); ?>" readonly>
            </div>

            <div class="d-flex justify-content-end">
                <a href="../../public/indexadmin.php?page=validasi" class="btn btn-secondary">Kembali</a>
                <button type="submit" name="status" value="terima" class="btn btn-success ms-2">Terima</button>
                <button type="submit" name="status" value="tolak" class="btn btn-danger ms-2">Tolak</button>
            </div>
        </form>
    </div>
</body>

</html>
