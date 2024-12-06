<?php
// Koneksi ke database
include '../config/koneksi.php'; // Pastikan koneksi.php terhubung dengan benar

// Ambil data mahasiswa
$sql = "SELECT Nim, Email, Nama, Password, ProgramStudi, Angkatan FROM Mahasiswa";
$stmt = sqlsrv_query($conn, $sql);

if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true)); // Menampilkan error jika query gagal
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Semua Mahasiswa</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <div class="subjudul-wrapper">
            <h1 class="subjudul">Data Semua Mahasiswa</h1>
        </div>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>NIM</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Password</th>
                    <th>Program Studi</th>
                    <th>Angkatan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['Nim']); ?></td>
                        <td><?= htmlspecialchars($row['Nama']); ?></td>
                        <td><?= htmlspecialchars($row['Email']); ?></td>
                        <td><?= htmlspecialchars($row['Password']); ?></td>
                        <td><?= htmlspecialchars($row['ProgramStudi']); ?></td>
                        <td><?= htmlspecialchars($row['Angkatan']); ?></td>
                        <td>
                            <a href="tambah_prestasi.php?nim=<?= urlencode($row['Nim']); ?>" class="btn btn-success btn-sm">Tambah Prestasi</a>
                            <a href="edit_mhs.php?nim=<?= urlencode($row['Nim']); ?>" class="btn btn-warning btn-sm">Edit Data</a>
                            <a href="hapus_mhs.php?nim=<?= urlencode($row['Nim']); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');">Hapus</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>