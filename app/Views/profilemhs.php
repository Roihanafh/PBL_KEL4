<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include '../config/koneksi.php';

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'mahasiswa') {
    header('Location: login.php');
    exit();
}

// Ambil NIM dari session
$nim = $_SESSION['nim'];
$message = null;

// Class Mahasiswa
class Mahasiswa {
    private $conn;
    private $nim;

    public function __construct($conn, $nim) {
        $this->conn = $conn;
        $this->nim = $nim;
    }

    // Mengambil data mahasiswa berdasarkan NIM
    public function getData() {
        $sql = "SELECT * FROM Mahasiswa WHERE Nim = ?";
        $stmt = sqlsrv_prepare($this->conn, $sql, array(&$this->nim));

        if (sqlsrv_execute($stmt)) {
            return sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
        } else {
            echo "Terjadi kesalahan saat mengambil data mahasiswa: ";
            print_r(sqlsrv_errors());
            exit();
        }
    }

    // Memperbarui data mahasiswa
    public function updateData($nama, $email, $telepon, $alamat) {
        $sql_update = "UPDATE Mahasiswa SET Nama = ?, Email = ?, NoTelp = ?, Alamat = ? WHERE Nim = ?";
        $stmt_update = sqlsrv_prepare($this->conn, $sql_update, array(&$nama, &$email, &$telepon, &$alamat, &$this->nim));

        if (sqlsrv_execute($stmt_update)) {
            return "Data berhasil diperbarui.";
        } else {
            return "Terjadi kesalahan saat memperbarui data.";
        }
    }
}

$mahasiswa = new Mahasiswa($conn, $nim);

// Jika form disubmit, proses update data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['namaMahasiswa'];
    $email = $_POST['emailMahasiswa'];
    $telepon = $_POST['teleponMahasiswa'];
    $alamat = $_POST['alamatMahasiswa'];

    $message = $mahasiswa->updateData($nama, $email, $telepon, $alamat);
}

// Ambil data mahasiswa
$data = $mahasiswa->getData();
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
