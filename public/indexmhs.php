<?php
session_start();
require_once '../app/Controllers/PrestasiController.php';

$prestasiController = new PrestasiController();
$nimLogin = $_SESSION['nim'];

// Mengecek apakah mahasiswa sudah memiliki data prestasi
$hasPrestasi = $prestasiController->checkPrestasi($nimLogin);

$page = isset($_GET['page']) ? $_GET['page'] : 'home'; // Default to 'home' if no page is specified

if ($page === 'prestasi') {
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
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <link rel="stylesheet" href="../assets/style3.css">
    <script>
    function toggleSidebar() {
        const sidebar = document.querySelector('.sidebar');
        const header = document.querySelector('.header');
        const container = document.querySelector('.container');
        const addPrestasi = document.querySelector('.addprestasi'); 
        
        sidebar.classList.toggle('responsive');
        header.classList.toggle('responsive');
        addPrestasi.classList.toggle('responsive'); 
    }
    function redirectToFormPrestasi() {
        window.location.href = 'indexmhs.php?page=formprestasi';
    }
</script>
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
