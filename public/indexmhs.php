<?php
$page = isset($_GET['page']) ? $_GET['page'] : 'home'; // Default to 'home' if no page is specified
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
    <link rel="stylesheet" href="../assets/style.css">
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
        switch(strtolower($page)){
            case 'home':
                include('../app/Views/home.php');
                break;
            case 'prestasi':
                include('../app/Views/prestasi.php');
                break;
            case 'formprestasi':
                include('../app/Views/formprestasi.php'); 
                break;
            default:
                echo '<div>Page not found.</div>';
                break;
        }
        ?>
    </div>
</body>
</html>
