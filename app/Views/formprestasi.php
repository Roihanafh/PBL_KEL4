<?php
include '../app/Controllers/MahasiswaController.php'; // Panggil controller untuk mengambil data dan memproses form
?>

<div class="profilemhs">
    <p>Profile Saya</p>
    <hr class="line">
    <form method="POST">
        <!-- Nama Mahasiswa -->
        <div class="mb-3">
            <label for="namaMahasiswa" class="form-label">Nama Mahasiswa</label>
            <input type="text" name="namaMahasiswa" id="namaMahasiswa" class="form-control" value="<?php echo $data['Nama']; ?>" disabled>
        </div>

        <!-- NIM -->
        <div class="mb-3">
            <label for="nimMahasiswa" class="form-label">NIM</label>
            <input type="text" name="nimMahasiswa" id="nimMahasiswa" class="form-control" value="<?php echo $data['Nim']; ?>" disabled>
        </div>

        <!-- Email -->
        <div class="mb-3">
            <label for="emailMahasiswa" class="form-label">Email</label>
            <input type="email" name="emailMahasiswa" id="emailMahasiswa" class="form-control" value="<?php echo $data['Email']; ?>" disabled>
        </div>

        <!-- Nomor Telepon -->
        <div class="mb-3">
            <label for="teleponMahasiswa" class="form-label">Nomor Telepon</label>
            <input type="text" name="teleponMahasiswa" id="teleponMahasiswa" class="form-control" value="<?php echo $data['NoTelp']; ?>" disabled>
        </div>

        <!-- Alamat -->
        <div class="mb-3">
            <label for="alamatMahasiswa" class="form-label">Alamat</label>
            <textarea name="alamatMahasiswa" id="alamatMahasiswa" class="form-control" rows="3" disabled><?php echo $data['Alamat']; ?></textarea>
        </div>

        <!-- Tombol Aksi -->
        <div class="text-end">
            <button type="button" id="ubahDataBtn" class="btn btn-primary">Ubah Data</button>
            <button type="submit" id="simpanDataBtn" class="btn btn-success" style="display: none;">Simpan Data</button>
        </div>
    </form>
</div>

<script>
    // Ambil pesan dari PHP
    const message = <?php echo json_encode($message); ?>;
    if (message) {
        alert(message); // Tampilkan pop-up
    }

    const ubahButton = document.getElementById('ubahDataBtn');
    const simpanButton = document.getElementById('simpanDataBtn');
    const inputs = document.querySelectorAll('#namaMahasiswa, #emailMahasiswa, #teleponMahasiswa, #alamatMahasiswa');

    ubahButton.addEventListener('click', function () {
        inputs.forEach(input => input.disabled = false);
        ubahButton.style.display = 'none';
        simpanButton.style.display = 'inline-block';
    });
</script>
