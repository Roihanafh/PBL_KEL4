<?php
include '../config/koneksi.php'; // Pastikan file koneksi sudah benar

// Query untuk mengambil data dari Prestasi dan Mahasiswa
$sql = "
    SELECT TOP 15
        m.Nama, 
        p.JudulPrestasi, 
        p.TanggalBerakhir, 
        p.Peringkat, 
        p.TingkatPrestasi, 
        p.TipePrestasi
    FROM 
        Prestasi p
    JOIN PrestasiMahasiswa pm ON p.PrestasiId = pm.PrestasiId
    JOIN Mahasiswa m ON pm.Nim = m.Nim;
";


// Menjalankan query
$stmt = sqlsrv_query($conn, $sql);

// Cek jika query berhasil
if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}
?>

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
            <a href="#beranda">Beranda</a>
            <a href="#telusuri">Telusuri Prestasi</a>
            <a href="#tentang">Tentang Kami</a>
            <a href="#kontak">Kontak</a>
            <!-- <a href="#" class="login">Login</a> -->
            <button class="login" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@mdo">Login</button>
        </div>
    </div>
    <!-- isi landing page -->
    <!-- Beranda -->
    <div class="container-fluid" id="beranda">
        <div class="beranda">
            <div class="berandakiri">
                <div class="isibk">
                    <div class="h1 si">
                        SISTEM <br>INFORMASI <span class="ps">PRESTASI MAHASISWA</span>
                    </div>
                    <p class="deskripsi">
                        Mahasiswa Politeknik Negeri Malang disiapkan untuk dapat bekerja maupun menjadi wirausaha yang sukses. Untuk itu, aktif dalam berbagai kegiatan lomba merupakan salah satu cara untuk mengasah kemampuan dan bakat para mahasiswa.
                    </p>
                </div>
            </div>
            <div class="berandakanan">
                <img class="abstract" src="../assets/abstract.png" alt="Gambar Beranda">
                <div class="imglomba">
                    <img src="../assets/lomba1.jpeg" alt="Lomba" class="lomba lomba1">
                    <img src="../assets/lomba2.jpeg" alt="Lomba" class="lomba lomba2">
                </div>
            </div>
        </div>
    </div>

    <!-- Telusuri Prestasi -->

    <div class="container-fluid">
        <div class="telusuriprestasi" id="telusuri">
            <div class="raihpres">
                <p class="ps2">Prestasi</p>
                <h1>Prestasi <span class="ps2">yang Telah di Raih oleh</span> Mahasiswa</h1>
            </div>
            <div class="container">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Judul Kompetisi</th>
                                <th>Tanggal</th>
                                <th>Peringkat</th>
                                <th>Tingkat</th>
                                <th>Tipe Prestasi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            $rowCount = 0;

                            // Menampilkan hasil query
                            while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                                echo "<tr>
                                <td>{$no}</td>
                                <td>" . (!empty($row['Nama']) ? $row['Nama'] : '-') . "</td>
                                <td>" . (!empty($row['JudulPrestasi']) ? $row['JudulPrestasi'] : '-') . "</td>
                                <td>" . (!empty($row['TanggalBerakhir']) ? $row['TanggalBerakhir']->format('Y-m-d') : '-') . "</td>
                                <td>" . (!empty($row['Peringkat']) ? $row['Peringkat'] : '-') . "</td>
                                <td>" . (!empty($row['TingkatPrestasi']) ? $row['TingkatPrestasi'] : '-') . "</td>
                                <td>" . (!empty($row['TipePrestasi']) ? $row['TipePrestasi'] : '-') . "</td>
                                </tr>";
                                $no++;
                                $rowCount++;
                            }

                            // Jika jumlah data kurang dari 15, tambahkan baris kosong dengan tanda '-'
                            while ($rowCount < 15) {
                                echo "<tr>
                                <td>{$no}</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                </tr>";
                                $no++;
                                $rowCount++;
                            }
                            ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="about mt-5" id="tentang">
            <div class="about-content">
                <h1>Tentang Kami</h1>
                <p>Prodi Manajemen Informatika (DIII) Politeknik Negeri Malang berdiri pada 24 Juni 2005 berdasarkan SK Mendiknas No. 2001/D/T/2005 di bawah Jurusan Teknik Elektro. Kurikulum awalnya menyesuaikan perkembangan TI dan kebutuhan kerja, dan sejak 2006/2007 menggunakan kurikulum 5-1 (5 semester di kampus, 1 semester di industri) dengan total 120 SKS.
                    <br><br>
                    Pada 2022, melalui program upgrading Kemendikbudristek, Prodi Manajemen Informatika ditingkatkan menjadi Prodi Sarjana Terapan Sistem Informasi Bisnis berdasarkan SK Mendikbudristek No. 33/D/OT/2022. Prodi baru ini mulai menerima mahasiswa pada Semester Ganjil 2022/2023 di bawah Jurusan Teknologi Informasi.
                </p>
            </div>
            <div class="imgtk">
                <img src="../assets/informatika.jpeg" alt="Teknik Informatika">
                <img src="../assets/sistem.jpg" alt="Sistem Informasi Bisnis">
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="kontak" id="kontak">
            <div class="hubungi">
                <p>Hubungi Kami</p>
                <br>
                <p>Alamat: <a class="wi" href="https://www.google.com/maps/search/?api=1&query=Politeknik+Negeri+Malang,+Jl.+Soekarno+Hatta+No.9,+Malang,+Jawa+Timur+65141" target="_blank" rel="noopener noreferrer">Politeknik Negeri Malang, Jl. Soekarno Hatta No.9, Malang, Jawa Timur 65141</a></p>
                <p>Telpon: <span class="wi">0341404424</span></p>
                <p>Email: <span class="wi">humas@polinema.ac.id</span></p>
            </div>
            <div class="tautan">
                <p>Tautan Penting</p>
                <br>
                <p>Panduan Pendaftaran</p>
                <p>FAQ</p>
                <p>Kebijakan Privasi</p>
            </div>
            <div class="follow">
                <b>Ikuti Kami</b>
                <div class="followlogo">
                    <i class="bi bi-facebook"></i>
                    <i class="bi bi-linkedin"></i>
                    <i class="bi bi-twitter"></i>
                </div>
            </div>
        </div>
    </div>

    <footer>
        <p>Polinema © 2024. All Rights Reserved</p>
    </footer>

















    <!-- Popup -->
    <form action="../login.php" method="POST">
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
                                <input type="text" class="form-control" id="username" name="username" required>
                            </div>
                            <div class="mb-3">
                                <label for="message-text" class="col-form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary uwb">Sign In</button>
                    </div>
                </div>
            </div>
        </div>
    </form>






</body>

</html>