<?php
session_start();
include('../config/koneksi.php');

$page = isset($_GET['page']) ? $_GET['page'] : 'home'; // Default to 'home' if no page is specified
$nimLogin = $_SESSION['nim'];

// Mengecek apakah mahasiswa sudah memiliki data prestasi
$hasPrestasi = false;

if ($page === 'prestasi') {
    $sqlCheck = "SELECT COUNT(*) AS Jumlah FROM PrestasiMahasiswa WHERE Nim = ?";
    $params = array($nimLogin);
    $stmt = sqlsrv_query($conn, $sqlCheck, $params);

    if ($stmt && $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        $hasPrestasi = $row['Jumlah'] > 0; // true jika memiliki data prestasi
    }
    
    // Arahkan ke halaman yang sesuai
    $page = $hasPrestasi ? 'riwayat' : 'prestasi';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lencana</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../assets/style3.css">
</head>
<body>
    <?php include('../assets/header.php'); ?>
    <?php include('../assets/sidebarmhs.php'); ?>

    <div class="content-wrapper">
        <?php
        switch (strtolower($page)) {
            case 'home':
                include('../app/Views/home.php');
                break;
            case 'riwayat':
                include('../app/Views/riwayat.php');
                break;
            case 'prestasi':
                include('../app/Views/prestasi.php');
                break;
            case 'formprestasi':
                include('../app/Views/formprestasi.php');
                break;
            case 'profile':
                include('../app/Views/profilemhs.php');
                break;
            default:
                echo '<div>Page not found.</div>';
                break;
        }
        ?>
    </div>
</body>
</html>
