<?php
class Mahasiswa extends Model {

    private $nim;

    public function __construct($conn, $nim) {
        parent::__construct(); // Call the parent constructor to initialize the connection
        $this->nim = $nim;
    }

    // Mengambil data mahasiswa berdasarkan NIM
    public function getData() {
        $sql = "SELECT * FROM Mahasiswa WHERE Nim = ?";
        $stmt = sqlsrv_prepare($this->conn, $sql, array(&$this->nim));

        if (sqlsrv_execute($stmt)) {
            return sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
        } else {
            echo "Terjadi kesalahan saat mengambil data mahasiswa: ";
            print_r(sqlsrv_errors());
            exit();
        }
    }

    // Memperbarui data mahasiswa
    public function updateData($nama, $email, $telepon, $alamat) {
        $sql_update = "UPDATE Mahasiswa SET Nama = ?, Email = ?, NoTelp = ?, Alamat = ? WHERE Nim = ?";
        $stmt_update = sqlsrv_prepare($this->conn, $sql_update, array(&$nama, &$email, &$telepon, &$alamat, &$this->nim));

        if (sqlsrv_execute($stmt_update)) {
            return "Data berhasil diperbarui.";
        } else {
            return "Terjadi kesalahan saat memperbarui data.";
        }
    }
}
?>
