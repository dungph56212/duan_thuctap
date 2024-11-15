<?php 

class HomeController
{

    public $modelSanPham;
    public function __construct(){
      $this->modelSanPham = new SanPham();
    }


    public function home() {
        echo "Dự án 1 team 9";
    }
    public function trangchu(){
        echo "Đây là trang chủ của tôi";
    }
    public function danhSachSanPham(){
        // echo "Đây là danh sách sản phẩm";
        $listProduct = $this->modelSanPham->getAllProduct();
        // var_dump($listProduct);die();
        require_once './views/listProduct.php';
    }
}