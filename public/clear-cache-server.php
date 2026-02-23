<?php
/**
 * Script de nettoyage du cache Laravel (V3 - Corrected Paths)
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

if (file_exists(__DIR__ . '/vendor/autoload.php')) {
    $rootPath = __DIR__;
} elseif (file_exists(dirname(__DIR__) . '/vendor/autoload.php')) {
    $rootPath = dirname(__DIR__);
} else {
    die("ERREUR : Impossible de localiser le dossier vendor.");
}

require $rootPath . '/vendor/autoload.php';

echo '<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Nettoyage Cache CRM</title>
</head>
<body style="font-family: sans-serif; padding: 20px;">
    <h1>🧹 Nettoyage du Cache</h1>
    <pre style="background: #eee; padding: 15px;">';

try {
    $app = require_once $rootPath . '/bootstrap/app.php';
    $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
    
    echo "Vidage config...\n";
    $kernel->call('config:clear');
    echo "✅ Success\n\n";
    
    echo "Vidage cache...\n";
    $kernel->call('cache:clear');
    echo "✅ Success\n\n";
    
    echo "Vidage routes...\n";
    $kernel->call('route:clear');
    echo "✅ Success\n\n";

    echo "Vidage vues...\n";
    $kernel->call('view:clear');
    echo "✅ Success\n\n";
    
    echo "--- TERMINÉ ---";
} catch (Exception $e) {
    echo "ERREUR : " . $e->getMessage() . "\n";
}

echo '</pre>
<p><a href="session-check.php">Retour au diagnostic</a></p>
</body>
</html>';
