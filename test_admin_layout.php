<?php
echo "<h1>🔍 Admin Layout Test</h1>";

// Test các file layout
$layoutFiles = [
    '../admin/views/layout/header.php',
    '../admin/views/layout/navbar.php', 
    '../admin/views/layout/sidebar.php',
    '../admin/views/layout/footer.php'
];

echo "<h2>📁 Layout Files Status:</h2>";
foreach ($layoutFiles as $file) {
    if (file_exists($file)) {
        echo "<p>✅ " . basename($file) . " - EXISTS</p>";
    } else {
        echo "<p>❌ " . basename($file) . " - MISSING</p>";
    }
}

echo "<h2>🧪 Test Layout Structure:</h2>";
echo "<iframe src='" . BASE_URL_ADMIN . "?act=quan-ly-sach' width='100%' height='600px' style='border: 1px solid #ddd;'></iframe>";

echo "<h2>💡 Troubleshooting Steps:</h2>";
echo "<ol>";
echo "<li>Check if you're logged in to admin</li>";
echo "<li>Clear browser cache (Ctrl+F5)</li>";  
echo "<li>Check browser console for JavaScript errors</li>";
echo "<li>Verify AdminLTE CSS/JS files are loading</li>";
echo "</ol>";

echo "<h2>🔗 Direct Links:</h2>";
echo "<ul>";
echo "<li><a href='" . BASE_URL_ADMIN . "?act=login-admin' target='_blank'>🔐 Admin Login</a></li>";
echo "<li><a href='" . BASE_URL_ADMIN . "?act=quan-ly-sach' target='_blank'>📊 Dashboard</a></li>";
echo "<li><a href='" . BASE_URL_ADMIN . "?act=danh-sach-sach' target='_blank'>📚 Book List</a></li>";
echo "</ul>";

echo "<style>";
echo "body { font-family: Arial, sans-serif; max-width: 1200px; margin: 0 auto; padding: 20px; }";
echo "h1 { color: #28a745; } h2 { color: #007bff; }";
echo "p { margin: 8px 0; } li { margin: 5px 0; }";
echo "a { color: #007bff; text-decoration: none; }";
echo "a:hover { text-decoration: underline; }";
echo "</style>";
?>
