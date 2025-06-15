<?php
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/admin/models/BannerAds.php';

try {
    $bannerModel = new BannerAds();
    echo "✅ BannerAds model loaded successfully!<br>";
    
    $stats = $bannerModel->getBannerStatistics();
    echo "✅ Banner statistics retrieved: " . json_encode($stats) . "<br>";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "<br>";
}
?>
