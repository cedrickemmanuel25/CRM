# 🚀 Instructions de déploiement - CRM Ya-Consulting

## ⚠️ Problème identifié

Le serveur affiche des erreurs HTML brutes car le fichier `.env` de production a des paramètres de développement :
- `APP_ENV=local` au lieu de `production`
- `APP_DEBUG=true` au lieu de `false`
- Cache de routes et configuration obsolète

## 📋 Solution en 3 étapes

### Étape 1 : Modifier le fichier `.env` sur le serveur

**Via cPanel File Manager ou FTP :**

1. Accéder au fichier : `/home/yacons/public_html/CRM/.env`
2. Modifier les lignes suivantes :

```env
# AVANT (Développement) ❌
APP_ENV=local
APP_DEBUG=true
APP_LOCALE=en
LOG_LEVEL=debug

# APRÈS (Production) ✅
APP_ENV=production
APP_DEBUG=false
APP_LOCALE=fr
LOG_LEVEL=error
```

3. **Optionnel** - Modifier aussi :
```env
SESSION_PATH=/CRM/public
```

4. **Sauvegarder** le fichier

> 💡 **Astuce** : Gardez une copie de sauvegarde du `.env` avant modification

---

### Étape 2 : Nettoyer le cache

**Option A - Via le script web (RECOMMANDÉ, sans SSH) :**

1. **Télécharger** le fichier `clear-cache-server.php` à la racine du projet CRM  
   📍 Emplacement : `/home/yacons/public_html/CRM/clear-cache-server.php`

2. **Accéder** à l'URL dans votre navigateur :  
   🌐 https://ya-consulting.com/CRM/clear-cache-server.php

3. **Vérifier** que tous les caches sont nettoyés avec succès (✅)

4. **⚠️ SUPPRIMER** le fichier `clear-cache-server.php` immédiatement après usage  
   (pour des raisons de sécurité)

**Option B - Via SSH (si disponible) :**

```bash
cd /home/yacons/public_html/CRM
php artisan route:clear
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

---

### Étape 3 : Vérifier et tester

1. **Visiter la page d'accueil** :  
   🌐 https://ya-consulting.com/CRM/public/

2. **Se connecter** :  
   🌐 https://ya-consulting.com/CRM/public/login

3. **Accéder aux contacts** :  
   🌐 https://ya-consulting.com/CRM/public/contacts

**Résultat attendu :**
- ✅ Plus d'erreur HTML brute
- ✅ Pages d'erreur propres (si non authentifié : redirect ou 403)
- ✅ Application fonctionnelle après connexion

---

## 🎯 Optimisation (Optionnel)

**Après avoir vérifié que tout fonctionne**, vous pouvez créer un cache optimisé pour la production :

```bash
# Via SSH uniquement
cd /home/yacons/public_html/CRM
php artisan config:cache
php artisan route:cache
php artisan view:cache
composer dump-autoload --optimize
```

> ⚠️ **Attention** : Ne faites ceci que si l'application fonctionne correctement, car le cache peut masquer des erreurs de configuration.

---

## 🔍 Dépannage

### Si l'erreur persiste après le nettoyage :

1. **Vérifier les logs Laravel** :  
   📄 `/home/yacons/public_html/CRM/storage/logs/laravel.log`

2. **Vérifier les permissions** :
   ```bash
   chmod -R 755 storage bootstrap/cache
   chmod -R 775 storage/logs storage/framework
   ```

3. **Vérifier que la base de données est accessible** :
   - Host: `127.0.0.1`
   - Database: `yacons_yacons_crm`
   - User: `yacons_yacons_admin`

4. **Recréer le cache de configuration** :
   ```bash
   php artisan config:cache
   ```

### Pages d'erreur communes attendues :

| URL | Non authentifié | Authentifié |
|-----|----------------|-------------|
| `/` | Page d'accueil (200) | Page d'accueil (200) |
| `/login` | Formulaire de connexion (200) | Redirect vers dashboard |
| `/contacts` | Redirect vers `/login` | Liste des contacts (200) |
| `/dashboard` | Redirect vers `/login` | Dashboard (200) |

---

## 📝 Checklist de déploiement

- [ ] `.env` modifié avec `APP_ENV=production` et `APP_DEBUG=false`
- [ ] Cache nettoyé (routes, config, cache, vues)
- [ ] Fichier `clear-cache-server.php` supprimé (si utilisé)
- [ ] Site testé : page d'accueil accessible
- [ ] Login fonctionnel
- [ ] Contacts accessibles après authentification
- [ ] Aucune erreur HTML brute visible

---

## 🔐 Sécurité

**Fichiers sensibles à ne JAMAIS publier sur GitHub :**
- `.env` (contient les mots de passe DB et email)
- `storage/logs/` (peut contenir des informations sensibles)

**Vérifier que `.gitignore` contient :**
```
.env
.env.backup
.env.production
/storage/*.log
/storage/logs/
```

---

## 📚 Référence - Différences .env local vs production

| Paramètre | Local | Production |
|-----------|-------|------------|
| `APP_ENV` | `local` | `production` |
| `APP_DEBUG` | `true` | `false` |
| `LOG_LEVEL` | `debug` | `error` |
| `DB_DATABASE` | `crm` | `yacons_yacons_crm` |
| `DB_USERNAME` | `root` | `yacons_yacons_admin` |
| `SESSION_PATH` | `/` | `/CRM/public` |

---

## ✅ Succès !

Une fois ces étapes complétées, votre application CRM sera configurée correctement en production et les erreurs s'afficheront de manière sécurisée sans exposer le code source.

Si vous rencontrez des difficultés, consultez les logs dans `/storage/logs/laravel.log` pour plus de détails.
