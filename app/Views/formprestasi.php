<div class="formprestasi">
    <p>Data Prestasi Mahasiswa</p>
    <hr class="line">
    <form>
        <!-- Program Studi -->
        <div class="mb-3">
            <label for="programStudi" class="form-label">Program Studi</label>
            <select class="form-select" id="programStudi">
                <option selected disabled>Pilih Program Studi</option>
            </select>
        </div>

        <!-- Jenis Kompetisi -->
        <div class="mb-3">
            <label for="jenisKompetisi" class="form-label">Jenis Kompetisi</label>
            <select class="form-select" id="jenisKompetisi">
                <option selected disabled>Pilih Jenis Kompetisi</option>
            </select>
        </div>

        <!-- Tingkat Kompetisi -->
        <div class="mb-3">
            <label for="tingkatKompetisi" class="form-label">Tingkat Kompetisi</label>
            <select class="form-select" id="tingkatKompetisi">
                <option selected disabled>Pilih Tingkat Kompetisi</option>
            </select>
        </div>

        <!-- Nama Mahasiswa dan Peran -->
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="namaMahasiswa" class="form-label">Nama Mahasiswa</label>
                <input type="text" class="form-control" id="namaMahasiswa" placeholder="Nama Mahasiswa">
            </div>
            <div class="col-md-6 mb-3">
                <label for="nim" class="form-label">NIM</label>
                <input type="text" class="form-control" id="nim" placeholder="nim">
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
                <label for="peringkatKompetisi" class="form-label">Peringkat Kompetisi</label>
                <select class="form-select" id="peringkatKompetisi">
                    <option selected disabled>Pilih Peringkat</option>
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label for="namaPembimbing" class="form-label">Nama Dosen Pembimbing</label>
                <input type="text" class="form-control" id="namaPembimbing" placeholder="Nama Pembimbing">
            </div>
        </div>

        <!-- Upload Files -->
        <div class="mb-3">
            <label for="fileSurat" class="form-label">File Surat Tugas</label>
            <input type="file" class="form-control" id="fileSurat">
        </div>

        <div class="mb-3">
            <label for="fileSertifikat" class="form-label">File Sertifikat</label>
            <input type="file" class="form-control" id="fileSertifikat">
        </div>

        <div class="mb-3">
            <label for="fileKegiatan" class="form-label">Foto Kegiatan</label>
            <input type="file" class="form-control" id="fileKegiatan">
        </div>

        <!-- Buttons -->
        <div class="d-flex justify-content-end gap-3 mt-4">
            <button type="button" class="btn btn-back" onclick="window.location.href='indexmhs.php'">Kembali</button>
            <button type="submit" class="btn btn-save">Simpan</button>
        </div>
    </form>
</div>