<div class="profiledosen">
    <p>Profile Saya</p>
    <hr class="line">
    <form>
        <!-- Nama Dosen dan NIP -->
        <div class="mb-3">
            <label for="namaDosen" class="form-label">Nama Dosen</label>
            <input type="text" id="namaDosen" class="form-control" placeholder="Nama Dosen" value="" disabled>
        </div>

        <div class="mb-3">
            <label for="nipDosen" class="form-label">NIP</label>
            <input type="text" id="nipDosen" class="form-control" placeholder="NIP" value="" disabled>
        </div>
        
        <!-- Email dan Nomor Telepon -->
        <div class="mb-3">
            <label for="emailDosen" class="form-label">Email</label>
            <input type="email" id="emailDosen" class="form-control" placeholder="Email Dosen" value="" disabled>
        </div>
        
        <div class="mb-3">
            <label for="teleponDosen" class="form-label">Nomor Telepon</label>
            <input type="text" id="teleponDosen" class="form-control" placeholder="Nomor Telepon" value="" disabled>
        </div>
        
        <!-- Alamat -->
        <div class="mb-3">
            <label for="alamatDosen" class="form-label">Alamat</label>
            <textarea id="alamatDosen" class="form-control" rows="3" placeholder="Alamat" disabled></textarea>
        </div>
        
        <!-- Tombol Aksi -->
        <div class="text-end">
            <button type="button" id="ubahDataDosenBtn" class="btn btn-primary">Ubah Data</button>
        </div>
    </form>
</div>

<script>
    const buttonDosen = document.getElementById('ubahDataDosenBtn');
    const inputsDosen = document.querySelectorAll('#namaDosen, #nipDosen, #emailDosen, #teleponDosen, #alamatDosen');

    buttonDosen.addEventListener('click', function () {
        if (buttonDosen.textContent === 'Ubah Data') {
            // Aktifkan elemen dengan menghapus atribut disabled
            inputsDosen.forEach(input => {
                input.disabled = false;
            });
            // Ubah teks tombol menjadi "Simpan Data"
            buttonDosen.textContent = 'Simpan Data';
        } else {
            // Simpan data dan kunci kembali elemen
            inputsDosen.forEach(input => {
                input.disabled = true;
            });
            alert('Data berhasil disimpan!'); // Notifikasi sederhana
            buttonDosen.textContent = 'Ubah Data'; // Ubah kembali teks tombol
        }
    });
</script>
