<?php
// Koneksi ke database
include '../../config/koneksi.php';

// Ambil NIM dari URL
$nim = $_GET['nim'] ?? null;

if ($nim === null) {
    die("NIM tidak ditemukan.");
}

// Ambil data mahasiswa berdasarkan NIM
$sql = "SELECT Nim, Nama, Email, Password, ProgramStudi, Angkatan FROM Mahasiswa WHERE Nim = ?";
$params = [$nim];
$stmt = sqlsrv_query($conn, $sql, $params);

if ($stmt === false || sqlsrv_has_rows($stmt) === false) {
    die("Data mahasiswa tidak ditemukan.");
}

// Ambil data mahasiswa
$data = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Mahasiswa</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h1>Edit Data Mahasiswa</h1>
        <form action="update_mhs.php" method="post">
            <input type="hidden" name="Nim" value="<?= htmlspecialchars($data['Nim']); ?>">

            <div class="mb-3">
                <label for="Nama" class="form-label">Nama</label>
                <input type="text" class="form-control" id="Nama" name="Nama" value="<?= htmlspecialchars($data['Nama']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="Email" class="form-label">Email</label>
                <input type="email" class="form-control" id="Email" name="Email" value="<?= htmlspecialchars($data['Email']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="Password" class="form-label">Password</label>
                <input type="text" class="form-control" id="Password" name="Password" value="<?= htmlspecialchars($data['Password']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="ProgramStudi" class="form-label">Program Studi</label>
                <input type="text" class="form-control" id="ProgramStudi" name="ProgramStudi" value="<?= htmlspecialchars($data['ProgramStudi']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="Angkatan" class="form-label">Angkatan</label>
                <input type="number" class="form-control" id="Angkatan" name="Angkatan" value="<?= htmlspecialchars($data['Angkatan']); ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            <a href="/PBL_KEL4/public/indexadmin.php?page=dataallmhs" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</body>

</html>
