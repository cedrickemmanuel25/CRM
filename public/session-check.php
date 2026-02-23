<?php
/**
 * Script de diagnostic de session Laravel (V3 - Debug Mode)
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

echo '<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Debug Session CRM</title>
    <style>
        body { font-family: monospace; background: #1a1a1a; color: #00ff00; padding: 20px; line-height: 1.5; }
        .error-box { background: #330000; color: #ff0000; border: 1px solid red; padding: 15px; margin: 10px 0; }
        h1 { color: #fff; border-bottom: 1px solid #444; }
        .info { color: #00bbff; }
    </style>
</head>
<body>
<h1>🛠️ Debugging Laravel Bootstrap...</h1>';

// Recherche de l'autoloader
$pathsToTry = [
    __DIR__ . '/vendor/autoload.php',
    __DIR__ . '/../vendor/autoload.php',
    dirname(__DIR__) . '/vendor/autoload.php'
];

$basePath = null;
foreach ($pathsToTry as $path) {
    if (file_exists($path)) {
        $basePath = dirname($path);
        break;
    }
}

if (!$basePath) {
    echo '<div class="error-box">❌ ERREUR : Impossible de localiser le dossier "vendor".</div>';
    exit;
}

try {
    require $basePath . '/vendor/autoload.php';
    $app = require_once $basePath . '/bootstrap/app.php';
    $kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
    $kernel->bootstrap();

    echo '<h2 class="info">✅ Laravel bootstrapped successfully!</h2>';
    
    echo "<h3>Configuration:</h3><ul>";
    echo "<li>APP_URL: " . config('app.url') . "</li>";
    echo "<li>SESSION_DRIVER: " . config('session.driver') . "</li>";
    echo "<li>SESSION_SECURE: " . (config('session.secure') ? 'TRUE' : 'FALSE') . "</li>";
    echo "<li>SESSION_DOMAIN: " . (config('session.domain') ?: 'NULL') . "</li>";
    echo "<li>SESSION_PATH: " . config('session.path') . "</li>";
    echo "</ul>";

} catch (\Throwable $e) {
    echo '<div class="error-box">';
    echo "<strong>Fatal Error:</strong> " . $e->getMessage() . "<br>";
    echo "<strong>File:</strong> " . $e->getFile() . " (Line " . $e->getLine() . ")<br>";
    echo "<strong>Trace:</strong><pre>" . $e->getTraceAsString() . "</pre>";
    echo '</div>';
}

echo '</body></html>';
