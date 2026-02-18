# Rapport de Présentation
# CRM Nexus Pro — Plateforme de Gestion de la Relation Client

---

**Document :** Rapport de Présentation Fonctionnelle et Opérationnelle
**Objet :** Description exhaustive de la plateforme CRM Nexus Pro, de ses modules et de ses modalités d'utilisation
**Destinataires :** Direction, Équipes Commerciales, Administrateurs Système

---

## Avant-Propos

Ce rapport a pour vocation de présenter de manière exhaustive la plateforme **CRM Nexus Pro**, un outil de gestion de la relation client développé sur mesure pour répondre aux besoins opérationnels des équipes commerciales et administratives. Il décrit l'ensemble des fonctionnalités disponibles, les modalités d'accès et d'utilisation, ainsi que les règles de gouvernance applicables selon les profils d'utilisateurs.

---

## Partie I — Présentation Générale de l'Application

### 1.1. Qu'est-ce qu'un CRM ?

Un **CRM** (Customer Relationship Management, ou Gestion de la Relation Client) est un système d'information centralisé qui permet à une organisation de gérer, suivre et analyser l'ensemble de ses interactions avec ses clients et prospects. Il constitue la mémoire institutionnelle de l'activité commerciale : chaque contact, chaque échange, chaque opportunité de vente y est enregistré, structuré et exploitable.

Sans CRM, les informations clients sont dispersées dans des fichiers Excel, des carnets de notes ou des boîtes email individuelles, rendant toute collaboration difficile et toute analyse impossible. Le CRM centralise cette connaissance et la met à disposition de toute l'équipe, en temps réel.

### 1.2. Présentation de Nexus Pro

**Nexus Pro** est une plateforme CRM développée avec le framework **Laravel** (PHP), reconnue pour sa robustesse et sa sécurité. L'interface utilisateur est construite avec **Tailwind CSS** et **Alpine.js**, garantissant une expérience moderne, réactive et fluide sur tous les types d'appareils.

La plateforme est déployée en tant que **Progressive Web App (PWA)**, ce qui signifie qu'elle combine les avantages d'un site web (accessible depuis n'importe quel navigateur) et d'une application mobile native (installable sur l'écran d'accueil, utilisable hors connexion partielle, notifications push).

### 1.3. Objectifs de la Plateforme

La plateforme Nexus Pro a été conçue pour atteindre les objectifs stratégiques suivants :

- **Centralisation de la donnée client** : Regrouper en un seul endroit toutes les informations relatives aux contacts, aux entreprises et aux historiques d'échanges.
- **Pilotage du cycle de vente** : Offrir une visibilité complète sur l'état du pipeline commercial, de la prospection à la conclusion de la vente.
- **Amélioration de la productivité** : Automatiser les rappels, les notifications et les tâches récurrentes pour que les commerciaux se concentrent sur la vente.
- **Reporting et aide à la décision** : Fournir à la direction des indicateurs de performance fiables et actualisés en temps réel.
- **Sécurité et traçabilité** : Garantir que chaque action effectuée dans le système est enregistrée, attribuée et auditable.

---

## Partie II — Accès et Installation

### 2.1. Modalités d'Accès

L'application est accessible via un navigateur web standard (Google Chrome, Mozilla Firefox, Safari, Microsoft Edge) à l'adresse URL fournie par l'administrateur système. Aucune installation de logiciel supplémentaire n'est requise pour une utilisation basique.

L'accès est conditionné à la possession d'un compte utilisateur valide, créé et activé par un administrateur. Tout nouveau collaborateur souhaitant accéder à la plateforme doit soumettre une demande d'accès via le formulaire dédié, qui sera ensuite validée par un administrateur.

### 2.2. Installation en Mode Application (PWA)

Pour une expérience optimale, notamment sur mobile, il est fortement recommandé d'installer l'application sur l'écran d'accueil de l'appareil. Cette procédure, appelée installation PWA, transforme le site web en une application à part entière, avec sa propre icône et son propre écran de lancement.

**Sur Android (navigateur Google Chrome) :**
1. Ouvrir l'URL de l'application dans Chrome.
2. Un bouton **"Installer l'App"** ou **"Télécharger"** apparaît dans l'en-tête de la page.
3. Cliquer sur ce bouton. Une fenêtre de confirmation native d'Android s'affiche.
4. Confirmer l'installation. L'icône de l'application apparaît sur l'écran d'accueil.

**Sur iPhone / iPad (navigateur Safari) :**
1. Ouvrir l'URL de l'application dans Safari.
2. Cliquer sur le bouton **"Télécharger"** dans l'en-tête pour afficher le guide d'installation.
3. Appuyer sur l'icône **"Partager"** de Safari (le carré avec une flèche vers le haut, situé en bas de l'écran).
4. Faire défiler les options et sélectionner **"Sur l'écran d'accueil"**.
5. Confirmer en appuyant sur **"Ajouter"**.

### 2.3. Ergonomie selon le Support

L'interface s'adapte automatiquement à la taille de l'écran de l'appareil utilisé.

**Sur ordinateur de bureau :** L'interface affiche une barre de navigation latérale permanente sur la gauche de l'écran. Cette barre liste tous les modules disponibles et reste visible en permanence, permettant de naviguer rapidement d'un module à l'autre sans perdre le contexte de travail. Le contenu principal occupe le reste de l'écran.

**Sur smartphone et tablette :** Pour maximiser l'espace d'affichage, la barre latérale est masquée par défaut. L'utilisateur accède au menu de navigation en appuyant sur l'icône **"Hamburger" (☰)**, située en haut à droite de l'écran. Ce menu déroule l'ensemble des rubriques disponibles. Les boutons et zones de saisie sont dimensionnés pour une manipulation confortable au doigt.

### 2.4. Persistance de Session

L'application intègre un mécanisme de maintien de session actif, communément appelé **"Heartbeat"**. Ce système envoie automatiquement une requête silencieuse au serveur toutes les cinq minutes, tant que l'onglet de l'application est ouvert dans le navigateur. Ce mécanisme garantit que la session de l'utilisateur ne sera jamais interrompue de manière intempestive, même après une longue période d'inactivité. La durée de vie de la session est configurée à dix ans, assurant une continuité de service totale pour les utilisateurs réguliers.

---

## Partie III — Description Détaillée des Modules

### 3.1. Pages Publiques

Les pages publiques sont accessibles sans authentification. Elles constituent le portail d'entrée de la plateforme.

#### 3.1.1. Page d'Accueil

La page d'accueil est la vitrine institutionnelle de la plateforme. Elle présente l'identité de l'entreprise, les fonctionnalités clés du CRM et les modalités d'accès. C'est également depuis cette page que l'utilisateur peut initier la procédure d'installation de l'application en mode PWA, avant même de se connecter. Elle comporte un bouton de connexion permettant d'accéder directement au formulaire d'authentification.

#### 3.1.2. Page de Connexion

La page de connexion est le portail d'authentification sécurisé de la plateforme. L'utilisateur y saisit son adresse e-mail et son mot de passe. Le système vérifie les informations d'identification, génère un jeton de session chiffré et redirige l'utilisateur vers le tableau de bord correspondant à son rôle. En cas d'identifiants incorrects, un message d'erreur explicite est affiché sans révéler si c'est l'email ou le mot de passe qui est erroné, conformément aux bonnes pratiques de sécurité.

#### 3.1.3. Page de Demande d'Accès

Cette page est destinée aux nouveaux collaborateurs qui ne disposent pas encore d'un compte. L'utilisateur remplit un formulaire avec ses informations personnelles et professionnelles (nom, prénom, adresse e-mail, poste). Une fois soumise, la demande est transmise à l'administrateur système, qui reçoit une notification. L'accès à la plateforme reste bloqué jusqu'à ce que l'administrateur valide explicitement la demande et crée le compte.

---

### 3.2. Tableau de Bord

#### 3.2.1. Tableau de Bord Principal

Le tableau de bord est la première page affichée après la connexion. Il constitue le centre de pilotage stratégique et opérationnel de la plateforme. Son rôle est de fournir une vision synthétique et immédiate de l'état de l'activité commerciale, sans qu'il soit nécessaire de naviguer dans les différents modules.

Les données affichées sont dynamiques et calculées en temps réel à partir des informations enregistrées dans l'ensemble des modules. Elles sont filtrées selon le rôle de l'utilisateur connecté : un Administrateur visualise les statistiques consolidées de toute l'équipe, tandis qu'un Commercial ne voit que les données relatives à son propre portefeuille.

**Composants du tableau de bord :**

- **Indicateurs Clés de Performance (KPIs)** : Quatre à six cartes de synthèse affichent les métriques les plus importantes : le nombre total de contacts actifs dans la base, la valeur cumulée du pipeline commercial (somme des montants de toutes les opportunités en cours), le nombre d'opportunités ouvertes, et le nombre de tâches dont l'échéance est dépassée ou imminente. Ces indicateurs permettent à l'utilisateur d'identifier en un coup d'œil les points d'attention prioritaires.

- **Graphique des Sources d'Acquisition** : Ce graphique représente la répartition des contacts selon leur canal d'origine (ex : site web, appel téléphonique, salon professionnel, recommandation). Il permet à la direction d'évaluer l'efficacité de chaque canal marketing et d'orienter les investissements en conséquence.

- **Graphique d'Évolution du Pipeline** : Une courbe temporelle représente la progression du chiffre d'affaires potentiel sur une période glissante. Elle permet de visualiser les tendances et d'anticiper les variations d'activité.

- **Liste des Tâches Urgentes** : Un récapitulatif des actions planifiées dont l'échéance est proche ou dépassée. Chaque élément est cliquable et redirige directement vers la tâche concernée dans le module Agenda.

---

### 3.3. Module Contacts

Le module Contacts est le référentiel central de la plateforme. Il regroupe l'ensemble des personnes physiques et morales avec lesquelles l'entreprise entretient ou a entretenu une relation commerciale. C'est le point de départ de tout cycle de vente.

#### 3.3.1. Liste des Contacts

La liste des contacts est le tableau de bord du module. Elle affiche l'ensemble des contacts enregistrés sous forme de tableau paginé, avec pour chaque entrée les informations essentielles : nom complet, entreprise, statut commercial, commercial assigné et date de dernière interaction.

L'utilisateur dispose de plusieurs outils pour naviguer efficacement dans cette liste :

- **La barre de recherche** filtre instantanément les résultats à mesure que l'utilisateur tape, sans nécessiter de validation. La recherche porte sur le nom, le prénom, l'entreprise et l'adresse e-mail.
- **Les filtres avancés** permettent de segmenter la liste selon des critères métier précis : la source d'acquisition, le statut commercial (Prospect, Client, Inactif) ou le commercial responsable. Ces filtres peuvent être combinés pour des analyses très ciblées.
- **Le bouton "+ Nouveau Contact"** ouvre le formulaire de création d'un nouveau contact.
- **Les icônes d'action** sur chaque ligne permettent d'accéder à la fiche détaillée (icône œil), d'ouvrir le formulaire de modification (icône crayon) ou de supprimer le contact (icône corbeille, réservée aux Administrateurs).

#### 3.3.2. Nouveau Contact

Le formulaire de création d'un nouveau contact permet d'enregistrer l'ensemble des informations qualifiantes d'un prospect ou d'un client. La qualité des informations saisies à cette étape est déterminante pour la pertinence des analyses futures.

Les champs disponibles sont les suivants :
- **Prénom et Nom** : Identité civile du contact.
- **Adresse e-mail** : Coordonnée principale pour les échanges écrits.
- **Numéro de téléphone** : Coordonnée pour les échanges oraux.
- **Entreprise** : Organisation à laquelle le contact est rattaché.
- **Poste occupé** : Fonction du contact au sein de son organisation, utile pour adapter le discours commercial.
- **Source** : Canal par lequel le contact a été acquis. Cette information est cruciale pour le reporting marketing et l'analyse des canaux d'acquisition.
- **Statut** : Qualification commerciale du contact (Prospect, Client, Partenaire, Inactif).
- **Commercial assigné** : Membre de l'équipe commerciale responsable du suivi de ce contact.
- **Notes initiales** : Champ libre pour consigner les premières observations ou le contexte de la prise de contact.

Une fois le formulaire validé, la fiche contact est créée et l'utilisateur est redirigé vers la vue détaillée du nouveau contact.

#### 3.3.3. Détail d'un Contact

La fiche détaillée d'un contact est l'écran le plus riche et le plus important du module. Elle centralise l'intégralité des informations et des interactions liées à un contact spécifique, organisées en onglets thématiques.

- **Onglet "Vue d'ensemble"** : Affiche les informations de base du contact (coordonnées, entreprise, statut) et un résumé des dernières activités enregistrées.
- **Onglet "Journal d'activité"** : Historique chronologique complet de toutes les interactions avec ce contact. Chaque entrée est horodatée, attribuée à un utilisateur et catégorisée par type (note interne, appel téléphonique, email, réunion). Ce journal constitue la mémoire vivante de la relation commerciale.
- **Onglet "Opportunités"** : Liste de toutes les affaires commerciales associées à ce contact, avec leur stade actuel et leur montant estimé. Permet de visualiser immédiatement l'état de la relation commerciale.
- **Onglet "Tâches & Rappels"** : Actions planifiées en lien avec ce contact, avec leur priorité et leur date d'échéance.

Les boutons d'action principaux disponibles sur cette page sont :
- **"Modifier"** : Ouvre le formulaire d'édition des informations du contact.
- **"Convertir en Opportunité"** : Action stratégique qui crée automatiquement une nouvelle opportunité commerciale pré-remplie avec les informations du contact (nom, entreprise, commercial assigné), évitant toute ressaisie et garantissant la continuité de l'historique.
- **"Ajouter une Note"** : Ouvre un champ de saisie pour consigner un commentaire interne, une observation ou le compte-rendu d'un échange. Ces notes sont visibles par tous les membres de l'équipe ayant accès au contact.
- **"Exporter"** : Génère une fiche PDF synthétique du contact, utilisable hors de la plateforme pour des réunions ou des présentations.

#### 3.3.4. Modifier un Contact

Le formulaire de modification est identique au formulaire de création, mais pré-rempli avec les données actuelles du contact. L'utilisateur peut mettre à jour n'importe quel champ. Toute modification est automatiquement enregistrée dans le journal d'audit du système, avec l'identité de l'auteur de la modification et l'horodatage.

---

### 3.4. Module Opportunités

Le module Opportunités gère le cycle de vie complet des affaires commerciales. Il offre deux modes de visualisation complémentaires : une vue tabulaire pour l'analyse et une vue Kanban pour la gestion opérationnelle.

#### 3.4.1. Liste des Opportunités

La liste des opportunités présente l'ensemble du portefeuille commercial sous forme de tableau. Pour chaque opportunité, les informations affichées sont : l'intitulé de l'affaire, le contact associé, le montant estimé, la probabilité de succès, le stade actuel dans le tunnel de vente et la date de clôture prévue.

Des filtres permettent de segmenter le portefeuille par stade, par commercial responsable ou par période. Un bouton permet de basculer vers la vue Pipeline (Kanban).

#### 3.4.2. Vue Pipeline (Kanban)

La vue Pipeline est la représentation visuelle et interactive du tunnel de vente. Les opportunités sont organisées en colonnes verticales, chacune correspondant à un stade du processus commercial : Prospection, Qualification, Proposition commerciale, Négociation, Gagné, Perdu.

Chaque opportunité est représentée par une carte affichant son intitulé, le nom du contact associé et le montant estimé. L'utilisateur peut faire glisser une carte d'une colonne à l'autre (Drag & Drop) pour signifier la progression de l'affaire dans le tunnel. Cette action déclenche automatiquement un formulaire de qualification permettant de documenter le changement de stade (raison du passage, informations complémentaires).

Cette vue offre une lecture immédiate de la santé du pipeline commercial : une colonne "Prospection" surchargée et une colonne "Négociation" vide indiquent un problème de conversion à mi-parcours.

#### 3.4.3. Nouvelle Opportunité

Le formulaire de création d'une opportunité permet de définir les paramètres d'une nouvelle affaire commerciale. Il peut être initié manuellement depuis la liste des opportunités, ou automatiquement via le bouton "Convertir en Opportunité" depuis une fiche contact.

Les champs clés sont :
- **Nom de l'opportunité** : Intitulé descriptif et identifiable de l'affaire.
- **Contact associé** : Lien vers la fiche du prospect ou client concerné.
- **Montant estimé** : Valeur financière potentielle de l'affaire, exprimée dans la devise de l'entreprise.
- **Probabilité de succès** : Estimation en pourcentage de la chance de conclure l'affaire, utilisée pour calculer le chiffre d'affaires prévisionnel pondéré.
- **Date de clôture prévue** : Échéance cible pour la conclusion de l'affaire.
- **Stade initial** : Positionnement de départ de l'affaire dans le tunnel de vente.

#### 3.4.4. Modifier une Opportunité

Permet d'actualiser les paramètres d'une affaire en cours : révision du montant suite à une négociation, ajustement de la probabilité, report de la date de clôture. Toute modification est tracée dans le journal d'audit.

#### 3.4.5. Détail d'une Opportunité

La vue détaillée d'une opportunité regroupe l'ensemble des informations de l'affaire, l'historique complet des transitions de stades avec les commentaires associés, et les tâches planifiées en lien avec cette affaire.

Les boutons d'action principaux sont :
- **"Marquer comme Gagnée"** : Clôture positivement l'affaire. Le montant de l'opportunité est comptabilisé dans le chiffre d'affaires réel affiché sur le tableau de bord.
- **"Marquer comme Perdue"** : Clôture négativement l'affaire. Un motif d'échec peut être renseigné pour alimenter l'analyse des performances et identifier les axes d'amélioration.

---

### 3.5. Module Agenda & Tâches

Le module Agenda & Tâches est le gestionnaire de productivité de la plateforme. Il permet aux utilisateurs de planifier, suivre et prioriser l'ensemble de leurs actions commerciales : relances téléphoniques, envois de propositions, réunions, suivis post-vente.

#### 3.5.1. Vue Liste des Tâches

La vue liste affiche l'ensemble des tâches et rappels sous forme de tableau, triées par date d'échéance et par niveau de priorité. Chaque tâche est associée à un contact ou une opportunité pour maintenir le contexte métier.

Un code couleur visuel permet d'identifier immédiatement les tâches urgentes (rouge), en cours (orange) et planifiées (vert). Une case à cocher permet de marquer une tâche comme terminée, la retirant de la file d'attente active.

#### 3.5.2. Vue Agenda (Calendrier)

La vue agenda présente les tâches sous forme de calendrier mensuel. Chaque tâche apparaît sur le jour correspondant à son échéance, avec un code couleur selon sa priorité. Cette vue permet une planification visuelle de l'activité et une identification rapide des journées surchargées.

Un clic sur une tâche affiche ses détails dans une fenêtre contextuelle. Un clic sur un jour vide ouvre directement le formulaire de création d'une nouvelle tâche avec la date pré-remplie.

#### 3.5.3. Nouvelle Tâche

Le formulaire de création d'une tâche permet de définir une action à effectuer et de la planifier dans le temps. Les champs disponibles sont :
- **Titre** : Description concise et actionnable de la tâche.
- **Type** : Catégorie de l'action (Appel téléphonique, Email, Réunion, Envoi de document, Autre).
- **Priorité** : Niveau d'urgence de la tâche (Haute, Moyenne, Faible).
- **Date d'échéance** : Date limite pour l'exécution de la tâche.
- **Contact ou Opportunité associé(e)** : Lien contextuel vers l'entité concernée, permettant de retrouver facilement le contexte de la tâche.
- **Notes** : Description détaillée, instructions complémentaires ou informations de contexte.

---

### 3.6. Module Utilisateurs & Accès

*Ce module est exclusivement accessible aux utilisateurs ayant le rôle Administrateur.*

#### 3.6.1. Gestion des Utilisateurs

Cet écran liste l'ensemble des comptes utilisateurs enregistrés sur la plateforme, avec pour chaque compte : le nom complet, l'adresse e-mail, le rôle attribué et le statut du compte (Actif ou Inactif).

L'administrateur dispose des actions suivantes :
- **Créer un nouvel utilisateur** : Ouvre un formulaire permettant de créer manuellement un compte, en définissant le nom, l'email, le rôle et un mot de passe temporaire. Cette option est utilisée pour les créations directes, sans passer par le processus de demande d'accès.
- **Modifier un utilisateur** : Permet de changer le rôle d'un utilisateur, de mettre à jour ses informations ou de modifier son statut.
- **Réinitialiser le mot de passe** : Génère un nouveau mot de passe temporaire et l'envoie automatiquement à l'utilisateur par e-mail. L'utilisateur sera invité à le changer lors de sa prochaine connexion.
- **Désactiver un compte** : Bloque l'accès d'un utilisateur à la plateforme sans supprimer son historique ni ses données. Cette option est préférable à la suppression définitive pour conserver la traçabilité des actions passées.

#### 3.6.2. Demandes d'Accès

Cet écran liste toutes les demandes d'accès soumises via la page publique de demande d'accès. Pour chaque demande, l'administrateur voit le nom du demandeur, son adresse e-mail, son poste et la date de soumission.

L'administrateur peut :
- **Approuver la demande** : Crée automatiquement le compte utilisateur avec le rôle par défaut et envoie les identifiants de connexion au demandeur par e-mail.
- **Rejeter la demande** : Refuse l'accès et notifie le demandeur de la décision.

---

### 3.7. Journal d'Audit

*Ce module est exclusivement accessible aux utilisateurs ayant le rôle Administrateur.*

#### 3.7.1. Journal d'Audit

Le journal d'audit est le registre de traçabilité de la plateforme. Il enregistre automatiquement et de manière exhaustive chaque action critique effectuée dans le système : création, modification ou suppression d'un contact, d'une opportunité ou d'un utilisateur ; changement de stade d'une opportunité ; connexion et déconnexion d'un utilisateur.

Pour chaque entrée du journal, les informations suivantes sont disponibles :
- **L'auteur de l'action** : Nom et identifiant de l'utilisateur qui a effectué l'action.
- **La nature de l'action** : Type d'opération réalisée (Création, Modification, Suppression, Connexion).
- **L'entité concernée** : L'objet sur lequel l'action a porté (nom du contact, intitulé de l'opportunité).
- **L'horodatage précis** : Date et heure exactes de l'action.

Ce journal remplit trois fonctions essentielles :
- **Sécurité** : Il permet de détecter et d'investiguer toute modification non autorisée ou suspecte.
- **Responsabilité** : Il attribue chaque action à un utilisateur identifié, renforçant la responsabilisation des équipes.
- **Conformité réglementaire** : Il répond aux exigences de traçabilité des données personnelles imposées par le Règlement Général sur la Protection des Données (RGPD).

---

### 3.8. Profil Utilisateur

Chaque utilisateur peut accéder à son espace personnel en cliquant sur son avatar ou ses initiales, situés dans le coin supérieur droit de l'interface. Cet espace est organisé en trois sous-sections.

#### 3.8.1. Informations Personnelles

Permet à l'utilisateur de mettre à jour ses informations d'identité : prénom, nom, adresse e-mail et numéro de téléphone. L'utilisateur peut également télécharger une photo de profil (avatar) qui sera affichée dans l'interface et dans les journaux d'activité.

#### 3.8.2. Sécurité

Interface dédiée à la gestion du mot de passe. Pour modifier son mot de passe, l'utilisateur doit saisir son mot de passe actuel (mesure de sécurité pour prévenir les modifications non autorisées), puis saisir et confirmer le nouveau mot de passe. Le système vérifie que le nouveau mot de passe respecte les critères de complexité définis par l'administrateur.

#### 3.8.3. Activité Système

Historique personnel des actions effectuées par l'utilisateur dans le système. Contrairement au journal d'audit global (réservé aux administrateurs), cette vue est filtrée et ne présente que les actions de l'utilisateur connecté. Elle lui permet de consulter ses dernières connexions et les dernières modifications qu'il a apportées.

---

### 3.9. Paramètres du Système

*Ce module est exclusivement accessible aux utilisateurs ayant le rôle Administrateur.*

#### 3.9.1. Paramètres Généraux

Permet de configurer l'identité institutionnelle de la plateforme. Les paramètres disponibles incluent le nom de l'entreprise (affiché dans la barre de navigation et les documents exportés), le logo de l'entreprise et les coordonnées de contact de l'organisation. Ces informations sont propagées automatiquement sur l'ensemble de l'interface.

#### 3.9.2. Notifications

Permet à l'administrateur de configurer les règles d'envoi des alertes automatiques du système. Il peut définir quels événements déclenchent une notification (nouvelle demande d'accès, création d'un contact, tâche en retard) et à qui cette notification est envoyée (administrateur, commercial assigné, tous les utilisateurs).

#### 3.9.3. Export & Rapports

Permet de générer des documents de synthèse à partir des données de la plateforme, pour une utilisation en dehors du CRM (réunions de direction, présentations clients, analyses externes).

Deux formats sont disponibles :
- **CSV (Comma-Separated Values)** : Format tableur compatible avec Microsoft Excel et Google Sheets. Idéal pour des analyses personnalisées et des croisements de données.
- **PDF (Portable Document Format)** : Document formaté, prêt à l'impression et à la diffusion. Adapté aux présentations et aux rapports de direction.

Les types de rapports disponibles incluent : rapport des contacts, rapport du pipeline commercial, rapport des performances par commercial et rapport des tickets de support.

#### 3.9.4. Maintenance

Regroupe les fonctions techniques avancées pour assurer la pérennité et la sécurité des données de la plateforme.

- **Sauvegarde de la base de données (Backup)** : Génère et télécharge une archive complète de la base de données au format SQL. Cette opération doit être effectuée régulièrement pour prévenir toute perte de données en cas d'incident technique.
- **Nettoyage des journaux système** : Supprime les fichiers journaux techniques obsolètes pour libérer de l'espace disque sur le serveur.
- **Export RGPD** : Génère un fichier contenant l'ensemble des données personnelles associées à un utilisateur ou à un contact spécifique, conformément au droit à la portabilité des données imposé par le RGPD.

---

## Partie IV — Gouvernance et Gestion des Accès

### 4.1. Architecture des Rôles

La plateforme Nexus Pro repose sur une architecture de contrôle d'accès basée sur les rôles, communément désignée par l'acronyme **RBAC** (Role-Based Access Control). Ce modèle garantit que chaque utilisateur n'accède qu'aux fonctionnalités et aux données strictement nécessaires à l'exercice de ses fonctions, conformément au principe de moindre privilège.

Deux rôles principaux sont définis dans le système.

### 4.2. Rôle Administrateur

L'Administrateur est le gestionnaire de la plateforme. Il dispose d'un accès complet et sans restriction à l'ensemble des modules et des fonctionnalités. Il est responsable de la configuration du système, de la gestion des utilisateurs, de la surveillance de la sécurité et de la conformité réglementaire.

**Périmètre d'accès complet :**
- Tableau de bord avec vue consolidée de toute l'équipe
- Gestion complète des contacts (lecture, création, modification, suppression)
- Gestion complète des opportunités (lecture, création, modification, suppression)
- Gestion de l'agenda et des tâches
- Administration des utilisateurs (création, modification, désactivation)
- Validation des demandes d'accès
- Consultation du journal d'audit global
- Configuration des paramètres système
- Gestion des notifications
- Génération de tous les types de rapports
- Maintenance et sauvegarde de la base de données

### 4.3. Rôle Commercial

Le Commercial est l'utilisateur opérationnel de la plateforme. Son accès est ciblé sur les fonctionnalités nécessaires à la gestion de son activité commerciale quotidienne. Il n'a pas accès aux fonctions d'administration, de configuration et de surveillance du système.

**Périmètre d'accès :**
- Tableau de bord avec vue personnelle (ses propres données uniquement)
- Gestion des contacts (lecture, création, modification — suppression non autorisée)
- Gestion des opportunités (lecture, création, modification — suppression non autorisée)
- Gestion de l'agenda et des tâches
- Gestion de son propre profil utilisateur

**Accès non autorisés :**
- Module de gestion des utilisateurs
- Module de validation des demandes d'accès
- Journal d'audit global
- Paramètres du système
- Maintenance et sauvegarde

### 4.4. Tableau Comparatif des Droits d'Accès

| Fonctionnalité | Administrateur | Commercial |
| :--- | :---: | :---: |
| Tableau de bord — Vue globale équipe | ✅ | ❌ |
| Tableau de bord — Vue personnelle | ✅ | ✅ |
| Contacts — Lecture | ✅ | ✅ |
| Contacts — Création et Modification | ✅ | ✅ |
| Contacts — Suppression | ✅ | ❌ |
| Opportunités — Lecture | ✅ | ✅ |
| Opportunités — Création et Modification | ✅ | ✅ |
| Opportunités — Suppression | ✅ | ❌ |
| Agenda et Tâches | ✅ | ✅ |
| Profil Utilisateur personnel | ✅ | ✅ |
| Gestion des Utilisateurs | ✅ | ❌ |
| Validation des Demandes d'Accès | ✅ | ❌ |
| Journal d'Audit | ✅ | ❌ |
| Paramètres Généraux | ✅ | ❌ |
| Configuration des Notifications | ✅ | ❌ |
| Export et Rapports | ✅ | ❌ |
| Maintenance et Sauvegarde | ✅ | ❌ |

---

## Conclusion

La plateforme CRM Nexus Pro constitue un outil de gestion de la relation client complet, sécurisé et adapté aux besoins des équipes commerciales modernes. Son architecture modulaire permet une adoption progressive, en commençant par les fonctionnalités essentielles (gestion des contacts et du pipeline) avant d'exploiter les capacités avancées de reporting et d'administration.

La combinaison d'une interface intuitive, d'une accessibilité multi-support (ordinateur, tablette, smartphone) et d'un système de gouvernance rigoureux basé sur les rôles en fait une solution robuste pour centraliser la connaissance client, améliorer la productivité des équipes et fournir à la direction les indicateurs nécessaires à une prise de décision éclairée.

---

*Document de Référence — CRM Nexus Pro*
*Usage Interne — Confidentiel*
