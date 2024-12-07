// models/PrestasiModel.php
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
    
    public function addPrestasi($data) {
        $sql = "INSERT INTO PrestasiMahasiswa (Nim, ProgramStudi, JenisKompetisi, TingkatKompetisi, ...) VALUES (?, ?, ?, ?, ...)";
        $params = [$data['nim'], $data['programStudi'], $data['jenisKompetisi'], $data['tingkatKompetisi']];
        return $this->query($sql, $params);
    }

    // Metode lainnya untuk CRUD prestasi dapat ditambahkan di sini
}
?>
