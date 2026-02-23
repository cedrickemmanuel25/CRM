<?php
/**
 * Script de lecture des logs Laravel
 */
error_reporting(E_ALL);
ini_set('display_errors', 1);

$logPath = __DIR__ . '/../storage/logs/laravel.log';

echo "<h1>Laravel Log Reader</h1>";
echo "Checking log file at: $logPath <br>";

if (!file_exists($logPath)) {
    die("❌ Log file NOT FOUND.");
}

$lines = 50;
$content = shell_exec("tail -n $lines " . escapeshellarg($logPath));

if (!$content) {
    // Fallback if tail is not available
    $fileContent = file($logPath);
    $content = implode("", array_slice($fileContent, -$lines));
}

echo "<h2>Last $lines lines:</h2>";
echo "<pre style='background:#f4f4f4; padding:15px; border:1px solid #ccc; overflow:auto;'>";
echo htmlspecialchars($content);
echo "</pre>";
?>
