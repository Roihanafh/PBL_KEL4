<?php
require_once '../app/Models/MahasiswaModel.php';

class MahasiswaController {

    private $mahasiswaModel;

    public function __construct($conn, $nim) {
        $this->mahasiswaModel = new Mahasiswa($conn, $nim);
    }

    public function getMahasiswaData() {
        return $this->mahasiswaModel->getData();
    }

    public function updateMahasiswaData($nama, $email, $telepon, $alamat) {
        return $this->mahasiswaModel->updateData($nama, $email, $telepon, $alamat);
    }
}
?>
