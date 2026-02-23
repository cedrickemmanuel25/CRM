<?php
/**
 * Standalone Environment Test (No Laravel dependency)
 */
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Environment Test</h1>";
echo "PHP Version: " . PHP_VERSION . "<br>";
echo "Current File: " . __FILE__ . "<br>";
echo "Current Directory: " . __DIR__ . "<br>";

$extensions = ['bcmath', 'ctype', 'fileinfo', 'json', 'mbstring', 'openssl', 'pdo_mysql', 'tokenizer', 'xml', 'curl'];
echo "<h2>Extensions Check:</h2><ul>";
foreach ($extensions as $ext) {
    if (extension_loaded($ext)) {
        echo "<li>✅ $ext: Loaded</li>";
    } else {
        echo "<li style='color:red;'>❌ $ext: NOT LOADED</li>";
    }
}
echo "</ul>";

echo "<h2>Write Permission Test:</h2>";
$testFile = __DIR__ . '/test_write.txt';
if (@file_put_contents($testFile, 'test')) {
    echo "✅ Success: Can write to current directory.<br>";
    @unlink($testFile);
} else {
    echo "❌ Error: Cannot write to current directory.<br>";
}

echo "<h2>Laravel Vendor Check:</h2>";
$vendorPath = __DIR__ . '/../vendor/autoload.php';
if (file_exists($vendorPath)) {
    echo "✅ Success: found vendor/autoload.php at " . realpath($vendorPath) . "<br>";
} else {
    echo "❌ Error: vendor/autoload.php NOT FOUND at " . $vendorPath . "<br>";
}
?>
