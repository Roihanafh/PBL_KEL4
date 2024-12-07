<?php
require_once '../app/Controllers/PrestasiController.php';
require_once '../app/Controllers/MahasiswaController.php';
require_once '../app/Controllers/DosenController.php';

$prestasiController = new PrestasiController();
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include '../config/koneksi.php';

// Periksa apakah user sudah login sebagai mahasiswa
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'mahasiswa') {
    header('Location: login.php');
    exit();
}

// Ambil NIM dari session
$nim = $_SESSION['nim'];

// Query untuk mengambil data mahasiswa
$mahasiswaController = new MahasiswaController($conn, $nim);
$data = $mahasiswaController->getMahasiswaData();

$dosenController = new DosenController($conn);
$dataDosen = $dosenController->getDosenData();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Pastikan semua form data diterima dan ditangani dengan benar
    if (isset($_FILES['fileSurat'], $_FILES['fileSertifikat'], $_FILES['fileKegiatan'])) {
        // File uploads
        $fileSuratContent = file_get_contents($_FILES['fileSurat']['tmp_name']);
        $fileSertifikatContent = file_get_contents($_FILES['fileSertifikat']['tmp_name']);
        $fileKegiatanContent = file_get_contents($_FILES['fileKegiatan']['tmp_name']);
        // Mendapatkan data dari form
        $data = [
            'nim' => $_POST['nim'],
            'programStudi' => $_POST['programStudi'],
            'tingkatKompetisi' => $_POST['tingkatKompetisi'],
            'jenisPrestasi' => $_POST['jenisPrestasi'],
            'namaMahasiswa' => $_POST['namaMahasiswa'],
            'judulKompetisi' => $_POST['judulKompetisi'],
            'tempatKompetisi' => $_POST['tempatKompetisi'],
            'urlKompetisi' => $_POST['urlKompetisi'],
            'tanggalMulai' => $_POST['tanggalMulai'],
            'tanggalBerakhir' => $_POST['tanggalBerakhir'],
            'peringkatKompetisi' => $_POST['peringkatKompetisi'],
            'namaPembimbing' => $_POST['namaPembimbing'],
            'fileSurat' => $fileSuratContent,
            'fileSertifikat' => $fileSertifikatContent,
            'fileKegiatan' => $fileKegiatanContent
        ];

        // Menyimpan data prestasi
        $prestasiController->addPrestasi($conn, $data);

        $prestasiData = $prestasiController->showRiwayat($nim);

        require_once '../app/Views/riwayat.php';
        exit(); // Jangan lupa untuk mengakhiri eksekusi script setelah redirect
    }
}

?>

<div class="formprestasi">
    <p>Data Prestasi Mahasiswa</p>
    <hr class="line">
    <form method="POST" enctype="multipart/form-data">
        <!-- Program Studi -->
        <div class="mb-3">
            <label for="programStudi" class="form-label">
                Program Studi <span class="text-danger">*</span>
            </label>
            <select class="form-select" name="programStudi" id="programStudi" required>
                <option selected disabled>Pilih Program Studi</option>
                <option value="SIB">SIB</option>
                <option value="TI">TI</option>
            </select>
        </div>

        <div class="row">
            <!-- Tingkat Kompetisi -->
            <div class="col-md-6 mb-3">
                <label for="tingkatKompetisi" class="form-label">
                    Tingkat Kompetisi <span class="text-danger">*</span>
                </label>
                <select class="form-select" name="tingkatKompetisi" id="tingkatKompetisi" required>
                    <option selected disabled>Pilih Tingkat Kompetisi</option>
                    <option value="Kabupaten/Kota">Kabupaten/Kota</option>
                    <option value="Provinsi">Provinsi</option>
                    <option value="Nasional">Nasional</option>
                    <option value="Internasional">Internasional</option>
                </select>
            </div>
        </div>

        <!-- Jenis Prestasi -->
        <div class="mb-3">
            <label for="jenisPrestasi" class="form-label">
                Jenis Prestasi <span class="text-danger">*</span>
            </label>
            <select class="form-select" name="jenisPrestasi" id="jenisPrestasi" required>
                <option selected disabled>Pilih Jenis Prestasi</option>
                <option value="Individu">Individu</option>
                <option value="Kelompok">Kelompok</option>
            </select>
        </div>

        <!-- Nama Mahasiswa dan NIM -->
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="namaMahasiswa" class="form-label">
                    Nama Mahasiswa <span class="text-danger">*</span>
                </label>
                <input type="text" class="form-control" name="namaMahasiswa" id="namaMahasiswa" 
                    value="<?php echo htmlspecialchars($data['Nama']); ?>" readonly>
            </div>
            <div class="col-md-6 mb-3">
                <label for="nim" class="form-label">
                    NIM <span class="text-danger">*</span>
                </label>
                <input type="text" class="form-control" name="nim" id="nim" 
                    value="<?php echo htmlspecialchars($data['Nim']); ?>" readonly>
            </div>
        </div>


        <!-- Judul Kompetisi -->
        <div class="mb-3">
            <label for="judulKompetisi" class="form-label">Judul Kompetisi</label>
            <input type="text" class="form-control" name="judulKompetisi" id="judulKompetisi" placeholder="Judul Kompetisi">
        </div>

        <!-- Tempat Kompetisi -->
        <div class="mb-3">
            <label for="tempatKompetisi" class="form-label">Tempat Kompetisi</label>
            <input type="text" class="form-control" name="tempatKompetisi" id="tempatKompetisi" placeholder="Tempat Kompetisi">
        </div>

        <!-- URL Kompetisi -->
        <div class="mb-3">
            <label for="urlKompetisi" class="form-label">URL Kompetisi</label>
            <input type="url" class="form-control" name="urlKompetisi" id="urlKompetisi" placeholder="URL Kompetisi">
        </div>

        <!-- Tanggal -->
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="tanggalMulai" class="form-label">Tanggal Mulai</label>
                <input type="date" class="form-control" name="tanggalMulai" id="tanggalMulai">
            </div>
            <div class="col-md-6 mb-3">
                <label for="tanggalBerakhir" class="form-label">Tanggal Berakhir</label>
                <input type="date" class="form-control" name="tanggalBerakhir" id="tanggalBerakhir">
            </div>
        </div>

        <!-- Peringkat dan Pembimbing -->
         
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="peringkatKompetisi" class="form-label">
                    Peringkat Kompetisi <span class="text-danger">*</span>
                </label>
                <input type="text" class="form-control" name="peringkatKompetisi" id="peringkatKompetisi" placeholder="Peringkat Kompetisi" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="namaPembimbing" class="form-label">Nama Dosen Pembimbing <span class="text-danger">*</span></label>
                    <select class="form-select" name="namaPembimbing" id="namaPembimbing" required>
                        <option selected disabled>Pilih Dosen Pembimbing</option>
                        <?php foreach ($dataDosen as $dosen): ?>
                            <option value="<?= htmlspecialchars($dosen['Nip']) ?>">
                                <?= htmlspecialchars($dosen['Nama']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
            </div>
        </div>


        <!-- Upload Files -->
        <div class="mb-3">
    <label for="fileSurat" class="form-label">
        File Surat Tugas <span class="text-danger">*</span>
    </label>
    <input type="file" class="form-control" id="fileSurat" accept="application/pdf" required>
    <small id="fileSuratError" class="text-danger d-none">
        Ukuran file maksimal 2MB. File harus berformat PDF dan ukuran maksimal 2MB.
    </small>
</div>

<div class="mb-3">
    <label for="fileSertifikat" class="form-label">
        File Sertifikat <span class="text-danger">*</span>
    </label>
    <input type="file" class="form-control" id="fileSertifikat" accept="application/pdf" required>
    <small id="fileSertifikatError" class="text-danger d-none">
        Ukuran file maksimal 2MB. File harus berformat PDF dan ukuran maksimal 2MB.
    </small>
</div>

<div class="mb-3">
    <label for="fileKegiatan" class="form-label">
        Foto Kegiatan <span class="text-danger">*</span>
    </label>
    <input type="file" class="form-control" id="fileKegiatan" accept="application/pdf" required>
    <small id="fileKegiatanError" class="text-danger d-none">
        Ukuran file maksimal 2MB. File harus berformat PDF dan ukuran maksimal 2MB.
    </small>
</div>

<script>
    document.querySelectorAll('input[type="file"]').forEach(input => {
        input.addEventListener('change', function () {
            const file = this.files[0];
            const errorElement = document.getElementById(this.id + 'Error');
            if (file) {
                const isPDF = file.type === "application/pdf";
                const isSizeValid = file.size <= 2 * 1024 * 1024; // 2MB
                
                if (!isPDF || !isSizeValid) {
                    errorElement.classList.remove('d-none');
                    this.value = ''; // Clear the file input
                } else {
                    errorElement.classList.add('d-none');
                }
            }
        });
    });
</script>