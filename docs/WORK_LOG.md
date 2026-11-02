# Journal de travail — Finalisation du CRM

Journal tenu pendant la finalisation (novembre 2026). Chaque problème porte un identifiant
unique ; une ligne n'est passée en « Résolu » qu'après un test de validation effectif.

## Environnement constaté (étape 1)

| Élément | Version / état |
|---|---|
| PHP | 8.4.6 (CLI) — extensions pdo_mysql, pdo_sqlite, gd, mbstring, zip présentes |
| Composer | 2.9.2 |
| Node.js / npm | 24.7.0 / 11.5.1 |
| SGBD | MariaDB 10.4.32 (XAMPP, service Windows `mysql`, port 3306) |
| Laravel | 12 (voir `composer.lock`) |
| Bases existantes | `deliverygo_hq`, `deliverygo_hq_test`, `laravel`, `phpmyadmin`, `test` — **aucune touchée** |
| Bases créées | `crm_portfolio` (démo), `crm_portfolio_test` (tests automatisés) |

## Problèmes

| ID | Problème | Cause identifiée | Fichier(s) | Correction | Validation | Statut |
|---|---|---|---|---|---|---|
| SEC-01 | Identifiants de production versionnés | Fichier `.env.production.example` rempli avec des valeurs réelles au lieu d'exemples | `.env.production.example` | Valeurs remplacées par des exemples. L'historique Git conservant l'ancienne version, les identifiants concernés doivent être changés côté serveur (la réécriture d'historique est exclue) | Recherche des valeurs : aucune occurrence dans l'arbre de travail | Résolu dans le code — **rotation des identifiants à effectuer** |
| SEC-02 | Scripts de diagnostic exécutables sans authentification (lecture des logs, vidage du cache, affichage de la config et des traces) | Fichiers PHP autonomes laissés dans `public/` lors du débogage cPanel | `public/read-logs.php`, `public/clear-cache-server.php`, `public/session-check.php`, `public/simple-test.php`, `public/test_syntax.js` | Fichiers supprimés ; `DEPLOY_INSTRUCTIONS.md` mis à jour | Requête anonyme : 200 avant → 404 après | Résolu |
| SEC-03 | Routes de debug et route de maintenance modifiant les données en GET, accessibles à tout utilisateur connecté (y compris visiteur) | Routes de test oubliées : `/test-public`, `/debug-routing-*`, `/fix-encoding` (doublon de la migration `fix_contacts_encoding`) | `routes/web.php`, `OpportunityController` | Routes et méthode `getRoutingDiagnostic` supprimées | Visiteur sur `/fix-encoding` : 200 avant → 404 après | Résolu |
| SEC-04 | Le rôle « visiteur » (lecture seule) pouvait changer le stade d'une opportunité | Route `opportunities.processTransition` placée hors du groupe `role:admin,commercial` (« pour test ») et le contrôleur ne bloquait que le support | `routes/web.php` | Route déplacée dans le groupe `role:admin,commercial` | Visiteur : stade modifié (302) avant → 403, stade inchangé en base | Résolu |
| SEC-05 | Visiteur pouvait modifier le statut pipeline d'un contact, journaliser des interactions et créer des activités | Routes `contacts.updateStage`, `contacts.logInteraction`, `activities.store` sous simple middleware `auth` | `routes/web.php` | `updateStage` → `role:admin,commercial` ; `logInteraction` et `activities.store` → `role:admin,commercial,support` (comme `addActivity`) | Visiteur : 302/500 avant → 403 ; commercial sur son contact : 200 | Résolu |
| SEC-06 | Un commercial pouvait éditer, clôturer ou répondre à un ticket qu'il n'a pas le droit de consulter | Contrôle d'appartenance présent dans `show` uniquement | `TicketController` | Contrôle factorisé (`authorizeCommercialAccess`) et appliqué à `show`, `edit`, `update`, `addResponse` | Commercial : ticket clôturé (302) avant → 403, statut inchangé ; support : toujours autorisé | Résolu |
| BUG-01 | `/support/tickets` : erreur 500 pour le rôle support | Classe `Activity` utilisée sans import dans `ReportController` | `ReportController` | Ajout de `use App\Models\Activity;` | 500 → 200 | Résolu |
| BUG-02 | Les activités et tâches créées depuis la fiche contact (et la fiche opportunité) n'y apparaissaient jamais | Les formulaires envoient `App\Models\Contact` alors que `AppServiceProvider` déclare un `morphMap` (`contact`) ; `$contact->activities()` cherche donc `parent_type = 'contact'` | `ActivityController`, `TaskController` | Type converti en alias via `Relation::getMorphAlias()` et liste blanche des types acceptés | Activité + tâche créées : absentes de la fiche avant → présentes après ; type `App\Models\User` refusé | Résolu (les lignes déjà enregistrées en production avec le nom de classe restent à migrer, voir limites) |
| BUG-03 | Bouton « Vidanger la corbeille » (Maintenance et Paramètres) : erreur 500 | `onlyTrashed()` appelé sur `User`/`Contact` alors que les `SoftDeletes` ont été retirés par les migrations du 21/01/2026 | `AdminController::cleanup` | Purge limitée aux modèles qui utilisent encore `SoftDeletes` | 500 → redirection avec message de succès | Résolu |
| BUG-04 | Installation locale : connexion impossible (HTTP 419) avec le `.env.example` fourni | `SESSION_DOMAIN=ya-consulting.com` et `SESSION_SECURE_COOKIE=true` : le cookie de session est refusé en HTTP local | `.env.example` | Valeurs locales (`SESSION_DOMAIN=null`, cookie non sécurisé, locale `fr`, base `crm_portfolio`) | Serveur lancé avec les anciennes valeurs : 419 ; avec les nouvelles : connexion OK | Résolu |
| BUG-05 | `POST /contacts/{id}/opportunity` : erreur SQL 500 | `commercial_id` (NOT NULL) non renseigné, champ `date_cloture_estimee` inexistant | `ContactController::addOpportunity` | `commercial_id` = propriétaire du contact, `date_cloture_prev` | 500 → 302, opportunité créée. Route non utilisée par l'interface | Résolu |
| BUG-06 | Erreur 500 si un champ facultatif est omis (`notes` pour une interaction, `description` pour une tâche) | Accès direct `$validated['…']` à une clé absente | `ContactController::logInteraction`, `TaskController::store` | Valeur par défaut `?? null` | 500 → 200/302. Les formulaires de l'interface envoient toujours ces champs | Résolu |
| DEP-01 | 18 vulnérabilités npm (dont 4 critiques) | Paquets `build@0.1.4` et `run@1.5.0` déclarés en dépendances de production mais jamais importés (dépendances transitives obsolètes) + versions vulnérables d'axios, etc. | `package.json`, `package-lock.json` | Paquets retirés, `npm audit fix` (sans `--force`) | `npm audit` : 18 → 0 vulnérabilité ; `npm run build` OK | Résolu |
| DEP-02 | Assets compilés versionnés obsolètes | `public/build` compilé le 18/02/2026, vues modifiées jusqu'au 03/03/2026 | `public/build/*` | Recompilation (`npm run build`) | Les 23 sélecteurs disparus ne sont plus utilisés dans `resources/` | Résolu |
| HYG-01 | Fichiers de travail versionnés (sorties de recherche de 5,8 Mo, logs avec chemins locaux, script de debug) | Fichiers temporaires ajoutés par erreur | `search_*.txt`, `temp_log.txt`, `error_log.txt`, `debug_output.txt`, `last_commit_files.txt`, `recently_modified.csv`, `debug_chart.php` | Supprimés du dépôt | `git status` | Résolu |
| UI-01 | Landing : liens de navigation « Modules » et « Sécurité » inopérants | Ancres `#modules` et `#security` absentes de la page (jamais présentes dans l'historique) | `welcome.blade.php` | `id` ajoutés sur les cartes existantes « Pipeline de vente » et « Sécurité avancée » (aucun changement visuel) | Playwright : clic → défilement jusqu'à la carte (desktop et menu mobile) | Résolu |
| UI-02 | Création/édition d'opportunité : sélecteur de contact vide, erreur JS `Unexpected token ','` | Initiales calculées avec `substr()` (octets) : un prénom accentué (« Élise ») produit de l'UTF-8 invalide, `json_encode` échoue et le JS rendu devient `contacts: ,` | `opportunities/_form.blade.php` | `mb_substr` / `mb_strtoupper` | JSON des contacts rendu ; 0 erreur JS | Résolu |
| UI-03 | Avatars : initiale affichée « � » pour les noms accentués | Même cause (`substr` sur chaînes UTF-8) dans 16 vues | 16 vues (avatars/initiales) | `mb_substr` / `mb_strtoupper` sur les seules lignes concernées | Rendu vérifié | Résolu |
| UI-04 | Pipeline : 5 modales de transition sur 6 hors de portée Alpine (`showQualificationModal is not defined`…) | Le commit `7f21b1d` (« center modals ») a supprimé un `<div>` enveloppant dans chaque modale sans supprimer sa balise fermante : un `</div>` orphelin par modale fermait le composant `pipelineView` | `opportunities/_modals.blade.php` | Suppression des 6 balises orphelines | DOM analysé sans JS : les 6 modales sont dans `pipelineView` ; 0 erreur JS | Résolu |
| UI-05 | Pipeline : la validation d'une modale de transition ne changeait pas le stade (formulaire posté vers `POST /opportunities`) | Même commit `7f21b1d` : suppression de la ligne qui renseignait `transitionUrl` dans `handleStageRequest` | `opportunities/index.blade.php` | Ligne rétablie (`route('opportunities.processTransition')`) | Playwright : qualification → proposition via la modale, stade + besoin + historique enregistrés en base | Résolu |
| UI-06 | Fiche opportunité : 6 modales hors du composant `opportunityData` (erreurs JS au chargement) | Deux `</div>` en trop avant `@include('opportunities._modals')` fermaient le composant puis `<main>` | `opportunities/show.blade.php` | Balises retirées (vérifié dans le DOM parsé) | 0 erreur JS ; modales enfants du composant | Résolu |
| UI-07 | Icône « perdu » de la barre d'étapes : erreur console `Expected arc flag` | Tracé SVG mal formé (`a8 0` au lieu de `a8 8 0`) | `opportunities/partials/_status_bar.blade.php` | Tracé corrigé (icône Heroicons `x-circle`) | 0 erreur console | Résolu |
| UI-08 | Support : bouton « Nouveau ticket » sans effet (dashboard support et page Tickets support) | Modale placée après la fermeture du conteneur `x-data` qui déclare sa variable | `support/dashboard.blade.php`, `support/tickets.blade.php` | Fermeture du conteneur déplacée après la modale | Playwright : modale fermée → ouverte au clic ; 0 erreur JS | Résolu |
| UI-09 | Dashboard support : le graphique « Volume par statut » déborde sous sa carte | Option ApexCharts `height: '100%'` rendue à 400 px dans un conteneur `h-80` (320 px) | `support/dashboard.blade.php` | Hauteur explicite `320` | Mesure Playwright : SVG 400 → 320 px, contenu dans la carte | Résolu |
| BUG-07 | Dashboard commercial : jauge « Quota mensuel » à 0 % affichant « 125 200 € réalisé » | Le pourcentage est calculé sur le CA gagné du mois, mais le libellé affichait le CA prévisionnel (affaires en cours) | `DashboardController`, `commercial/dashboard.blade.php` | Le libellé affiche le montant gagné utilisé pour le pourcentage (`goal_actual`, requête factorisée dans `wonThisMonth`) | Test automatisé : 10 000 € gagnés + 50 000 € en cours → « 10 000 € réalisé », 20 % | Résolu |
| BUG-08 | Durées négatives et décimales : « -4 jours » dans le stade (liste des opportunités), retard « -3.99 jours » dans les alertes de tâches | Depuis Carbon 3 (Laravel 11+), `now()->diffInDays($datePassée)` renvoie une valeur signée et flottante | `Opportunity::getTimeInStageAttribute`, `SendOverdueAlerts`, `TaskOverdueNotification` | `(int) $datePassée->diffInDays(now())` | Test automatisé (4 jours dans le stade, 3 jours de retard) ; commande `tasks:send-overdue-alerts` exécutée : valeurs positives | Résolu |
| UI-10 | Liste des tickets : statuts affichés en codes bruts (`IN_PROGRESS`, `WAITING_CLIENT`) | Valeur brute affichée alors que les libellés français existent dans le filtre de la même page | `tickets/index.blade.php` | Table de libellés (même modèle que `$priorityLabels` de la fiche ticket) | Capture vérifiée | Résolu |
| UI-11 | Landing : retrait du badge « Plateforme Professionnelle » (demande du propriétaire) | Badge décoratif (`div.reveal` avec point animé et libellé) devenu inutile sans son texte | `welcome.blade.php` | Badge supprimé ; titres, paragraphes, illustrations et boutons inchangés | Captures intégrales desktop (1440 × 1718) et mobile (390 × 2256) inspectées : contenu centré, aucune erreur JS | Résolu |
| HYG-02 | `clear-cache.php` (racine) exécutable via HTTP si le dossier du projet est exposé (cas du déploiement cPanel décrit) | Aucun contrôle du SAPI | `clear-cache.php` | Refus (404) hors ligne de commande | Script exécuté en CLI : OK | Résolu |

## Parcours vérifiés (étape 2)

Vérifications réalisées par requêtes HTTP authentifiées (avec contrôle en base), puis dans le
navigateur avec Playwright. « Corrigé » renvoie à l'identifiant du problème ci-dessus.

| Module | Parcours | Résultat |
|---|---|---|
| Authentification | Connexion des 4 rôles et redirection vers leur tableau de bord, échec de connexion, déconnexion | Réussi |
| Authentification | Demande d'accès publique → approbation (compte créé) / rejet | Réussi |
| Authentification | Connexion locale avec le `.env.example` fourni | Corrigé (BUG-04) |
| Tableaux de bord | Admin, commercial, support, visiteur : affichage sans erreur | Réussi |
| Tableaux de bord | Graphique de la console support, quota du dashboard commercial | Corrigé (UI-09, BUG-07) |
| Contacts | Liste, recherche AJAX, création, édition, fiche, note, export CSV | Réussi |
| Contacts | Activité / tâche créée depuis la fiche visible sur la fiche | Corrigé (BUG-02) |
| Contacts | Cloisonnement entre commerciaux (403 sur le contact d'un autre) | Réussi |
| Opportunités | Création manuelle et automatique, changement de stade AJAX, marquer gagnée, édition avec réattribution, suppression, historique et audit | Réussi |
| Opportunités | Modales de transition du pipeline et sélecteur de contact du formulaire | Corrigé (UI-02, UI-04, UI-05, UI-06, UI-07) |
| Attribution | Règle « montant > 50 000 € » appliquée en création automatique ; création / suppression de règle | Réussi |
| Tâches et calendrier | Création, passage à « terminé », suppression, Kanban, vue agenda | Réussi |
| Tickets et support | Création par le support (notification aux admins), réponse, changement de statut, rapports PDF | Réussi |
| Tickets et support | Page `/support/tickets`, bouton « Nouveau ticket » | Corrigé (BUG-01, UI-08) |
| Notifications | Liste, compteur, lecture, suppression, préférences | Réussi |
| Rapports | Exports CSV (opportunités, contacts, leads), PDF (opportunités, leads), page imprimable | Réussi |
| Administration | Utilisateurs (création, modification, réinitialisation, suppression), paramètres, sauvegarde JSON, export RGPD, export CSV des utilisateurs | Réussi |
| Administration | « Vidanger la corbeille » | Corrigé (BUG-03) |
| Permissions | Visiteur en lecture seule, tickets réservés au périmètre du commercial | Corrigé (SEC-04, SEC-05, SEC-06) |
| Commandes planifiées | `tasks:send-reminders`, `tasks:send-overdue-alerts`, `reports:performance-summary` | Réussi (durées corrigées : BUG-08) |
| Commandes planifiées | `app:backup-database` | Réussi lorsque `mysqldump` est dans le PATH ; sinon échec signalé et fichier vide laissé (prérequis d'environnement, documenté) |
| E-mails | Envoi SMTP réel | Non testable localement (`MAIL_MAILER=log`) |
| PWA | Installation sur mobile | Non testé |

## Recette finale (étape 6)

| Vérification | Résultat |
|---|---|
| Syntaxe PHP des fichiers modifiés (`php -l`) | Aucune erreur |
| Compilation de toutes les vues Blade (`php artisan view:cache`) | Réussie |
| Build front (`npm run build`) | Réussi — build déterministe réalisé après `php artisan view:clear` (le CSS dépend sinon des vues compilées présentes dans `storage/`) |
| `npm audit` | 0 vulnérabilité |
| Tests automatisés (`php artisan test`) | 53 réussis, 179 assertions |
| Tests rejoués sur le code d'origine | 13 échecs, correspondant aux anomalies corrigées |
| Audit Playwright : 50 écrans × 2 formats (1440×1024, 390×844), 5 profils (invité, admin, commercial, support, visiteur) | 100 chargements en HTTP 200, 0 erreur JavaScript, 0 requête en échec, 0 débordement horizontal |
| Captures `docs/screenshots/` | 21 captures réelles (16 desktop, 5 mobile) sur base de démonstration réinitialisée |
| Diagramme Mermaid du README | Rendu vérifié avec Mermaid 11 |
| Liens et images du README et de l'étude de cas | Tous présents |
| Secrets dans les fichiers à committer | Aucun |

## Constats non corrigés

Points relevés mais laissés en l'état (pas d'anomalie bloquante confirmée, ou changement de
comportement à décider par le propriétaire du projet). Ils sont repris dans le README.

- Demande d'accès publique : le rôle « admin » peut être demandé (validation manuelle requise).
- Réinitialisation de mot de passe à la valeur fixe `password` ; mot de passe temporaire affiché après approbation d'une demande.
- Le rôle visiteur peut exporter l'ensemble des données.
- Deux commandes partagent la signature `tasks:send-reminders`.
- Quota commercial codé en dur (50 000 €).
- Double journalisation de certaines actions sur les utilisateurs (observateur + contrôleur).
- Alpine.js chargé deux fois sur la fiche opportunité et la page des règles d'attribution : une seule initialisation constatée, aucun effet observé.
- Fiche opportunité : les modales de transition y sont présentes mais aucun élément de la page ne les ouvre (la méthode `changeStage` n'est pas appelée) ; les transitions se font depuis le pipeline.
- Données de production antérieures : les activités/tâches enregistrées avec un nom de classe complet nécessiteraient une migration de données (BUG-02).

## Présentation portfolio (seconde mission)

| Élément | Détail | Vérification |
|---|---|---|
| Captures de la landing | `landing-desktop.png` (1440 × 1718) et `landing-mobile.png` (390 × 2256), pleine page après défilement progressif ; les anciennes `landing.png` et `mobile-landing.png`, qui montraient encore le badge retiré, sont supprimées. La page ne comporte pas de pied de page : la capture s'arrête après la dernière carte de la section fonctionnalités. | Dimensions lues dans les fichiers ; inspection visuelle |
| Galerie GitHub Pages | `docs/index.html` (redirection), `docs/demo/` (HTML, CSS, JS sans dépendance), `docs/.nojekyll` | Playwright desktop et mobile : 21/21 images chargées, 0 erreur, 0 débordement, navigation par module et visionneuse fonctionnelles |
| Dossier portfolio | `portfolio-export/` : présentation, étude de cas, technologies, fonctionnalités, architecture, captures | Liens et images vérifiés |
