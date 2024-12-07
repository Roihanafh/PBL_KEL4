<?php
require_once '../app/Controllers/PrestasiController.php';

$prestasiController = new PrestasiController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Pastikan semua form data diterima dan ditangani dengan benar
    if (isset($_FILES['fileSurat'], $_FILES['fileSertifikat'], $_FILES['fileKegiatan'])) {
        // Mendapatkan data dari form
        $data = [
            'nim' => $_POST['nim'],
            'programStudi' => $_POST['programStudi'],
            'jenisKompetisi' => $_POST['jenisKompetisi'],
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
        ];

        // Menyimpan file yang diupload
        $suratPath = 'uploads/' . $_FILES['fileSurat']['name'];
        move_uploaded_file($_FILES['fileSurat']['tmp_name'], $suratPath);
        
        $sertifikatPath = 'uploads/' . $_FILES['fileSertifikat']['name'];
        move_uploaded_file($_FILES['fileSertifikat']['tmp_name'], $sertifikatPath);
        
        $kegiatanPath = 'uploads/' . $_FILES['fileKegiatan']['name'];
        move_uploaded_file($_FILES['fileKegiatan']['tmp_name'], $kegiatanPath);

        // Menambahkan file paths ke data
        $data['fileSurat'] = $suratPath;
        $data['fileSertifikat'] = $sertifikatPath;
        $data['fileKegiatan'] = $kegiatanPath;

        // Menyimpan data prestasi
        $prestasiController->addPrestasi($data);
        echo "Prestasi berhasil disimpan!";
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

        <!-- Jenis Kompetisi -->
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="jenisKompetisi" class="form-label">
                    Jenis Kompetisi <span class="text-danger">*</span>
                </label>
                <input type="text" class="form-control" name="jenisKompetisi" id="jenisKompetisi" placeholder="Jenis Kompetisi" required>
            </div>

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
                <option value="pribadi">Pribadi</option>
                <option value="kelompok">Kelompok</option>
            </select>
        </div>

        <!-- Nama Mahasiswa dan Peran -->
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="namaMahasiswa" class="form-label">
                    Nama Mahasiswa <span class="text-danger">*</span>
                </label>
                <input type="text" class="form-control" name="namaMahasiswa" id="namaMahasiswa" placeholder="Nama Mahasiswa" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="nim" class="form-label">
                    NIM <span class="text-danger">*</span>
                </label>
                <input type="text" class="form-control" name="nim" id="nim" placeholder="NIM" required>
            </div>
        </div>

        <!-- Upload File Surat, Sertifikat, dan Kegiatan -->
        <div class="mb-3">
            <label for="fileSurat" class="form-label">
                Surat Pengantar <span class="text-danger">*</span>
            </label>
            <input type="file" class="form-control" name="fileSurat" id="fileSurat" required>
        </div>

        <div class="mb-3">
            <label for="fileSertifikat" class="form-label">
                Sertifikat <span class="text-danger">*</span>
            </label>
            <input type="file" class="form-control" name="fileSertifikat" id="fileSertifikat" required>
        </div>

        <div class="mb-3">
            <label for="fileKegiatan" class="form-label">
                Foto Kegiatan <span class="text-danger">*</span>
            </label>
            <input type="file" class="form-control" name="fileKegiatan" id="fileKegiatan" required>
        </div>

        <div class="mb-3 text-end">
            <button type="submit" class="btn btn-primary">
                Simpan Prestasi
            </button>
        </div>
    </form>
</div>

<script>
    function redirectToFormPrestasi() {
        window.location.href = 'formprestasi.php';
    }
</script>
