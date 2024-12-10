<?php
include '../../config/koneksi.php';
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
// Ambil ID Prestasi dari URL
$prestasiId = $_GET['prestasi_id'] ?? null;

if (!$prestasiId) {
    die("ID Prestasi tidak ditemukan!");
}

// Query untuk mendapatkan data prestasi
$sql = "
    SELECT p.PrestasiId, p.JudulPrestasi, p.TingkatPrestasi, p.TipePrestasi, p.Status, 
        p.TempatKompetisi, p.Url, p.TanggalMulai, p.TanggalBerakhir, p.Peringkat, 
        p.BuktiSertif, p.BuktiSuratTugas, p.FotoKegiatan,
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
        //menghitung poin
        $poin= hitungPoin($stmt['TingkatPrestasi'], $stmt['Peringkat']);
        $prestasiId = $stmt['PrestasiId'];

        // Update Poin di tabel Prestasi berdasarkan NimMahasiswa dan PrestasiId
        $updateSql = "
            UPDATE P SET 
                P.Poin = ?
            FROM Prestasi P
            JOIN PrestasiMahasiswa PM ON P.PrestasiId = PM.PrestasiId
            WHERE P.Status = 'Valid' AND P.PrestasiId = ?;
            ";

        $params = [$poin, $nim, $prestasiId];
        $updateStmt = sqlsrv_query($conn, $updateSql, $params);

        if ($updateStmt === false) {
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

            <!-- File Bukti -->
            <div class="mb-3">
    <label class="form-label">Bukti Sertifikat</label>
    <div>
        <?php if ($data['BuktiSertif']): ?>
            <!-- Tombol Download -->
            <a href="data:application/pdf;base64,<?= base64_encode($data['BuktiSertif']); ?>" 
               download="bukti_sertif_<?= $data['PrestasiId']; ?>.pdf" 
               class="btn btn-primary btn-sm">Download</a>
            <!-- Pratinjau PDF -->
            <div class="mt-2">
                <iframe src="data:application/pdf;base64,<?= base64_encode($data['BuktiSertif']); ?>" 
                        width="100%" 
                        height="400px"></iframe>
            </div>
        <?php else: ?>
            <span class="text-muted">Tidak tersedia</span>
        <?php endif; ?>
    </div>
</div>

<div class="mb-3">
    <label class="form-label">Surat Tugas</label>
    <div>
        <?php if ($data['BuktiSuratTugas']): ?>
            <!-- Tombol Download -->
            <a href="data:application/pdf;base64,<?= base64_encode($data['BuktiSuratTugas']); ?>" 
               download="surat_tugas_<?= $data['PrestasiId']; ?>.pdf" 
               class="btn btn-primary btn-sm">Download</a>
            <!-- Pratinjau PDF -->
            <div class="mt-2">
                <iframe src="data:application/pdf;base64,<?= base64_encode($data['BuktiSuratTugas']); ?>" 
                        width="100%" 
                        height="400px"></iframe>
            </div>
        <?php else: ?>
            <span class="text-muted">Tidak tersedia</span>
        <?php endif; ?>
    </div>
</div>

<div class="mb-3">
    <label class="form-label">Foto Kegiatan</label>
    <div>
        <?php if ($data['FotoKegiatan']): ?>
            <!-- Tombol Download -->
            <a href="data:application/pdf;base64,<?= base64_encode($data['FotoKegiatan']); ?>" 
               download="foto_kegiatan_<?= $data['PrestasiId']; ?>.pdf" 
               class="btn btn-primary btn-sm">Download</a>
            <!-- Pratinjau PDF -->
            <div class="mt-2">
                <iframe src="data:application/pdf;base64,<?= base64_encode($data['FotoKegiatan']); ?>" 
                        width="100%" 
                        height="400px"></iframe>
            </div>
        <?php else: ?>
            <span class="text-muted">Tidak tersedia</span>
        <?php endif; ?>
    </div>
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
