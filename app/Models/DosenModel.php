<?php

require_once 'Model.php';

class DosenModel extends Model {

    public function getDataDosen() {
        $sqlDosen = "SELECT Nip, Nama FROM Dosen";
        $stmtDosen = sqlsrv_prepare($this->conn, $sqlDosen);

        $dataDosen = [];
        if (sqlsrv_execute($stmtDosen)) {
            while ($row = sqlsrv_fetch_array($stmtDosen, SQLSRV_FETCH_ASSOC)) {
                $dataDosen[] = $row;
            }
        } else {
            die(print_r(sqlsrv_errors(), true)); // Debugging jika query gagal
        }

        return $dataDosen;
    }
}
?>
