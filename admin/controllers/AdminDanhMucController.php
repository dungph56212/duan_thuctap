<?php
class AdminDanhMucController{
    public $modelDanhMuc;
    public function __construct(){
        $this->modelDanhMuc = new AdminDanhMuc();
    }
    public function danhSachDanhMuc(){

        $listDanhMuc = $this->modelDanhMuc->getAllDanhMuc ();
      require_once './views/danhmuc/DanhMuc.php';
    }
}