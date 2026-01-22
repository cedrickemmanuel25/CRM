<?php
/**
 * Script de nettoyage du cache Laravel
 * À exécuter sur le serveur de production pour résoudre les problèmes de routes
 * 
 * Usage: php clear-cache.php
 * Ou accéder via SSH et exécuter: php artisan route:clear
 */

// Charger l'autoloader de Composer
require __DIR__.'/vendor/autoload.php';

// Bootstrap Laravel
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

// Définir le format de sortie (CLI ou Web)
$isCli = php_sapi_name() === 'cli';
$br = $isCli ? "\n" : "<br>\n";
$pre = $isCli ? "" : "<pre>";

echo $pre . "Nettoyage du cache Laravel...\n\n";

try {
    // Vider le cache des routes (le plus important pour ce problème)
    echo "1. Vidage du cache des routes...\n";
    $kernel->call('route:clear');
    echo "   ✓ Cache des routes vidé\n\n";
    
    // Vider le cache de configuration
    echo "2. Vidage du cache de configuration...\n";
    $kernel->call('config:clear');
    echo "   ✓ Cache de configuration vidé\n\n";
    
    // Vider le cache de l'application
    echo "3. Vidage du cache de l'application...\n";
    $kernel->call('cache:clear');
    echo "   ✓ Cache de l'application vidé\n\n";
    
    // Vider le cache des vues
    echo "4. Vidage du cache des vues...\n";
    $kernel->call('view:clear');
    echo "   ✓ Cache des vues vidé\n\n";
    
    // NE PAS recréer le cache des routes immédiatement pour éviter le problème
    // L'utilisateur pourra le faire manuellement après vérification
    
    echo "✅ Nettoyage terminé avec succès!\n";
    echo "\nVous pouvez maintenant tester votre site: https://ya-consulting.com/\n";
    echo "\nSi le problème persiste, vérifiez que:\n";
    echo "- Le fichier routes/web.php est bien déployé sur le serveur\n";
    echo "- Les permissions des fichiers sont correctes (755 pour les dossiers, 644 pour les fichiers)\n";
    echo "- Le fichier .htaccess est présent dans le dossier public/\n";
    
    if (!$isCli) {
        echo "</pre>";
    }
    
} catch (Exception $e) {
    echo "❌ Erreur lors du nettoyage: " . $e->getMessage() . "\n";
    echo "\nStack trace:\n" . $e->getTraceAsString() . "\n";
    if (!$isCli) {
        echo "</pre>";
    }
    exit(1);
}
