# Solution pour l'erreur "Method Not Allowed" sur la route /

## Problème
L'erreur indique que la méthode GET n'est pas supportée pour la route `/`, seulement HEAD est supporté. Cela est généralement causé par un cache de routes obsolète ou corrompu.

## Solution

### Option 1: Via SSH (Recommandé)

Connectez-vous à votre serveur via SSH et exécutez les commandes suivantes :

```bash
# Aller dans le répertoire de votre projet
cd /chemin/vers/votre/projet

# Vider le cache des routes (le plus important)
php artisan route:clear

# Vider les autres caches
php artisan config:clear
php artisan cache:clear
php artisan view:clear

# Si vous utilisez le cache de routes en production, recréez-le APRÈS avoir vérifié que tout fonctionne
php artisan route:cache
php artisan config:cache
```

### Option 2: Via le script PHP

1. Téléchargez le fichier `clear-cache.php` sur votre serveur (à la racine du projet)
2. Accédez à `https://ya-consulting.com/clear-cache.php` via votre navigateur
3. OU exécutez-le via SSH : `php clear-cache.php`

### Option 3: Suppression manuelle des fichiers de cache

Si vous avez accès au système de fichiers :

1. Supprimez les fichiers suivants s'ils existent :
   - `bootstrap/cache/routes-v7.php` (ou similaire)
   - `bootstrap/cache/config.php`
   - Tous les fichiers dans `storage/framework/cache/data/`

2. Vérifiez les permissions :
   - Dossiers : 755
   - Fichiers : 644
   - `storage/` et `bootstrap/cache/` : 775

## Vérifications supplémentaires

1. **Vérifiez que le fichier routes/web.php est bien déployé**
   - La route `Route::get('/', ...)` doit être présente à la ligne 8

2. **Vérifiez le fichier .htaccess**
   - Le fichier `public/.htaccess` doit être présent et correct
   - Il doit rediriger toutes les requêtes vers `index.php`

3. **Vérifiez la configuration du serveur web**
   - Assurez-vous que le document root pointe vers le dossier `public/`
   - Vérifiez que mod_rewrite est activé

4. **Vérifiez les logs**
   - Consultez `storage/logs/laravel.log` pour d'autres erreurs

## Après le nettoyage

1. Testez votre site : `https://ya-consulting.com/`
2. Si tout fonctionne, vous pouvez recréer le cache pour améliorer les performances :
   ```bash
   php artisan route:cache
   php artisan config:cache
   ```

## Si le problème persiste

1. Vérifiez que vous utilisez la bonne version de PHP (8.3.28 selon votre erreur)
2. Vérifiez que toutes les dépendances sont installées : `composer install --no-dev --optimize-autoloader`
3. Vérifiez les permissions des fichiers et dossiers
4. Contactez le support Namecheap si le problème persiste
