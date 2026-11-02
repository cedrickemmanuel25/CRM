# Déployer la démonstration interactive

Procédure pour publier l'application Laravel elle-même (pas la galerie de captures) sur une instance
de démonstration, avec des données fictives et des protections activées par `DEMO_MODE=true`.

## Hébergement retenu : alwaysdata (offre gratuite)

| Critère | Offre gratuite alwaysdata |
|---|---|
| Coût | 0 €, sans limite de durée |
| Exécution | PHP côté serveur, accès SSH, Composer |
| Base de données | MariaDB (compatible MySQL) |
| HTTPS | Certificat Let's Encrypt, adresse `https://<compte>.alwaysdata.net` |
| Tâches planifiées | Incluses |
| Ressources | 1 Go de disque (fichiers et base compris), 256 Mo de RAM, ¼ de CPU |
| Conditions | Usage personnel, non commercial ; uniquement l'adresse `alwaysdata.net` |

Besoins mesurés du CRM : environ 80 Mo (55 Mo de dépendances de production et 22 Mo de code). Les
assets sont déjà compilés dans `public/build` : Node.js n'est pas nécessaire sur le serveur.

Alternatives payantes, si l'offre gratuite ne suffit plus : alwaysdata Small (5 à 6 € HT/mois,
50 Go, 1 Go de RAM), Laravel Cloud ou Railway (à partir de 5 $/mois plus la consommation).

## 1. Préparer le compte (interface alwaysdata)

1. Créer un compte gratuit ; le nom du compte détermine l'adresse `https://<compte>.alwaysdata.net`.
2. **Environnement → PHP** : choisir PHP 8.2 ou plus récent.
3. **Bases de données → MySQL** : créer une base dont le nom contient `demo` (par exemple
   `<compte>_demo`) et un utilisateur dédié. Ne jamais réutiliser une base d'une autre application.
4. **Accès distant → SSH** : activer la connexion SSH par mot de passe pour l'utilisateur du compte.

## 2. Installer l'application (SSH)

```bash
ssh <compte>@ssh-<compte>.alwaysdata.net

git clone https://github.com/cedrickemmanuel25/CRM.git ~/crm
cd ~/crm
composer install --no-dev --optimize-autoloader --no-interaction

cp .env.demo.example .env
nano .env                      # APP_URL, DB_HOST, DB_DATABASE, DB_USERNAME, DB_PASSWORD
php artisan key:generate       # nouvelle clé, propre à cette instance

php artisan migrate --force
php artisan demo:reset         # charge le jeu de données fictif (refusé si DEMO_MODE est faux
                               # ou si le nom de la base ne contient pas « demo »)
php artisan config:cache && php artisan route:cache && php artisan view:cache
chmod -R u+rwX storage bootstrap/cache
```

## 3. Publier le site (interface alwaysdata)

1. **Web → Sites** : modifier le site par défaut.
   - Type : PHP
   - Répertoire racine : `crm/public` (seul le dossier `public` est exposé ; `.env`, `storage` et le
     code restent hors de la racine web)
2. **Web → SSL** : activer « Forcer HTTPS ».
3. **Avancé → Tâches planifiées** : ajouter la réinitialisation du jeu de démonstration, par exemple
   toutes les 6 heures :
   ```bash
   cd $HOME/crm && php artisan demo:reset
   ```
   Si l'hébergeur autorise une exécution toutes les minutes, on peut lancer à la place
   `cd $HOME/crm && php artisan schedule:run` : le planificateur exécute `demo:reset` toutes les
   6 heures et n'effectue pas de sauvegarde `mysqldump` en mode démonstration.

## 4. Mettre à jour la démonstration

```bash
cd ~/crm
git pull
composer install --no-dev --optimize-autoloader --no-interaction
php artisan migrate --force
php artisan config:cache && php artisan route:cache && php artisan view:cache
```

## Protections actives en mode démonstration

| Domaine | Comportement |
|---|---|
| Administration | Écrans consultables ; création, modification et suppression d'utilisateurs, paramètres, règles d'attribution, demandes d'accès, maintenance, sauvegarde et export RGPD bloqués |
| Exports | Export complet des comptes bloqué ; les rapports CSV / PDF sur les données fictives restent disponibles |
| Comptes partagés | Modification du profil (nom, e-mail, mot de passe) bloquée |
| Formulaire public | Demande d'accès désactivée |
| Fichiers | Aucun téléversement accepté (photos, pièces jointes, documents) |
| E-mails | Pilote `log` imposé : aucun e-mail réel n'est envoyé |
| Vie privée | Le journal d'audit n'enregistre ni l'adresse IP ni le navigateur des visiteurs |
| Données | Jeu entièrement fictif, réinitialisé périodiquement par `demo:reset` (base dont le nom contient « demo » uniquement) |
| Configuration | `APP_DEBUG=false`, `APP_ENV=production`, clé `APP_KEY` propre à l'instance, cookies de session sécurisés |

Les actions métier (contacts, opportunités, tâches, tickets) restent utilisables ; les modifications des
visiteurs disparaissent à la réinitialisation suivante.

## Comptes de démonstration

Mot de passe commun : `Demo@1234` (affiché sur la page de connexion de la démonstration).

| Compte | Accès |
|---|---|
| `commercial@example.com` | Espace commercial complet sur ses propres contacts et opportunités |
| `support@example.com` | Console support, tickets, contacts |
| `admin@example.com` | Vue d'ensemble et écrans d'administration, réglages verrouillés |
| `visiteur@example.com` | Lecture seule |
