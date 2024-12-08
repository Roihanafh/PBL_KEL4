<?php

require_once 'Model.php';


class PrestasiModel extends Model {

    public function getPrestasiByNIM($nim) {
        $sql = "SELECT COUNT(*) AS Jumlah FROM PrestasiMahasiswa WHERE Nim = ?";
        $params = [$nim];
        $stmt = $this->query($sql, $params);
        if ($stmt && $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            return $row['Jumlah'] > 0;
        }
        return false;
    }

    public function getRiwayatPrestasiMahasiswa($nim) {
        $sql = "
            SELECT 
                PM.Nim,
                M.Nama,
                P.JudulPrestasi,
                P.TingkatPrestasi,
                P.Peringkat,
                YEAR(P.TanggalMulai) AS Tahun,
                P.Status
            FROM 
                PrestasiMahasiswa PM
            JOIN 
                Mahasiswa M ON PM.Nim = M.Nim
            JOIN 
                Prestasi P ON PM.PrestasiId = P.PrestasiId
            WHERE 
                PM.Nim = ?
            ORDER BY 
                P.TanggalMulai DESC;
        ";
        
        $params = [$nim];
        $stmt = $this->query($sql, $params);
        
        if ($stmt) {
            $results = [];
            while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                $results[] = $row;
            }
            return $results;
        }
    
        return [];
    }
    
    
    public function addPrestasi($conn, $data) {
        // Query untuk insert data ke tabel PrestasiMahasiswa
        $sql = "INSERT INTO Prestasi 
        (Peringkat, Url, TanggalMulai, TanggalBerakhir, TempatKompetisi, JudulPrestasi, TingkatPrestasi, TipePrestasi, BuktiSuratTugas, BuktiSertif, FotoKegiatan, Status, DosenNip)
        OUTPUT INSERTED.PrestasiId
        VALUES 
        (?, ?, ?, ?, ?, ?, ?, ?, CONVERT(VARBINARY(MAX), ?), CONVERT(VARBINARY(MAX), ?), CONVERT(VARBINARY(MAX), ?), ?,?)";
        
        // Parameter yang digunakan untuk query
        $params = [ 
            $data['peringkatKompetisi'], 
            $data['urlKompetisi'], 
            $data['tanggalMulai'],
            $data['tanggalBerakhir'],
            $data['tempatKompetisi'],
            $data['judulKompetisi'],
            $data['tingkatKompetisi'], 
            $data['jenisPrestasi'], 
            $data['fileSurat'],
            $data['fileSertifikat'],
            $data['fileKegiatan'],
            'Menunggu Validasi',
            $data['namaPembimbing']
        ];
        $stmtPrestasi = sqlsrv_query($conn, $sql, $params);
        if ($stmtPrestasi === false) {
            echo 'Error inserting data into Prestasi: ' . print_r(sqlsrv_errors(), true);
            exit;  // Berhenti jika terjadi error pada insert Prestasi
        }
        if ($stmtPrestasi === false) {
            echo 'Error inserting data into Prestasi: ' . print_r(sqlsrv_errors(), true);
        } else {
            // Ambil id_prestasi yang baru saja disisipkan dari hasil OUTPUT
            $rowPrestasiId = sqlsrv_fetch_array($stmtPrestasi, SQLSRV_FETCH_ASSOC);
        
            if (!$rowPrestasiId || !isset($rowPrestasiId['PrestasiId'])) {
                echo 'Failed to retrieve PrestasiId. Please check your query.';
            } else {
                $id_prestasi = $rowPrestasiId['PrestasiId'];
        
                // Query untuk menyisipkan ke tabel PrestasiMahasiswa
                $queryMahasiswa = "
                    INSERT INTO PrestasiMahasiswa (PrestasiId, Nim) VALUES (?, ?)
                ";
                $paramsMahasiswa = array($id_prestasi, $data['nim']);
        
                // Eksekusi query untuk tabel PrestasiMahasiswa
                $stmtMahasiswa = sqlsrv_query($conn, $queryMahasiswa, $paramsMahasiswa);
        
                if ($stmtMahasiswa === false) {
                    echo 'Error inserting data into PrestasiMahasiswa: ' . print_r(sqlsrv_errors(), true);
                } else {
                    echo 'Prestasi mahasiswa berhasil disimpan.';
                    
                }
            }
        }
        // Menjalankan query menggunakan metode query yang sudah ada
        return $this->query($sql, $params);
    }
    
    // Fungsi untuk menambahkan data Prestasi dan PrestasiMahasiswa

    

    // Metode lainnya untuk CRUD prestasi dapat ditambahkan di sini
}
?>
