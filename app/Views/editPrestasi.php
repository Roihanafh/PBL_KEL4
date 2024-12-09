<?php
// Koneksi ke database
include '../config/koneksi.php';

// Ambil ID Prestasi dari parameter URL
$prestasiId = isset($_GET['prestasi_id']) ? $_GET['prestasi_id'] : null;

if (!$prestasiId) {
    die("ID Prestasi tidak ditemukan.");
}

// Ambil data prestasi berdasarkan ID
$sql = "SELECT * FROM Prestasi WHERE PrestasiId = ?";
$params = array($prestasiId);
$stmt = sqlsrv_query($conn, $sql, $params);

if ($stmt === false || !$row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    die("Data prestasi tidak ditemukan.");
}

// Proses update ketika form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $status = isset($_POST['status']) ? $_POST['status'] : '';

    // Update status prestasi
    $updateSql = "UPDATE Prestasi SET Status = ? WHERE PrestasiId = ?";
    $updateParams = array($status, $prestasiId);
    $updateStmt = sqlsrv_query($conn, $updateSql, $updateParams);

    if ($updateStmt) {
        echo "<script>alert('Status berhasil diperbarui!'); window.location.href = 'validasiPrestasi.php';</script>";
    } else {
        die(print_r(sqlsrv_errors(), true));
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Status Prestasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Edit Status Prestasi</h1>
        <form method="POST">
            <div class="mb-3">
                <label for="judulPrestasi" class="form-label">Judul Prestasi</label>
                <input type="text" class="form-control" id="judulPrestasi" value="<?= htmlspecialchars($row['JudulPrestasi']); ?>" disabled>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select name="status" id="status" class="form-select" required>
                    <option value="Menunggu Validasi" <?= $row['Status'] === 'Menunggu Validasi' ? 'selected' : ''; ?>>Menunggu Validasi</option>
                    <option value="Valid" <?= $row['Status'] === 'Valid' ? 'selected' : ''; ?>>Valid</option>
                    <option value="Tertolak" <?= $row['Status'] === 'Tertolak' ? 'selected' : ''; ?>>Tertolak</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            <a href="validasiPrestasi.php" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>