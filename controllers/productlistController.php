<?php
class ProductController {
    private $productModel;
    private $danhmuc;

    public function __construct() {
        $this->productModel = new ProductModel();
        $this->danhmuc = new DanhMuc();
    }

    public function index() {
        $products = $this->productModel->getAllProducts();
        $listCates = $this->danhmuc->getAllCate();
        require_once('views/auth/products_list.php');
    }
}
?>
