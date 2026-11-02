# CRM — Gestion commerciale, support client et pilotage

**Application web Laravel de gestion de la relation client : contacts, pipeline des ventes,
attribution des affaires, tâches, support et reporting, avec un espace dédié à chaque rôle.**

### [▶ Voir la démonstration visuelle](https://cedrickemmanuel25.github.io/CRM/)

Galerie interactive des écrans réels de l'application, consultable sans installation.

![Page d'accueil du CRM (capture intégrale)](docs/screenshots/landing-desktop.png)

---

## Sommaire

- [A. Présentation](#a-présentation)
- [B. Démonstration visuelle](#b-démonstration-visuelle)
- [C. Architecture](#c-architecture)
- [D. Technologies](#d-technologies)
- [E. Modules et fonctionnalités](#e-modules-et-fonctionnalités)
- [F. Installation](#f-installation)
- [G. Qualité](#g-qualité)

---

## A. Présentation

### Problématique métier

Une équipe commerciale qui suit ses prospects dans des tableurs et ses demandes clients par e-mail
perd vite la visibilité sur trois questions : *où en est chaque affaire ?*, *qui s'en occupe ?* et
*que faut-il faire aujourd'hui ?* Les informations sont dispersées, les relances oubliées, et il
devient difficile de mesurer l'activité.

### Description

Ce CRM réunit dans un même outil :

- la base de contacts et l'historique des échanges (appels, e-mails, réunions, notes) ;
- un pipeline des ventes en six étapes, avec les informations à saisir à chaque transition ;
- l'attribution des opportunités aux commerciaux, manuelle ou par règles ;
- les tâches, l'agenda et les rappels des actions en retard ;
- le support client par tickets ;
- des tableaux de bord, des exports CSV / PDF et un journal d'audit.

Quatre rôles — administrateur, commercial, support, visiteur — disposent chacun d'un espace et de
droits adaptés.

### Statut du projet

| Élément | État vérifié |
|---|---|
| Application | Fonctionnelle en environnement local (Laravel 12, MySQL / MariaDB) |
| Tests automatisés | 53 tests Pest, 179 assertions, tous réussis |
| Recette navigateur | 50 écrans contrôlés en desktop et mobile avec Playwright, sans erreur JavaScript |
| Données de démonstration | Jeu entièrement fictif fourni (`DemoSeeder`) |
| Déploiement | Procédure pour hébergement mutualisé cPanel documentée dans [`DEPLOY_INSTRUCTIONS.md`](DEPLOY_INSTRUCTIONS.md) |

> Toutes les captures proviennent de l'application en fonctionnement, sur la base de démonstration.
> « Horizon CRM » est le nom d'organisation configuré dans cette démonstration.

---

## B. Démonstration visuelle

**[Ouvrir la galerie interactive](https://cedrickemmanuel25.github.io/CRM/)** — site statique
(GitHub Pages) présentant les captures réelles par module, avec légendes et agrandissement. Il s'agit
d'une galerie de présentation : l'application Laravel elle-même nécessite PHP et MySQL (voir
[Installation](#f-installation)).

### Tableaux de bord

| Administrateur | Commercial |
|---|---|
| ![Tableau de bord administrateur](docs/screenshots/dashboard-admin.png) | ![Tableau de bord commercial](docs/screenshots/dashboard-commercial.png) |

### Pipeline commercial et opportunités

| Pipeline (Kanban) | Liste des opportunités |
|---|---|
| ![Pipeline commercial](docs/screenshots/pipeline.png) | ![Liste des opportunités](docs/screenshots/opportunities-list.png) |

| Fiche opportunité | Tâches (Kanban) |
|---|---|
| ![Fiche opportunité](docs/screenshots/opportunity-detail.png) | ![Tableau des tâches](docs/screenshots/tasks.png) |

### Contacts

| Liste des contacts | Fiche contact |
|---|---|
| ![Liste des contacts](docs/screenshots/contacts.png) | ![Fiche contact](docs/screenshots/contact-detail.png) |

### Support

| Console support | Tickets |
|---|---|
| ![Console support](docs/screenshots/support-dashboard.png) | ![Gestion des tickets](docs/screenshots/tickets.png) |

### Reporting et administration

| Exports CSV / PDF | Utilisateurs |
|---|---|
| ![Centre d'exports](docs/screenshots/reports.png) | ![Gestion des utilisateurs](docs/screenshots/admin-users.png) |

| Paramètres système | Agenda |
|---|---|
| ![Paramètres système](docs/screenshots/admin-settings.png) | ![Agenda hebdomadaire](docs/screenshots/calendar.png) |

### Mobile (390 × 844)

| Accueil | Connexion | Dashboard commercial | Contacts | Pipeline |
|---|---|---|---|---|
| ![Accueil mobile](docs/screenshots/landing-mobile.png) | ![Connexion mobile](docs/screenshots/mobile-login.png) | ![Dashboard mobile](docs/screenshots/mobile-dashboard-commercial.png) | ![Contacts mobile](docs/screenshots/mobile-contacts.png) | ![Pipeline mobile](docs/screenshots/mobile-pipeline.png) |

---

## C. Architecture

Application Laravel monolithique en rendu serveur. Les vues Blade sont enrichies par Alpine.js
(modales, Kanban, filtres, rafraîchissement AJAX) et ApexCharts (graphiques).

```mermaid
flowchart LR
    subgraph Client["Navigateur"]
        UI["Interface Laravel Blade<br/>Tailwind CSS 4, Alpine.js, ApexCharts"]
    end

    subgraph App["Application Laravel 12"]
        R["Routes et middleware<br/>auth, role, admin"]
        C["Contrôleurs<br/>Contacts, Opportunités, Tâches,<br/>Tickets, Dashboard, Rapports, Admin"]
        S["Services métier<br/>AttributionService<br/>NotificationService<br/>AuditLogger"]
        M["Modèles Eloquent<br/>User, Contact, Opportunity,<br/>Task, Ticket, Activity, AuditLog"]
        O["Observateurs<br/>audit, statut du contact"]
        N["Notifications<br/>base de données, e-mail"]
        P["Exports CSV et PDF<br/>DomPDF"]
        K["Tâches planifiées<br/>sauvegarde, rappels, alertes"]
    end

    DB[("Base de données MySQL")]

    UI -->|HTTP et AJAX| R
    R --> C
    C --> S
    C --> M
    C --> P
    C -->|événements| N
    S --> N
    M --> DB
    M -.->|created, updated| O
    O --> M
    K --> M
    K --> N
```

Principes retenus :

- **Contrôle d'accès en deux niveaux** : middleware `role:` / `admin` sur les groupes de routes, puis
  vérification d'appartenance dans les contrôleurs (un commercial n'accède qu'à ses contacts,
  opportunités et tickets).
- **Relations polymorphes** : activités et tâches se rattachent à un contact, une opportunité ou un
  ticket, via un `morphMap` déclaré dans `AppServiceProvider`.
- **Traçabilité** : observateurs Eloquent alimentant `audit_logs`, historique des stades et des
  attributions.

Organisation du code :

```text
app/
├── Console/Commands/     Commandes planifiées (sauvegarde, rappels, alertes, synthèse)
├── Events/  Listeners/   Événements métier et subscribers déclenchant les notifications
├── Http/Controllers/     Un contrôleur par module
├── Http/Middleware/      AdminOnly, CheckRole (role:…), SetLocale
├── Models/  Observers/   Modèles Eloquent, journal d'audit, synchronisation des statuts
├── Notifications/        Notifications base de données / e-mail
└── Services/             AttributionService, NotificationService, AuditLogger
database/migrations/      Schéma (38 migrations)
database/seeders/         DemoSeeder (démonstration) et seeders d'origine
resources/views/          Vues Blade par module
routes/web.php            Routes et groupes de permissions
tests/Feature/            Tests Pest des parcours critiques
docs/                     Captures, galerie GitHub Pages, étude de cas, journal de travail
portfolio-export/         Dossier de présentation du projet pour un portfolio
```

---

## D. Technologies

Versions installées et vérifiées (`composer.lock`, `package-lock.json`).

| Couche | Technologie |
|---|---|
| Langage | PHP ≥ 8.2 (validé avec PHP 8.4.6) |
| Framework | Laravel 12.44 |
| Base de données | MySQL ou MariaDB (validé avec MariaDB 10.4.32) |
| PDF | barryvdh/laravel-dompdf 3.1 (dompdf 3.1.4) |
| Front-end compilé | Vite 7.3, Tailwind CSS 4.1, laravel-vite-plugin 2.0, axios 1.21 |
| Front-end chargé par CDN | Alpine.js 3, ApexCharts, SortableJS 1.15, intl-tel-input 24.5, GSAP 3.12 et Three.js r128 (page d'accueil) |
| Tests | Pest 4.3 (PHPUnit 12.5) |
| Outillage | Laravel Pint, Laravel Pail, Laravel Boost |

---

## E. Modules et fonctionnalités

| Module | Fonctionnalités |
|---|---|
| **Authentification et rôles** | Connexion par e-mail et mot de passe, limitation à 5 tentatives par minute et par IP, redirection vers le tableau de bord du rôle, demande d'accès publique validée par un administrateur. |
| **Tableaux de bord** | Administrateur : leads, CA prévisionnel, actions en attente, répartition par stade. Commercial : CA prévisionnel personnel, conversion, quota mensuel, retards, rendez-vous. Support : tickets par statut et priorité, file d'attente, urgences. Rappel des tâches du jour et en retard à l'ouverture. |
| **Contacts et prospects** | Liste avec recherche, filtres (entreprise, source, commercial) et tri ; création, modification, suppression ; fiche à onglets (vue d'ensemble, opportunités, journal, rappels), notes, activités, tâches et tickets liés ; export CSV ; conversion en opportunité. |
| **Pipeline et opportunités** | Vue Kanban et vue liste ; total, valeur pondérée et taux de conversion ; transitions d'étape par modales (premier contact, besoin et budget, proposition avec document, négociation, motif de perte) ; historique des stades ; mise à jour automatique du statut du contact. |
| **Attribution des commerciaux** | Attribution manuelle ou automatique selon des règles priorisées : source du contact, montant supérieur à un seuil, secteur, équilibrage de charge. Historique des attributions et notification du commercial. |
| **Tâches et calendrier** | Kanban à faire / en cours / terminé, agenda semaine et jour combinant tâches et activités, tâches liées à un contact ou une opportunité, priorités et échéances. |
| **Support et tickets** | Tickets catégorisés et priorisés avec pièce jointe, assignation, réponses, statuts, recherche et filtres, rapports support par période en PDF. |
| **Notifications** | Cloche avec compteur, liste, lecture, suppression ; envoi par e-mail ; préférences globales et personnelles par type d'événement. |
| **Rapports CSV / PDF** | Exports des opportunités, contacts et leads, filtrés par période et par commercial ; page imprimable de statistiques ; journalisation de chaque export. |
| **Administration** | Utilisateurs et rôles, demandes d'accès, paramètres de l'organisation, règles d'attribution, journal d'audit, sauvegarde JSON, export RGPD des données d'un utilisateur. |
| **Tâches planifiées** | `app:backup-database` (via `mysqldump`), `tasks:send-reminders`, `tasks:send-overdue-alerts`, `reports:performance-summary`. |

### Rôles et permissions

| Capacité | Admin | Commercial | Support | Visiteur |
|---|:---:|:---:|:---:|:---:|
| Tableau de bord | Global | Personnel | Console support | Lecture (vue globale) |
| Contacts — consultation | Tous | Les siens | Tous | Tous |
| Contacts — création, modification, suppression | ✔ | Les siens | — | — |
| Notes, activités et tickets depuis une fiche contact | ✔ | ✔ | ✔ | — |
| Opportunités — consultation | Toutes | Les siennes | Toutes | Toutes |
| Opportunités — création, transitions, suppression | ✔ | Les siennes | — | — |
| Choix du commercial, attribution automatique | ✔ | — | — | — |
| Tâches — création et mise à jour | ✔ | Assignées ou créées | Assignées ou créées | — |
| Tickets | Tous | Ceux de ses contacts ou créés par lui | Tous | — |
| Rapports et exports | ✔ | Ses données | Rapports support | ✔ |
| Administration | ✔ | — | — | — |

---

## F. Installation

### Prérequis

- PHP 8.2 ou supérieur, avec `pdo_mysql`, `mbstring`, `openssl`, `fileinfo`, `gd`
- Composer 2
- Node.js 20 ou supérieur et npm (seulement pour recompiler les assets : `public/build` est versionné)
- MySQL 8 ou MariaDB 10.4+
- Un navigateur connecté à Internet (certaines bibliothèques front-end sont chargées par CDN)

### 1. Dépendances

```bash
git clone https://github.com/cedrickemmanuel25/CRM.git
cd CRM
composer install
npm install
```

### 2. Configuration `.env`

```bash
cp .env.example .env
php artisan key:generate
```

`.env.example` est prêt pour un usage local : base `crm_portfolio`, cookies de session en HTTP,
locale française, e-mails écrits dans les logs (`MAIL_MAILER=log`). Adapter `DB_HOST`, `DB_PORT`,
`DB_USERNAME` et `DB_PASSWORD` à votre serveur MySQL.

Les notifications passent par la file d'attente (`QUEUE_CONNECTION=database`) : lancer
`php artisan queue:listen`, ou utiliser `QUEUE_CONNECTION=sync` en local.

### 3. Bases de données

```sql
CREATE DATABASE crm_portfolio CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE DATABASE crm_portfolio_test CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 4. Migrations et données de démonstration

```bash
php artisan migrate --seed --seeder=DemoSeeder

# Réinitialiser la base de démonstration
php artisan migrate:fresh --seed --seeder=DemoSeeder
```

Le jeu de démonstration crée 6 comptes, 22 contacts, 20 opportunités, 11 tâches, 7 tickets, des
activités, des règles d'attribution et des demandes d'accès — toutes les données sont fictives.

| Rôle | E-mail | Mot de passe |
|---|---|---|
| Administrateur | `admin@example.com` | `Demo@1234` |
| Commercial | `commercial@example.com` | `Demo@1234` |
| Support | `support@example.com` | `Demo@1234` |
| Visiteur | `visiteur@example.com` | `Demo@1234` |

Le `DatabaseSeeder` d'origine (`php artisan db:seed`) reste disponible pour l'environnement initial du
projet.

### 5. Démarrage

```bash
php artisan serve                          # http://127.0.0.1:8000
npm run dev                                # Vite en mode développement
composer dev                               # serveur, file d'attente et Vite en parallèle

php artisan view:clear && npm run build    # build de production reproductible (public/build)
php artisan schedule:work                  # tâches planifiées en local
```

### 6. Tests

```bash
php artisan test
```

Les tests s'exécutent sur la base `crm_portfolio_test` (déclarée dans `phpunit.xml`) et sont isolés
par `RefreshDatabase`.

---

## G. Qualité

### Tests automatisés

Dernière exécution : **53 tests, 179 assertions, tous réussis.**

| Fichier | Couverture |
|---|---|
| `AuthenticationTest` | Pages publiques, redirection des invités et par rôle, échec de connexion, déconnexion, absence de routes de debug |
| `AuthorizationTest` | Administration et espace support réservés, cloisonnement des contacts, opportunités et tickets entre commerciaux, lecture seule du visiteur |
| `CrmWorkflowTest` | Contacts, activités et tâches liées, transitions de stade avec historique, opportunité gagnée, tickets, demandes d'accès, maintenance, export CSV, indicateurs commerciaux, calcul des durées |
| `DemoSmokeTest` | Ouverture de chaque écran principal pour chaque rôle sur le jeu de démonstration, génération des PDF |

Rejoués sur le code antérieur aux corrections, 13 de ces tests échouaient : ils couvrent bien les
anomalies traitées. Le détail (cause, correction, validation) figure dans
[`docs/WORK_LOG.md`](docs/WORK_LOG.md).

### Autorisations et protections

- mots de passe hachés (bcrypt), régénération de session à la connexion, protection CSRF ;
- limitation des tentatives de connexion ;
- contrôle d'accès par rôle et par propriétaire, couvert par des tests ;
- validation des entrées, types d'objets liés limités à une liste blanche ;
- journal d'audit des actions sensibles et des exports ;
- aucun script de diagnostic exposé dans `public/` ni route de debug.

### Limitations connues

- La demande d'accès publique permet de demander n'importe quel rôle, y compris administrateur ; la
  création du compte reste soumise à validation.
- La réinitialisation d'un mot de passe par un administrateur le fixe à `password` ; le mot de passe
  temporaire d'une demande approuvée est affiché à l'administrateur.
- Le rôle visiteur voit les indicateurs globaux et peut exporter l'ensemble des données.
- Deux commandes déclarent la même signature `tasks:send-reminders` ; une seule est enregistrée.
- Le quota mensuel des commerciaux est fixé dans le code (50 000 €).
- Certaines actions sur les utilisateurs sont journalisées deux fois (observateur et contrôleur).
- Alpine.js est chargé deux fois sur la fiche opportunité et la page des règles d'attribution (aucun
  effet constaté).
- Les activités et tâches créées avant correction avec un nom de classe complet nécessiteraient une
  migration de données pour apparaître sur leur fiche.
- En production, la racine web doit pointer sur `public/`.

### Auteur et liens

Projet conçu et développé par **cedrickemmanuel25**.

- Profil GitHub : [github.com/cedrickemmanuel25](https://github.com/cedrickemmanuel25)
- Dépôt : [github.com/cedrickemmanuel25/CRM](https://github.com/cedrickemmanuel25/CRM)
- Démonstration visuelle : [cedrickemmanuel25.github.io/CRM](https://cedrickemmanuel25.github.io/CRM/)
- Étude de cas : [`docs/PORTFOLIO_CASE_STUDY.md`](docs/PORTFOLIO_CASE_STUDY.md)
- Dossier portfolio : [`portfolio-export/`](portfolio-export/)
