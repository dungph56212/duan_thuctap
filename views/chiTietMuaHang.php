<?php require_once 'layout/header.php';  ?>
<?php require_once 'layout/menu.php';  ?>

<main>
        <!-- breadcrumb area start -->
        <div class="breadcrumb-area">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="breadcrumb-wrap">
                            <nav aria-label="breadcrumb">
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="<?=BASE_URL?>"><i class="fa fa-home"></i></a></li>
                                    <li class="breadcrumb-item"><a href="shop.html">shop</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">bill detail</li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- breadcrumb area end -->

        <!-- cart main wrapper start -->
        <div class="cart-main-wrapper section-padding">
            <div class="container">
                <div class="section-bg-color">
                    <div class="row">
                        <div class="col-lg-7">
                            <!-- Thông tin sản phẩm đơn hàng -->
                            <div class="cart-table table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th colspan="5">Thông tin sản phẩm</th>  
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="text-center">
                                            <th>Hình ảnh</th>
                                            <th>Tên sản phẩm</th>
                                            <th>Đơn giá</th>
                                            <th>Số lượng</th>
                                            <th>Thành tiền</th>
                                        </tr>
                                        <?php foreach($chiTietDonHang as $item) : ?>                                        <tr>
                                            <td>
                                                <img class="img-fluid" src="<?= getImageUrl($item['hinh_anh']) ?>" alt="Product" width="100px" />
                                            </td>
                                            <td><?= $item['ten_san_pham'] ?></td>
                                            <td><?= number_format($item['don_gia'],0, ',','.') ?>đ</td>
                                            <td><?= $item['so_luong'] ?></td>
                                            <td><?= number_format($item['thanh_tien'],0, ',','.') ?>đ</td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                            
                        </div>

                        <div class="col-lg-5">
                            <!-- thông tin đơn hàng -->
                            <div class="cart-table table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th colspan="2">Thông tin đơn hàng</th>  
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th>Mã đơn hàng</th>
                                            <td><?= $donHang['ma_don_hang'] ?></td>
                                        </tr>
                                        <tr>
                                            <th>Người nhận</th>
                                            <td><?= $donHang['ten_nguoi_nhan'] ?></td>
                                        </tr>
                                        <tr>
                                            <th>Email</th>
                                            <td><?= $donHang['email_nguoi_nhan'] ?></td>
                                        </tr>
                                        <tr>
                                            <th>Số điện thoại</th>
                                            <td><?= $donHang['sdt_nguoi_nhan'] ?></td>
                                        </tr>
                                        <tr>
                                            <th>Địa chỉ</th>
                                            <td><?= $donHang['dia_chi_nguoi_nhan'] ?></td>
                                        </tr>
                                        <tr>
                                            <th>Ngày đặt</th>
                                            <td><?= $donHang['ngay_dat'] ?></td>
                                        </tr>
                                        <tr>
                                            <th>Ghi chú</th>
                                            <td><?= $donHang['ghi_chu'] ?></td>
                                        </tr>
                                        <tr>
                                            <th>Tổng tiền</th>
                                            <td><?= number_format($donHang['tong_tien'],0, ',','.') ?></td>
                                        </tr>
                                        <tr>
                                            <th>Phương thức thanh toán</th>
                                            <td><?= $phuongThucThanhToan[$donHang['phuong_thuc_thanh_toan_id']] ?></td>
                                        </tr>
                                        <tr>
                                            <th>Trạng thái thanh toán</th>
                                            <td><?= $trangThaiDonHang[$donHang['trang_thai_id']] ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            
                        </div>
                    </div>   
                </div>
            </div>
        </div>
        <!-- cart main wrapper end -->
    </main>

<script>
    
</script>
<?php require_once 'layout/miniCart.php'; ?>
<?php require_once 'layout/footer.php'; ?>