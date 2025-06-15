<?php
echo "Testing BannerAds class loading...<br>";

// Test 1: Include database
echo "1. Testing database connection...<br>";
require_once __DIR__ . '/config/database.php';
echo "✅ Database included<br>";

// Test 2: Test connectDB function
echo "2. Testing connectDB function...<br>";
try {
    $conn = connectDB();
    echo "✅ Database connection successful<br>";
} catch (Exception $e) {
    echo "❌ Database connection failed: " . $e->getMessage() . "<br>";
}

// Test 3: Include BannerAds model
echo "3. Testing BannerAds model...<br>";
require_once __DIR__ . '/admin/models/BannerAds.php';
echo "✅ BannerAds model included<br>";

// Test 4: Create BannerAds instance
echo "4. Testing BannerAds instantiation...<br>";
try {
    $banner = new BannerAds();
    echo "✅ BannerAds instance created successfully<br>";
    
    // Test method
    $stats = $banner->getBannerStatistics();
    echo "✅ getBannerStatistics() works: " . json_encode($stats) . "<br>";
    
} catch (Exception $e) {
    echo "❌ BannerAds instantiation failed: " . $e->getMessage() . "<br>";
}

// Test 5: Include controller
echo "5. Testing BannerAdsController...<br>";
require_once __DIR__ . '/admin/controllers/BannerAdsController.php';
echo "✅ BannerAdsController included<br>";

try {
    $controller = new BannerAdsController();
    echo "✅ BannerAdsController instance created successfully<br>";
} catch (Exception $e) {
    echo "❌ BannerAdsController instantiation failed: " . $e->getMessage() . "<br>";
}

echo "<br>All tests completed!";
?>
