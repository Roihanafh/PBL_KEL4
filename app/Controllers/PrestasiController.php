// controllers/PrestasiController.php
<?php
require_once '../app/Models/PrestasiModel.php';

class PrestasiController {
    
    private $prestasiModel;

    public function __construct() {
        $this->prestasiModel = new PrestasiModel();
    }

    public function checkPrestasi($nim) {
        return $this->prestasiModel->getPrestasiByNIM($nim);
    }

    public function addPrestasi($conn, $data) {
        return $this->prestasiModel->addPrestasi($conn,$data);
    }
}
?>
