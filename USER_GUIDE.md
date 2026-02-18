# 📄 Rapport de Référence & Manuel d’Exploitation : CRM NEXUS Pro
*Architecture, Manipulation et Gouvernance Métier*

---

## 🏛️ I. PRÉSENTATION GÉNÉRALE
Le CRM **Nexus Pro** est une infrastructure digitale centralisée dédiée au pilotage de la relation client. Ce rapport a été conçu pour offrir une compréhension totale de l'outil, de son installation technique à sa manipulation quotidienne par les équipes terrain et administratives.

### 1.1. Philosophie de l'Outil
L'application repose sur la **traçabilité** et l'**interconnexion**. Rien n'est isolé : un contact génère une affaire, qui génère une tâche, qui produit une donnée statistique pour la direction.

---

## 📱 II. ACCÈS, INSTALLATION ET ERGONOMIE

### 2.1. Le concept de "PWA" (Application Web Progressive)
L'application ne nécessite pas de téléchargement sur un Store. Elle s'installe directement depuis votre navigateur habituel.

*   **💻 Sur Ordinateur** : Utilisez le bouton **"Installer l'App"** pour transformer le CRM en un logiciel de bureau indépendant de votre navigateur. La navigation se fait via la **Sidebar (Barre latérale noire)** à gauche.
*   **📱 Sur Smartphone (Android/iOS)** : 
    *   *Android* : Bouton "Télécharger" dans l'en-tête.
    *   *iPhone* : Bouton "Télécharger" + Menu "Partager" + "Sur l'écran d'accueil".
    *   *Manipulation* : Tout est accessible via le **Menu Hamburger (☰)** en haut à droite.

### 2.2. Robustesse de Session (Heartbeat)
Pour un confort maximal, le système intègre un "battement de cœur" invisible qui maintient votre session active indéfiniment tant que l'onglet est ouvert. Vous ne serez pas déconnecté au milieu d'une saisie.

---

## 🧭 III. GUIDE DE MANIPULATION PAR MODULE

### 3.1. Pages Publiques (Portail d'entrée)
*   **Accueil** : Présentation vitrine et point d'installation.
*   **Connexion** : Identifiez-vous pour accéder au CRM.
*   **Demande d'Accès** : Pour les nouveaux utilisateurs n'ayant pas encore de compte.

### 3.2. Le Tableau de Bord (Dashboard)
**Objectif** : Mesurer la performance à l'instant T.
*   **Indicateurs (KPIs)** : Chiffre d'affaires potentiel, Taux de signature, Missions urgentes.
*   **Graphiques** : Visualisez d'où viennent vos clients (Source) et comment votre pipeline évolue.
> *[Action : Cliquez sur les graphiques pour voir les détails]*

### 3.3. Module Contacts (Le Cœur du Répertoire)
*   **Liste des Contacts** : Tableau de bord de tous vos interlocuteurs.
*   **Fiche Détail** : L'écran le plus important. Il comporte des **onglets** :
    *   *Vue d'ensemble* : Les dernières notes.
    *   *Pipeline* : Les ventes liées à ce client.
    *   *Activités* : Le journal complet de tout ce qui a été fait.
    *   *Rappels* : Vos tâches futures pour ce client.

### 3.4. Module Opportunités (Le Tunnel de Vente)
*   **Vue Pipeline (Kanban)** : Cet écran permet de déplacer visuellement vos ventes.
*   **Manipulation** : Faites glisser une carte de "Prospection" vers "Négociation". Un formulaire s'ouvrira pour qualifier l'étape (budget, besoins).
*   **Won/Lost** : Marquez une affaire comme "Gagnée" pour qu'elle compte dans vos revenus.

### 3.5. Module Agenda & Tâches
**Objectif** : Ne jamais oublier une relance.
*   **Vue Agenda** : Un calendrier couleur pour organiser vos journées.
*   **Priorités** : Les tâches s'affichent différemment selon leur urgence (Haute, Moyenne, Faible).

---

## 🔠 IV. LEXIQUE DES BOUTONS (À QUOI SERVENT-ILS ?)

| Bouton / Icône | Nom | Rôle et Action |
| :--- | :--- | :--- |
| **[+] Nouveau** | Création | Ouvre un formulaire vide pour ajouter une nouvelle donnée. |
| **Convertir** | Transformation | Transforme un contact froid en une opportunité de vente réelle. |
| **Gagné (Check Vert)** | Clôture Positive | Ferme l'affaire car le contrat est signé. Alimente le C.A. |
| **Perdu (Croix Rouge)** | Clôture Négative | Ferme l'affaire avec un motif d'échec pour analyse future. |
| **Note (Bulle)** | Consignation | Ajoute un commentaire interne historique sur un client. |
| **Exporter** | Extraction | Génère un fichier Excel ou PDF de vos données. |
| **Rappel (Cloche)** | Planification | Crée une alerte automatique pour le futur. |
| **(☰) Hamburger** | Menu Mobile | Ouvre les rubriques du CRM sur smartphone. |

---

## 🛡️ V. ADMINISTRATION & GOUVERNANCE (POUR LES ADMINS)

*   **Gestion des Utilisateurs** : Validation des nouvelles demandes d'accès et attribution des rôles.
*   **Journal d’Audit** : Le "cerveau" de sécurité. Il liste chaque modification (Qui a changé quoi et quand ?).
*   **Maintenance** : Outil de sauvegarde (Backup) complet de la base de données.
*   **Paramètres Généraux** : Modification du logo et du nom de l'entreprise sur toute la plateforme.

---

## 🎭 VI. MATRICE DES DROITS (QUI FAIT QUOI ?)

### 6.1. Rôle Administrateur
A accès à **TOUT**. Il configure le système, valide les accès et surveille l'audit.

### 6.2. Rôle Commercial
Focalisé sur la **vente**. Il gère ses propres contacts, ses opportunités et ses tâches. Il n'a pas accès aux paramètres système ni au journal d'audit global.

---

## 🚀 VII. CONCLUSION
Le CRM Nexus Pro a été pensé pour que chaque manipulation soit logique et rapide. L'interconnexion entre les contacts, les ventes et l'agenda garantit qu'aucune information ne soit isolée ou perdue.

---
*Ce rapport est prêt pour insertion dans un document Word de présentation officielle.*
