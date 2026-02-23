<?php
/**
 * Script de diagnostic de session Laravel
 * À placer à la racine du projet CRM et exécuter via navigateur
 * URL : https://ya-consulting.com/CRM/session-check.php
 */

define('LARAVEL_START', microtime(true));

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo '<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Diagnostic Session CRM</title>
    <style>
        body { font-family: sans-serif; max-width: 800px; margin: 40px auto; background: #f0f7ff; }
        .card { background: white; padding: 25px; border-radius: 12px; shadow: 0 4px 6px rgba(0,0,0,0.1); }
        h1 { color: #1e40af; border-bottom: 2px solid #3b82f6; padding-bottom: 10px; }
        .grid { display: grid; grid-template-columns: 200px 1fr; gap: 10px; margin-top: 20px; }
        .label { font-weight: bold; color: #4b5563; }
        .value { font-family: monospace; background: #f3f4f6; padding: 4px 8px; border-radius: 4px; }
        .status { margin-top: 30px; padding: 15px; border-radius: 8px; font-weight: bold; }
        .ok { background: #dcfce7; color: #166534; }
        .error { background: #fee2e2; color: #991b1b; }
    </style>
</head>
<body>
<div class="card">
    <h1>🔍 Diagnostic de Session Laravel</h1>
    <div class="grid">
        <div class="label">APP_URL:</div>
        <div class="value">' . config('app.url') . '</div>

        <div class="label">SESSION_DRIVER:</div>
        <div class="value">' . config('session.driver') . '</div>

        <div class="label">SESSION_LIFETIME:</div>
        <div class="value">' . config('session.lifetime') . ' minutes</div>

        <div class="label">SESSION_DOMAIN:</div>
        <div class="value">' . (config('session.domain') ?: 'null') . '</div>

        <div class="label">SESSION_PATH:</div>
        <div class="value">' . config('session.path') . '</div>

        <div class="label">SESSION_SECURE:</div>
        <div class="value">' . (config('session.secure') ? 'true (Bon pour HTTPS)' : 'false (Attention!)') . '</div>
        
        <div class="label">SESSION_HTTP_ONLY:</div>
        <div class="value">' . (config('session.http_only') ? 'true' : 'false') . '</div>

        <div class="label">COOKIE NAME:</div>
        <div class="value">' . config('session.cookie') . '</div>
    </div>';

$isOk = true;
$checks = [];

if (config('app.url') === 'http://127.0.0.1:8000') {
    $isOk = false;
    $checks[] = "❌ APP_URL est configuré sur 127.0.0.1 au lieu du domaine réel.";
}

if (config('session.lifetime') > 525600) {
    $checks[] = "⚠️ SESSION_LIFETIME est très élevé (> 1 an).";
}

if (!config('session.secure') && str_starts_with(config('app.url'), 'https')) {
    $isOk = false;
    $checks[] = "❌ SESSION_SECURE_COOKIE devrait être à true car vous utilisez HTTPS.";
}

echo '<div class="status ' . ($isOk ? 'ok' : 'error') . '">';
if ($isOk) {
    echo "✅ La configuration semble correcte.";
} else {
    echo "⚠️ Problèmes détectés :<br><ul>";
    foreach($checks as $check) echo "<li>$check</li>";
    echo "</ul>";
}
echo '</div>';

echo '<p style="margin-top:20px; font-size: 0.8em; color: #666;">
    Si les valeurs ci-dessus ne correspondent pas à votre fichier .env actuel, exécutez 
    <a href="clear-cache-server.php">clear-cache-server.php</a> pour vider le cache de configuration.
</p>';

echo '</div>
</body>
</html>';
