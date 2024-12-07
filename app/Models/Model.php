// models/Model.php
<?php
class Model {
    protected $conn;

    public function __construct() {
        include('../config/koneksi.php'); // Koneksi database
        $this->conn = $conn;
    }

    public function query($sql, $params = []) {
        $stmt = sqlsrv_query($this->conn, $sql, $params);
        if ($stmt === false) {
            die(print_r(sqlsrv_errors(), true));
        }
        return $stmt;
    }
}
?>
