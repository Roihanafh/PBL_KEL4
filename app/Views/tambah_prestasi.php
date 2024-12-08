<?php
// Koneksi ke database
include '../../config/koneksi.php';

// Ambil data dosen untuk dropdown
$sqlDosen = "SELECT Nip, Nama FROM Dosen";
$stmtDosen = sqlsrv_query($conn, $sqlDosen);
if ($stmtDosen === false) {
    die(print_r(sqlsrv_errors(), true));
}
$dosenList = [];
while ($row = sqlsrv_fetch_array($stmtDosen, SQLSRV_FETCH_ASSOC)) {
    $dosenList[] = $row;
}

// Jika form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validasi file upload
    if (!isset($_FILES['fileSurat'], $_FILES['fileSertifikat'], $_FILES['fileKegiatan'])) {
        die('Semua file harus diunggah.');
    }

    // Mendapatkan data dari form
    $data = [
        'nim' => $_GET['nim'],
        'judulPrestasi' => $_POST['judulPrestasi'],
        'tingkatPrestasi' => $_POST['tingkatPrestasi'],
        'tipePrestasi' => $_POST['tipePrestasi'],
        'tempatKompetisi' => $_POST['tempatKompetisi'],
        'tanggalMulai' => $_POST['tanggalMulai'],
        'tanggalBerakhir' => $_POST['tanggalBerakhir'],
        'peringkat' => $_POST['peringkat'],
        'url' => $_POST['url'],
        'dosenNip' => $_POST['dosenNip'],
        'fileSurat' => file_get_contents($_FILES['fileSurat']['tmp_name']),
        'fileSertifikat' => file_get_contents($_FILES['fileSertifikat']['tmp_name']),
        'fileKegiatan' => file_get_contents($_FILES['fileKegiatan']['tmp_name'])
    ];

    // Query untuk menyimpan data prestasi
    $sqlInsert = "
        INSERT INTO Prestasi 
        (Peringkat, Url, TanggalMulai, TanggalBerakhir, TempatKompetisi, JudulPrestasi, TingkatPrestasi, TipePrestasi, BuktiSuratTugas, BuktiSertif, FotoKegiatan, Status, DosenNip)
        OUTPUT INSERTED.PrestasiId
        VALUES 
        (?, ?, ?, ?, ?, ?, ?, ?, CONVERT(VARBINARY(MAX), ?), CONVERT(VARBINARY(MAX), ?), CONVERT(VARBINARY(MAX), ?), ?,?)
    ";
    $params = [
        $data['peringkat'], $data['url'], $data['tanggalMulai'], $data['tanggalBerakhir'],
        $data['tempatKompetisi'], $data['judulPrestasi'], $data['tingkatPrestasi'], $data['tipePrestasi'],
        $data['fileSurat'], $data['fileSertifikat'], $data['fileKegiatan'], 'Valid', $data['dosenNip']
    ];
    $stmtPrestasi = sqlsrv_query($conn, $sqlInsert, $params);
    if ($stmtPrestasi === false) {
        echo 'Error inserting data into Prestasi: ' . print_r(sqlsrv_errors(), true);
        exit;  // Berhenti jika terjadi error pada insert Prestasi
    }
    if ($stmtPrestasi === false) {
        echo 'Error inserting data into Prestasi: ' . print_r(sqlsrv_errors(), true);
    } else {
        // Ambil id_prestasi yang baru saja disisipkan dari hasil OUTPUT
        $rowPrestasiId = sqlsrv_fetch_array($stmtPrestasi, SQLSRV_FETCH_ASSOC);
    
        if (!$rowPrestasiId || !isset($rowPrestasiId['PrestasiId'])) {
            echo 'Failed to retrieve PrestasiId. Please check your query.';
        } else {
            $id_prestasi = $rowPrestasiId['PrestasiId'];
    
            // Query untuk menyisipkan ke tabel PrestasiMahasiswa
            $queryMahasiswa = "
                INSERT INTO PrestasiMahasiswa (PrestasiId, Nim) VALUES (?, ?)
            ";
            $paramsMahasiswa = array($id_prestasi, $data['nim']);
    
            // Eksekusi query untuk tabel PrestasiMahasiswa
            $stmtMahasiswa = sqlsrv_query($conn, $queryMahasiswa, $paramsMahasiswa);
    
            if ($stmtMahasiswa === false) {
                echo 'Error inserting data into PrestasiMahasiswa: ' . print_r(sqlsrv_errors(), true);
            } else {
                echo 'Prestasi mahasiswa berhasil disimpan.';
                
            }
        }
    }

    echo "<script>alert('Prestasi berhasil ditambahkan!'); window.location.href = 'http://localhost/PBL_KEL4/public/indexadmin.php?page=dataallmhs';</script>";
    exit;
}

// Ambil data mahasiswa berdasarkan NIM yang diterima melalui GET
$nim = $_GET['nim'] ?? null;
if (!$nim) {
    die("NIM tidak ditemukan.");
}

$sqlMahasiswa = "SELECT Nama FROM Mahasiswa WHERE Nim = ?";
$paramsMahasiswa = [$nim];
$stmtMahasiswa = sqlsrv_query($conn, $sqlMahasiswa, $paramsMahasiswa);
if ($stmtMahasiswa === false || !($mahasiswa = sqlsrv_fetch_array($stmtMahasiswa, SQLSRV_FETCH_ASSOC))) {
    die("Data mahasiswa tidak ditemukan.");
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Prestasi</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center">Tambah Prestasi</h1>
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="namaMahasiswa" class="form-label">Nama Mahasiswa</label>
                <input type="text" class="form-control" id="namaMahasiswa" value="<?= htmlspecialchars($mahasiswa['Nama']); ?>" readonly>
            </div>

            <div class="mb-3">
                <label for="judulPrestasi" class="form-label">Judul Prestasi</label>
                <input type="text" class="form-control" id="judulPrestasi" name="judulPrestasi" required>
            </div>

            <div class="mb-3">
                <label for="tingkatPrestasi" class="form-label">Tingkat Prestasi</label>
                <select class="form-select" name="tingkatPrestasi" id="tingkatPrestasi" required>
                    <option selected disabled>Pilih Tingkat Kompetisi</option>
                    <option value="Kabupaten/Kota">Kabupaten/Kota</option>
                    <option value="Provinsi">Provinsi</option>
                    <option value="Nasional">Nasional</option>
                    <option value="Internasional">Internasional</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="tipePrestasi" class="form-label">Tipe Prestasi</label>
                <select class="form-select" name="tipePrestasi" id="tipePrestasi" required>
                <option selected disabled>Pilih Jenis Prestasi</option>
                <option value="Individu">Individu</option>
                <option value="Kelompok">Kelompok</option>
            </select>
            </div>

            <div class="mb-3">
                <label for="tempatKompetisi" class="form-label">Tempat Kompetisi</label>
                <input type="text" class="form-control" id="tempatKompetisi" name="tempatKompetisi" required>
            </div>

            <div class="mb-3">
                <label for="tanggalMulai" class="form-label">Tanggal Mulai</label>
                <input type="date" class="form-control" id="tanggalMulai" name="tanggalMulai" required>
            </div>

            <div class="mb-3">
                <label for="tanggalBerakhir" class="form-label">Tanggal Berakhir</label>
                <input type="date" class="form-control" id="tanggalBerakhir" name="tanggalBerakhir" required>
            </div>

            <div class="mb-3">
                <label for="peringkat" class="form-label">Peringkat</label>
                <input type="number" class="form-control" id="peringkat" name="peringkat" required>
            </div>

            <div class="mb-3">
                <label for="url" class="form-label">URL Kompetisi</label>
                <input type="url" class="form-control" id="url" name="url">
            </div>

            <div class="mb-3">
                <label for="dosenNip" class="form-label">Dosen Pembimbing</label>
                <select class="form-select" id="dosenNip" name="dosenNip" required>
                    <option value="" disabled selected>Pilih Dosen Pembimbing</option>
                    <?php foreach ($dosenList as $dosen): ?>
                        <option value="<?= htmlspecialchars($dosen['Nip']); ?>">
                            <?= htmlspecialchars($dosen['Nama']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="fileSurat" class="form-label">File Surat</label>
                <input type="file" class="form-control" id="fileSurat" name="fileSurat" accept="application/pdf" required>
            </div>

            <div class="mb-3">
                <label for="fileSertifikat" class="form-label">File Sertifikat</label>
                <input type="file" class="form-control" id="fileSertifikat" name="fileSertifikat" accept="application/pdf" required>
            </div>

            <div class="mb-3">
                <label for="fileKegiatan" class="form-label">File Kegiatan</label>
                <input type="file" class="form-control" id="fileKegiatan" name="fileKegiatan" accept="application/pdf" required>
            </div>

            <button type="submit" class="btn btn-primary mb-5">Tambah Prestasi</button>
        </form>
    </div>
</body>

</html>
