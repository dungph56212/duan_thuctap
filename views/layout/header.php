<!doctype html>
<html class="no-js" lang="en">


<!-- Mirrored from htmldemo.net/corano/corano/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 29 Jun 2024 09:53:03 GMT -->
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Website bán sách</title>
    <meta name="robots" content="noindex, follow" />
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.ico">

    <!-- CSS
	============================================ -->
    <!-- google fonts -->
    <link href="https://fonts.googleapis.com/css?family=Lato:300,300i,400,400i,700,900" rel="stylesheet">    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/vendor/bootstrap.min.css">
    <!-- Pe-icon-7-stroke CSS -->
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/vendor/pe-icon-7-stroke.css">
    <!-- Font-awesome CSS -->
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/vendor/font-awesome.min.css">
    <!-- Slick slider css -->
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/plugins/slick.min.css">
    <!-- animate css -->
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/plugins/animate.css">
    <!-- Nice Select css -->
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/plugins/nice-select.css">    <!-- jquery UI css -->
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/plugins/jqueryui.min.css">    <!-- main style css -->    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/style.css">
    <!-- Modern White Theme CSS -->
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/modern-white-theme.css">
    <!-- Enhanced Components CSS -->
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/enhanced-components.css">
    <!-- Category Styles CSS -->
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/category-styles.css">
    <!-- White theme override css -->
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/white-theme.css">
    <!-- Color override css -->
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/color-override.css">

    <!-- Banner System CSS -->
    <style>
        /* Banner Popup Styles */
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        @keyframes slideIn {
            from { transform: scale(0.7) translateY(-50px); opacity: 0; }
            to { transform: scale(1) translateY(0); opacity: 1; }
        }
        
        @keyframes slideOut {
            from { transform: scale(1) translateY(0); opacity: 1; }
            to { transform: scale(0.7) translateY(-50px); opacity: 0; }
        }
        
        #banner-popup-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            z-index: 10000;
            display: flex;
            justify-content: center;
            align-items: center;
            animation: fadeIn 0.3s ease-in-out;
        }
        
        #banner-popup {
            position: relative;
            max-width: 90%;
            max-height: 90%;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
            animation: slideIn 0.3s ease-in-out;
        }
        
        .banner-close-btn {
            position: absolute;
            top: 10px;
            right: 15px;
            background: rgba(255, 255, 255, 0.9);
            border: none;
            font-size: 24px;
            font-weight: bold;
            color: #333;
            width: 35px;
            height: 35px;
            border-radius: 50%;
            cursor: pointer;
            z-index: 10001;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
        }
        
        .banner-close-btn:hover {
            background: rgba(255, 0, 0, 0.8);
            color: white;
        }
        
        /* Banner Top/Bottom Styles */
        .banner-top, .banner-bottom {
            width: 100%;
            text-align: center;
            z-index: 999;
            position: relative;
        }
        
        .banner-top {
            margin-bottom: 10px;
        }
        
        .banner-bottom {
            margin-top: 10px;
        }
        
        .banner-top img, .banner-bottom img {
            max-width: 100%;
            height: auto;
            cursor: pointer;
            transition: transform 0.3s ease;
        }
        
        .banner-top img:hover, .banner-bottom img:hover {
            transform: scale(1.02);
        }
        
        /* Banner Sidebar Styles */
        .banner-sidebar {
            position: fixed;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            z-index: 998;
            max-width: 200px;
        }
        
        .banner-sidebar img {
            width: 100%;
            height: auto;
            cursor: pointer;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease;
        }
        
        .banner-sidebar img:hover {
            transform: scale(1.05);
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            #banner-popup {
                max-width: 95%;
                max-height: 80%;
            }
            
            .banner-sidebar {
                right: 10px;
                max-width: 120px;
            }
        }
    </style>

</head>
<body>
