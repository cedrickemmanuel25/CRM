<?php
/**
 * Script de lecture des logs (Laravel + PHP Native)
 */
error_reporting(E_ALL);
ini_set('display_errors', 1);

$laravelLog = __DIR__ . '/../storage/logs/laravel.log';
$phpErrorLog = __DIR__ . '/error_log';
$rootErrorLog = __DIR__ . '/../error_log';

echo "<h1>System Log Reader</h1>";

function showLog($path, $label) {
    echo "<h2>$label ($path)</h2>";
    if (!file_exists($path)) {
        echo "<p style='color:orange;'>Non trouvé.</p>";
        return;
    }
    
    $lines = 30;
    $content = shell_exec("tail -n $lines " . escapeshellarg($path));
    if (!$content) {
        $fileContent = file($path);
        $content = implode("", array_slice($fileContent, -$lines));
    }
    
    echo "<pre style='background:#f4f4f4; padding:15px; border:1px solid #ccc; max-height:400px; overflow:auto;'>";
    echo htmlspecialchars($content);
    echo "</pre>";
}

showLog($phpErrorLog, "PHP Error Log (Public Folder)");
showLog($rootErrorLog, "PHP Error Log (Root Folder)");
showLog($laravelLog, "Laravel Log (Storage Folder)");

?>
