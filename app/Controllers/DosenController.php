<?php
require_once '../app/Models/DosenModel.php';

class DosenController {

    private $dosenModel;

    public function __construct($conn) {
        $this->dosenModel = new DosenModel($conn);
    }

    public function getDosenData() {
        return $this->dosenModel->getDataDosen();
    }

}
?>
