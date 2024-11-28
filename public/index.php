<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Informasi Prestasi Mahasiswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/style2.css">
    <link rel="stylesheet" href="../assets/popUp.js">
    <script src="../assets/popUp.js"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <!-- Bootstrap Bundle JS (termasuk Popper.js) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</head>

<body>
    <!-- Navbar -->
    <div class="navbar">
        <div class="logo">
            <img src="../assets/logo_polinema.png" alt="Logo Lencana">
            <b>Lencana</b>
        </div>
        <div>
            <a href="#">Beranda</a>
            <a href="">Telusuri Prestasi</a>
            <a href="#">Tentang Kami</a>
            <a href="#">Kontak</a>
            <!-- <a href="#" class="login">Login</a> -->
            <button class="login" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@mdo">Login</button>
        </div>
    </div>
    <!-- isi landing page -->
    <!-- Beranda -->
    <div class="container-fluid">
        <div class="beranda">
            <div class="berandakiri">

                <div class="h1 si">
                    SISTEM <br>INFORMASI <span class="ps">PRESTASI MAHASISWA</span>
                </div>
                <p class="deskripsi">
                    Mahasiswa Politeknik Negeri Malang disiapkan untuk dapat bekerja maupun menjadi wirausaha yang sukses. Untuk itu, aktif dalam berbagai kegiatan lomba merupakan salah satu cara untuk mengasah kemampuan dan bakat para mahasiswa.
                </p>
            </div>
            <div class="berandakanan">

            </div>
        </div>
    </div>
















    <!-- Popup -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 strong" id="exampleModalLabel">Login Account</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="recipient-name" class="col-form-label">NIM/NIP</label>
                            <input type="text" class="form-control" id="recipient-name">
                        </div>
                        <div class="mb-3">
                            <label for="message-text" class="col-form-label">Password</label>
                            <input type="password" class="form-control" id="recipient-name">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary uwb">Sign In</button>
                </div>
            </div>
        </div>
    </div>






</body>

</html>