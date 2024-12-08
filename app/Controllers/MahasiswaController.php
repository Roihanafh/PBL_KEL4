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

    public function updateMahasiswaData($data) {
        return $this->mahasiswaModel->updateData(
            $data['nama'], 
            $data['email'], 
            $data['telepon'], 
            $data['alamat']
        );
    }

    public function processUpdate($postData) {
        $data = [
            'nama' => $postData['namaMahasiswa'],
            'email' => $postData['emailMahasiswa'],
            'telepon' => $postData['teleponMahasiswa'],
            'alamat' => $postData['alamatMahasiswa']
        ];

        return $this->updateMahasiswaData($data);
    }
}
?>
