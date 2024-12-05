<!-- Halaman Index Dosen dengan Data Mahasiswa dan Prestasi -->
<div class="index-dosen">
    <p class="title">Profile Dosen</p>
    <hr class="line">
    <form class="profile-form">
        <!-- Nama Dosen dan NIP -->
        <div class="mb-3">
            <label for="namaDosen" class="form-label">Nama Dosen</label>
            <input type="text" id="namaDosen" class="form-control" placeholder="Nama Dosen" value="" disabled>
        </div>

        <div class="mb-3">
            <label for="nipDosen" class="form-label">NIP</label>
            <input type="text" id="nipDosen" class="form-control" placeholder="NIP" value="" disabled>
        </div>
    </form>

    <h3 class="subtitle">Mahasiswa Bimbingan</h3>
    <div class="table-container">
        <table class="table-mahasiswa">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Mahasiswa</th>
                    <th>NIM</th>
                    <th>Email</th>
                    <th>Jumlah Lomba Diikuti</th>
                    <th>Total Poin</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Sambungkan ke database
                include '../config/koneksi.php';

                // Query untuk mendapatkan mahasiswa bimbingan dan prestasi
                $nipDosen = '12345678'; // Ganti sesuai NIP Dosen yang aktif
                $sql = "
                    SELECT 
                        ROW_NUMBER() OVER (ORDER BY SUM(P.Poin) DESC) AS Ranking,
                        M.Nama AS NamaMahasiswa,
                        M.Nim,
                        M.Email,
                        COUNT(PM.PrestasiId) AS JumlahLombaDiikuti,
                        SUM(P.Poin) AS TotalPoin
                    FROM 
                        Mahasiswa M
                    JOIN 
                        PrestasiMahasiswa PM ON M.Nim = PM.Nim
                    JOIN 
                        Prestasi P ON PM.PrestasiId = P.PrestasiId
                    WHERE 
                        P.Status = 'Valid' AND M.nip_dosen = ?
                    GROUP BY 
                        M.Nama, M.Nim, M.Email
                    ORDER BY    
                        TotalPoin DESC;
                ";

                $stmt = sqlsrv_prepare($conn, $sql, [$nipDosen]);
                sqlsrv_execute($stmt);

                // Cek jika query gagal
                if ($stmt === false) {
                    die(print_r(sqlsrv_errors(), true));
                }

                $no = 1;
                while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                    echo "<tr>";
                    echo "<td>" . $no++ . "</td>";
                    echo "<td>" . htmlspecialchars($row['NamaMahasiswa']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['Nim']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['Email']) . "</td>";
                    echo "<td>" . $row['JumlahLombaDiikuti'] . "</td>";
                    echo "<td>" . $row['TotalPoin'] . "</td>";
                    echo "</tr>";
                }

                sqlsrv_free_stmt($stmt);
                ?>
            </tbody>
        </table>
    </div>
</div>