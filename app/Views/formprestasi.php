<div class="formprestasi">
    <p>Data Prestasi Mahasiswa</p>
    <hr class="line">
    <form>
        <!-- Program Studi -->
<div class="mb-3">
    <label for="programStudi" class="form-label">
        Program Studi <span class="text-danger">*</span>
    </label>
    <select class="form-select" id="programStudi" required>
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
    <input type="text" class="form-control" id="jenisKompetisi" placeholder="Jenis Kompetisi" required>
</div>

<!-- Tingkat Kompetisi -->
<div class="mb-3">
    <label for="tingkatKompetisi" class="form-label">
        Tingkat Kompetisi <span class="text-danger">*</span>
    </label>
    <select class="form-select" id="tingkatKompetisi" required>
        <option selected disabled>Pilih Tingkat Kompetisi</option>
        <option value="Kabupaten/Kota">Kabupaten/Kota</option>
        <option value="Provinsi">Provinsi</option>
        <option value="Nasional">Nasional</option>
        <option value="Internasional">Internasional</option>
    </select>
</div>

<!-- Jenis Prestasi -->
<div class="mb-3">
    <label for="jenisPrestasi" class="form-label">
        Jenis Prestasi <span class="text-danger">*</span>
    </label>
    <select class="form-select" id="jenisPrestasi" required>
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
        <input type="text" class="form-control" id="namaMahasiswa" placeholder="Nama Mahasiswa" required>
    </div>
    <div class="col-md-6 mb-3">
        <label for="nim" class="form-label">
            NIM <span class="text-danger">*</span>
        </label>
        <input type="text" class="form-control" id="nim" placeholder="NIM" required>
    </div>
</div>

        <!-- Judul Kompetisi -->
        <div class="mb-3">
            <label for="judulKompetisi" class="form-label">Judul Kompetisi</label>
            <input type="text" class="form-control" id="judulKompetisi" placeholder="Judul Kompetisi">
        </div>

        <!-- Tempat Kompetisi -->
        <div class="mb-3">
            <label for="tempatKompetisi" class="form-label">Tempat Kompetisi</label>
            <input type="text" class="form-control" id="tempatKompetisi" placeholder="Tempat Kompetisi">
        </div>

        <!-- URL Kompetisi -->
        <div class="mb-3">
            <label for="urlKompetisi" class="form-label">URL Kompetisi</label>
            <input type="url" class="form-control" id="urlKompetisi" placeholder="URL Kompetisi">
        </div>

        <!-- Tanggal -->
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="tanggalMulai" class="form-label">Tanggal Mulai</label>
                <input type="date" class="form-control" id="tanggalMulai">
            </div>
            <div class="col-md-6 mb-3">
                <label for="tanggalBerakhir" class="form-label">Tanggal Berakhir</label>
                <input type="date" class="form-control" id="tanggalBerakhir">
            </div>
        </div>

        <!-- Peringkat dan Pembimbing -->
        <div class="row">
    <div class="col-md-6 mb-3">
        <label for="peringkatKompetisi" class="form-label">
            Peringkat Kompetisi <span class="text-danger">*</span>
        </label>
        <input type="text" class="form-control" id="peringkatKompetisi" placeholder="Peringkat Kompetisi" required>
    </div>
    <div class="col-md-6 mb-3">
        <label for="namaPembimbing" class="form-label">
            Nama Dosen Pembimbing <span class="text-danger">*</span>
        </label>
        <input type="text" class="form-control" id="namaPembimbing" placeholder="Nama Pembimbing" required>
    </div>
</div>

        <!-- Upload Files -->
        <div class="mb-3">
    <label for="fileSurat" class="form-label">
        File Surat Tugas <span class="text-danger">*</span>
    </label>
    <input type="file" class="form-control" id="fileSurat" accept="application/pdf" required>
    <small id="fileSuratError" class="text-danger d-none">
        File harus berformat PDF dan ukuran maksimal 2MB.
    </small>
</div>

<div class="mb-3">
    <label for="fileSertifikat" class="form-label">
        File Sertifikat <span class="text-danger">*</span>
    </label>
    <input type="file" class="form-control" id="fileSertifikat" accept="application/pdf" required>
    <small id="fileSertifikatError" class="text-danger d-none">
        File harus berformat PDF dan ukuran maksimal 2MB.
    </small>
</div>

<div class="mb-3">
    <label for="fileKegiatan" class="form-label">
        Foto Kegiatan <span class="text-danger">*</span>
    </label>
    <input type="file" class="form-control" id="fileKegiatan" accept="application/pdf" required>
    <small id="fileKegiatanError" class="text-danger d-none">
        File harus berformat PDF dan ukuran maksimal 2MB.
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

        <!-- Buttons -->
        <div class="d-flex justify-content-end gap-3 mt-4">
            <button type="button" class="btn btn-back" onclick="window.location.href='indexmhs.php'">Kembali</button>
            <button type="submit" class="btn btn-save">Simpan</button>
        </div>
    </form>
</div>