# Technologies

Versions relevées dans `composer.lock` et `package-lock.json`, et environnement de validation.

## Back-end

| Technologie | Version | Usage |
|---|---|---|
| PHP | ≥ 8.2 (validé en 8.4.6) | Langage |
| Laravel | 12.44 | Framework : routes, middleware, Eloquent, événements, notifications, planificateur |
| MySQL / MariaDB | validé en MariaDB 10.4.32 | Base de données relationnelle |
| barryvdh/laravel-dompdf | 3.1 (dompdf 3.1.4) | Génération des rapports PDF |

## Interface

| Technologie | Version | Usage |
|---|---|---|
| Blade | Laravel 12 | Rendu serveur des vues |
| Tailwind CSS | 4.1 | Mise en forme, compilée par Vite |
| Vite / laravel-vite-plugin | 7.3 / 2.0 | Build des assets |
| Alpine.js | 3 (CDN) | Modales, Kanban, filtres, rafraîchissement AJAX |
| ApexCharts | CDN | Graphiques des tableaux de bord |
| SortableJS | 1.15 (CDN) | Glisser-déposer |
| intl-tel-input | 24.5 (CDN) | Saisie des numéros de téléphone internationaux |
| GSAP / Three.js | 3.12 / r128 (CDN) | Animations de la page d'accueil |

## Qualité et outillage

| Technologie | Version | Usage |
|---|---|---|
| Pest | 4.3 (PHPUnit 12.5) | Tests automatisés (53 tests) |
| Playwright | — | Recette navigateur et captures (outil de recette, hors dépendances du projet) |
| Laravel Pint, Pail, Boost | — | Formatage, suivi des logs, outillage de développement |

## Hébergement visé

Hébergement mutualisé cPanel : les assets compilés sont versionnés (`public/build`) pour un déploiement
sans Node.js ; la procédure est documentée dans `DEPLOY_INSTRUCTIONS.md`.
