<?php
require_once '../app/Controllers/PrestasiController.php';

// Mulai sesi untuk mendapatkan NIM yang sedang login
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include '../config/koneksi.php';
$nim = $_SESSION['nim'];

$controller = new PrestasiController();
$prestasiData = $controller->showRiwayat($nim);

require_once '../app/Views/riwayat.php';

?>

<div class="riwayat">
    <div class="container mt-5">
        <p>Data Prestasi</p>
        <hr class="line">
        <div class="mb-3">
            <button class="button" onclick="redirectToFormPrestasi()">
                <i class="fas fa-plus"></i> 
                Data Baru
            </button>
        </div>
        <div class="table-responsive">
            <table id="dataPrestasi" class="table table-striped table-bordered">
                <thead class="table-primary text-center">
                    <tr>
                        <th>No</th>
                        <th>NIM</th>
                        <th>Nama</th>
                        <th>Judul Kompetisi</th>
                        <th>Tingkat</th>
                        <th>Peringkat</th>
                        <th>Tahun</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
    <?php if (!empty($prestasiData)): ?>
        <?php $no = 1; ?>
        <?php foreach ($prestasiData as $row): ?>
            <tr>
                <td><?php echo $no++; ?></td>
                <td><?php echo htmlspecialchars($row['Nim']); ?></td>
                <td><?php echo htmlspecialchars($row['Nama']); ?></td>
                <td><?php echo htmlspecialchars($row['JudulPrestasi']); ?></td>
                <td><?php echo htmlspecialchars($row['TingkatPrestasi']); ?></td>
                <td><?php echo htmlspecialchars($row['Peringkat']); ?></td>
                <td><?php echo htmlspecialchars($row['Tahun']); ?></td>
                <td>
                    <?php 
                        $status = htmlspecialchars($row['Status']);
                        if ($status != 'Valid') {
                            echo '<span class="text-danger">
                                Status Tidak Valid - 
                                <a href="mailto:zilanzalilan18@gmail.com?subject=Status Tidak Valid&body=Halo admin, mohon bantuan terkait status prestasi saya. Berikut detail prestasi: Nama: ' . htmlspecialchars($row['Nama']) . ', NIM: ' . htmlspecialchars($row['Nim']) . '" class="btn btn-sm btn-danger">
                                Hubungi Admin</a>
                            </span>';
                        } else {
                            echo $status;
                        }
                    ?>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="8" class="text-center">Data tidak ditemukan</td>
        </tr>
    <?php endif; ?>
</tbody>
            </table>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        // Cek setiap baris apakah status tidak valid
        $('#dataPrestasi tbody tr').each(function() {
            var status = $(this).find('td:last').text().trim(); // Mengambil teks dari kolom status
            if (status !== 'Valid') {
                alert('Status Tidak Valid - Hubungi Admin');
            }
        });

        $('#dataPrestasi').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
            "lengthMenu": [5, 10, 25, 50, 100],
            "language": {
                "lengthMenu": "Tampilkan _MENU_ entri",
                "zeroRecords": "Data tidak ditemukan",
                "info": "Menampilkan _START_ hingga _END_ dari _TOTAL_ entri",
                "infoEmpty": "Tidak ada entri yang tersedia",
                "infoFiltered": "(difilter dari total _MAX_ entri)",
                "search": "Cari:",
                "paginate": {
                    "first": "Pertama",
                    "last": "Terakhir",
                    "next": "Berikutnya",
                    "previous": "Sebelumnya"
                }
            }
        });
    });
</script>



