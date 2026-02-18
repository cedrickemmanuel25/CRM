# Guide Utilisateur Officiel — CRM Nexus Pro
**Document de Référence Opérationnelle**
*Version Définitive — Tous Rôles Confondus*

---

## Table des Matières

1. Pages Publiques
2. Tableau de Bord
3. Module Contacts
4. Module Opportunités
5. Module Agenda & Tâches
6. Module Utilisateurs & Accès
7. Journal & Suivi
8. Profil Utilisateur
9. Paramètres du Système
10. Gestion des Rôles et des Accès

---

## 1. Pages Publiques

Les pages publiques sont accessibles à toute personne disposant de l'URL de l'application, sans nécessiter de connexion préalable.

### 1.1. Page d'Accueil

**Rôle :** Vitrine institutionnelle de la plateforme et point d'entrée principal.

**Description :** Cette page présente l'identité de l'entreprise, les fonctionnalités clés du CRM et les modalités d'accès. Elle constitue également le point de départ pour l'installation de l'application en mode PWA (Progressive Web App), permettant à l'utilisateur d'ajouter le CRM à son écran d'accueil comme une application native.

**Éléments interactifs :**
- **Bouton "Connexion"** : Redirige vers la page d'authentification.
- **Bouton "Télécharger / Installer l'App"** : Déclenche la procédure d'installation PWA selon la plateforme détectée (Android ou iOS). Sur Android, une fenêtre native du navigateur s'affiche. Sur iOS, un guide visuel explique la procédure via le menu "Partager" de Safari.

---

### 1.2. Page de Connexion

**Rôle :** Portail d'authentification sécurisé.

**Description :** L'utilisateur saisit ses identifiants (adresse e-mail et mot de passe) pour accéder à son espace de travail. Le système vérifie les informations d'identification, génère un jeton de session sécurisé et redirige l'utilisateur vers le tableau de bord correspondant à son rôle.

**Éléments interactifs :**
- **Champ "Adresse e-mail"** : Identifiant unique de l'utilisateur dans le système.
- **Champ "Mot de passe"** : Authentifiant confidentiel, masqué à la saisie.
- **Bouton "Se connecter"** : Soumet le formulaire et initie la vérification d'identité.
- **Lien "Demander un accès"** : Redirige les nouveaux utilisateurs vers le formulaire de demande d'accès.

**Note technique :** La session est maintenue active grâce à un mécanisme de "Heartbeat" (requête silencieuse toutes les 5 minutes). La durée de vie de la session est configurée à 10 ans, garantissant une continuité de service sans interruption.

---

### 1.3. Page de Demande d'Accès

**Rôle :** Formulaire d'inscription pour les nouveaux collaborateurs.

**Description :** Un utilisateur n'ayant pas encore de compte peut soumettre une demande d'accès. Cette demande est transmise à l'administrateur système, qui la valide ou la rejette depuis le module d'administration. L'accès à la plateforme reste bloqué jusqu'à la validation explicite par un administrateur.

**Éléments interactifs :**
- **Champs du formulaire** : Nom, prénom, adresse e-mail professionnelle, poste occupé.
- **Bouton "Soumettre ma demande"** : Enregistre la demande et notifie l'administrateur.

---

## 2. Tableau de Bord

### 2.1. Tableau de Bord Principal

**Rôle :** Centre de pilotage stratégique et opérationnel.

**Description :** Le tableau de bord est la première page affichée après la connexion. Il agrège en temps réel les données critiques de l'ensemble des modules pour offrir une vision synthétique de l'activité commerciale. Les données affichées sont filtrées selon le rôle de l'utilisateur connecté : un Administrateur voit les statistiques globales de toute l'équipe, tandis qu'un Commercial ne voit que ses propres données.

**Composants et leur utilité :**
- **Cartes KPI (Indicateurs Clés de Performance)** : Affichent des métriques essentielles telles que le nombre total de contacts actifs, la valeur totale du pipeline commercial, le nombre d'opportunités en cours et le nombre de tâches en retard.
- **Graphique "Sources d'Acquisition"** : Diagramme circulaire ou en barres indiquant la provenance des contacts (Web, Téléphone, Email, Référencement, etc.). Permet d'identifier les canaux d'acquisition les plus performants.
- **Graphique "Évolution du Pipeline"** : Courbe temporelle représentant la progression du chiffre d'affaires potentiel sur une période donnée.
- **Liste "Tâches Urgentes"** : Affiche les rappels et tâches dont l'échéance est imminente ou dépassée, permettant une réaction immédiate.

**Lien avec les autres modules :** Le tableau de bord est un agrégateur de données. Il ne permet pas de modifier les informations directement, mais chaque élément cliquable redirige vers le module source correspondant (ex : cliquer sur le nombre de contacts ouvre la liste des contacts).

---

## 3. Module Contacts

Le module Contacts est le référentiel central de toutes les personnes et entreprises avec lesquelles l'équipe commerciale interagit.

### 3.1. Liste des Contacts

**Rôle :** Répertoire centralisé et point d'entrée du module.

**Description :** Affiche l'ensemble des contacts enregistrés sous forme de tableau. Chaque ligne représente un contact avec ses informations essentielles (nom, entreprise, statut, commercial assigné, date de création).

**Éléments interactifs :**
- **Barre de recherche** : Filtre instantané sur le nom, le prénom ou l'entreprise. La liste se met à jour en temps réel à chaque frappe.
- **Filtres (Source, Statut, Commercial)** : Permettent de segmenter la liste selon des critères métier précis pour cibler une analyse.
- **Bouton "+ Nouveau Contact"** : Ouvre le formulaire de création d'un nouveau contact.
- **Icône "Voir"** (œil) : Ouvre la fiche détaillée du contact.
- **Icône "Modifier"** (crayon) : Ouvre le formulaire d'édition du contact.
- **Icône "Supprimer"** (corbeille) : Supprime définitivement le contact après confirmation. *Réservé aux Administrateurs.*

---

### 3.2. Nouveau Contact

**Rôle :** Formulaire de création et d'enregistrement d'un nouveau prospect ou client.

**Description :** Ce formulaire permet de saisir l'ensemble des informations qualifiantes d'un nouveau contact. Remplir ce formulaire avec précision est fondamental car ces données alimenteront les analyses du tableau de bord et le pipeline commercial.

**Champs du formulaire et leur utilité :**
- **Prénom / Nom** : Identité civile du contact.
- **Entreprise** : Organisation à laquelle le contact est rattaché.
- **Email / Téléphone** : Coordonnées directes pour les échanges.
- **Source** : Canal par lequel le contact a été acquis (ex : Salon professionnel, Site web, Recommandation). Donnée cruciale pour le reporting marketing.
- **Statut** : Qualification du contact (ex : Prospect, Client, Inactif).
- **Commercial assigné** : Membre de l'équipe responsable du suivi de ce contact.

**Boutons :**
- **"Enregistrer"** : Valide le formulaire et crée la fiche contact dans la base de données.
- **"Annuler"** : Abandonne la saisie et retourne à la liste des contacts.

---

### 3.3. Détail d'un Contact

**Rôle :** Vue exhaustive et historique complète de la relation avec un contact.

**Description :** C'est l'écran le plus riche du module. Il centralise toutes les informations et interactions liées à un contact spécifique, organisées en onglets thématiques pour faciliter la navigation.

**Onglets et leur contenu :**
- **Vue d'ensemble** : Récapitulatif des informations de base et des dernières activités.
- **Journal d'activité** : Historique chronologique de toutes les interactions (appels, emails, notes, réunions). Chaque entrée est horodatée et attribuée à un utilisateur.
- **Opportunités liées** : Liste des affaires commerciales associées à ce contact. Permet de voir d'un coup d'œil l'état de la relation commerciale.
- **Tâches & Rappels** : Actions planifiées en lien avec ce contact.

**Boutons d'action principaux :**
- **"Modifier"** : Accède au formulaire d'édition des informations du contact.
- **"Convertir en Opportunité"** : Action stratégique qui crée automatiquement une nouvelle opportunité commerciale pré-remplie avec les informations du contact, sans ressaisie.
- **"Ajouter une Note"** : Ouvre un champ de texte pour consigner un commentaire interne, une observation ou le compte-rendu d'un échange.
- **"Exporter"** : Génère une fiche PDF du contact pour une utilisation hors-ligne.

---

### 3.4. Modifier un Contact

**Rôle :** Mise à jour des informations d'un contact existant.

**Description :** Formulaire pré-rempli avec les données actuelles du contact. L'utilisateur peut modifier n'importe quel champ et enregistrer les changements. Toute modification est tracée dans le journal d'audit du système.

**Boutons :**
- **"Mettre à jour"** : Sauvegarde les modifications apportées.
- **"Annuler"** : Abandonne les modifications et retourne à la fiche détail.

---

## 4. Module Opportunités

Le module Opportunités gère le cycle de vie complet des affaires commerciales, de la prospection à la conclusion.

### 4.1. Liste des Opportunités

**Rôle :** Vue tabulaire de toutes les affaires en cours.

**Description :** Tableau récapitulatif listant chaque opportunité avec son nom, le contact associé, le montant estimé, la probabilité de succès, le stade actuel et la date de clôture prévue.

**Éléments interactifs :**
- **Filtres (Stade, Commercial, Période)** : Permettent de segmenter le portefeuille pour des analyses ciblées.
- **Bouton "+ Nouvelle Opportunité"** : Ouvre le formulaire de création.
- **Bouton "Vue Pipeline"** : Bascule vers la vue Kanban visuelle.

---

### 4.2. Vue Pipeline (Kanban)

**Rôle :** Représentation visuelle et interactive du tunnel de vente.

**Description :** Les opportunités sont organisées en colonnes correspondant aux stades du processus commercial (ex : Prospection → Qualification → Proposition → Négociation → Gagné/Perdu). Chaque opportunité est représentée par une "carte" contenant les informations clés.

**Manipulation :**
- **Glisser-Déposer (Drag & Drop)** : L'utilisateur fait glisser une carte d'une colonne à l'autre pour signifier la progression de l'affaire. Cette action déclenche automatiquement un formulaire de qualification pour documenter le changement de stade.
- **Clic sur une carte** : Ouvre la vue détaillée de l'opportunité.

---

### 4.3. Nouvelle Opportunité

**Rôle :** Création d'un nouveau dossier commercial.

**Description :** Formulaire permettant de définir les paramètres d'une nouvelle affaire. Il peut être créé manuellement ou automatiquement via le bouton "Convertir" depuis une fiche contact.

**Champs clés :**
- **Nom de l'opportunité** : Intitulé descriptif de l'affaire (ex : "Contrat Maintenance Annuel - Société X").
- **Contact associé** : Lien vers la fiche contact du prospect ou client concerné.
- **Montant estimé** : Valeur financière potentielle de l'affaire.
- **Probabilité de succès (%)** : Estimation subjective de la chance de conclure l'affaire.
- **Date de clôture prévue** : Échéance cible pour la conclusion.
- **Stade initial** : Positionnement de départ dans le tunnel de vente.

---

### 4.4. Modifier une Opportunité

**Rôle :** Mise à jour des paramètres d'une affaire en cours.

**Description :** Permet d'ajuster le montant, la probabilité, la date de clôture ou le stade d'une opportunité au fil de l'avancement des négociations.

---

### 4.5. Détail d'une Opportunité

**Rôle :** Dossier complet de l'affaire commerciale.

**Description :** Vue exhaustive regroupant toutes les informations de l'opportunité, l'historique des transitions de stades, les notes de négociation et les tâches associées.

**Boutons d'action :**
- **"Marquer comme Gagnée"** : Clôture positivement l'affaire. Le montant est comptabilisé dans le chiffre d'affaires réel du tableau de bord.
- **"Marquer comme Perdue"** : Clôture négativement l'affaire. Un motif d'échec peut être renseigné pour alimenter l'analyse des performances.
- **"Modifier"** : Accède au formulaire d'édition.

---

## 5. Module Agenda & Tâches

### 5.1. Agenda & Tâches (Vue Liste)

**Rôle :** Gestionnaire de productivité et de suivi des actions commerciales.

**Description :** Affiche l'ensemble des tâches et rappels sous forme de liste, triées par priorité et par date d'échéance. Chaque tâche est associée à un contact ou une opportunité pour maintenir le contexte métier.

**Éléments interactifs :**
- **Filtres (Priorité, Statut, Assigné à)** : Permettent de cibler les tâches urgentes ou en retard.
- **Case à cocher** : Marque une tâche comme "Terminée", la retirant de la file d'attente active.
- **Bouton "+ Nouvelle Tâche"** : Ouvre le formulaire de création.

---

### 5.2. Vue Agenda (Calendrier)

**Rôle :** Planification visuelle des activités sur une vue mensuelle.

**Description :** Représentation calendaire de toutes les tâches planifiées. Chaque tâche apparaît sur le jour correspondant à son échéance, avec un code couleur selon sa priorité.

**Navigation :**
- **Flèches "Mois précédent / Mois suivant"** : Naviguent dans le temps.
- **Clic sur une tâche** : Affiche le détail de la tâche dans une fenêtre contextuelle.
- **Clic sur un jour vide** : Ouvre le formulaire de création d'une nouvelle tâche avec la date pré-remplie.

---

### 5.3. Nouvelle Tâche

**Rôle :** Planification d'une action de suivi.

**Description :** Formulaire permettant de créer un rappel ou une action à effectuer, lié à un contact ou une opportunité spécifique.

**Champs clés :**
- **Titre** : Description concise de l'action (ex : "Relance téléphonique", "Envoi de devis").
- **Type** : Catégorie de la tâche (Appel, Email, Réunion, Autre).
- **Priorité** : Niveau d'urgence (Haute, Moyenne, Faible).
- **Date d'échéance** : Date limite pour l'exécution de la tâche.
- **Contact / Opportunité associé(e)** : Lien contextuel vers l'entité concernée.
- **Notes** : Description détaillée ou instructions complémentaires.

---

## 6. Module Utilisateurs & Accès

*Ce module est réservé aux utilisateurs ayant le rôle Administrateur.*

### 6.1. Utilisateurs

**Rôle :** Gestion centralisée des comptes utilisateurs de la plateforme.

**Description :** Tableau listant tous les utilisateurs enregistrés avec leur nom, email, rôle et statut (Actif/Inactif). L'administrateur peut créer, modifier ou désactiver des comptes depuis cet écran.

**Boutons d'action :**
- **"+ Nouvel Utilisateur"** : Ouvre un formulaire pour créer un compte manuellement, sans passer par la demande d'accès.
- **"Modifier"** (icône crayon) : Permet de changer le rôle, le nom ou l'email d'un utilisateur.
- **"Réinitialiser le mot de passe"** : Génère un nouveau mot de passe temporaire et l'envoie à l'utilisateur par email.
- **"Désactiver / Activer"** : Bloque ou restaure l'accès d'un utilisateur sans supprimer son historique.

---

### 6.2. Demandes d'Accès

**Rôle :** Validation des nouvelles inscriptions.

**Description :** Liste des demandes d'accès soumises via la page publique. L'administrateur examine chaque demande et prend une décision.

**Boutons d'action :**
- **"Approuver"** : Crée le compte utilisateur et envoie les identifiants de connexion par email.
- **"Rejeter"** : Refuse la demande et notifie le demandeur.

---

## 7. Journal & Suivi

### 7.1. Journal d'Audit

**Rôle :** Registre de traçabilité et outil de conformité.

**Description :** Le journal d'audit enregistre automatiquement chaque action critique effectuée dans le système : création, modification ou suppression d'un contact, d'une opportunité ou d'un utilisateur. Chaque entrée contient l'identité de l'auteur de l'action, la nature de l'action, l'entité concernée et l'horodatage précis.

**Utilité :**
- **Sécurité** : Permet de détecter toute modification non autorisée.
- **Responsabilité** : Attribue chaque action à un utilisateur identifié.
- **Conformité** : Répond aux exigences de traçabilité des données (RGPD).

**Éléments interactifs :**
- **Filtres (Utilisateur, Type d'action, Période)** : Permettent de retrouver rapidement un événement spécifique.
- **Barre de recherche** : Recherche par mot-clé dans les descriptions des actions.

*Accès réservé aux Administrateurs.*

---

## 8. Profil Utilisateur

### 8.1. Mon Profil

**Rôle :** Espace personnel de gestion du compte utilisateur.

**Description :** Chaque utilisateur accède à son profil en cliquant sur son avatar ou ses initiales dans le coin supérieur droit de l'interface. Cet espace est organisé en sous-sections.

---

### 8.2. Informations Personnelles

**Description :** Permet à l'utilisateur de mettre à jour ses informations d'identité.

**Champs modifiables :**
- **Prénom / Nom**
- **Adresse e-mail**
- **Numéro de téléphone**
- **Photo de profil (Avatar)**

**Bouton :**
- **"Enregistrer les modifications"** : Sauvegarde les changements.

---

### 8.3. Sécurité

**Description :** Interface dédiée à la gestion du mot de passe.

**Procédure de changement de mot de passe :**
1. Saisir le mot de passe actuel.
2. Saisir le nouveau mot de passe.
3. Confirmer le nouveau mot de passe.
4. Cliquer sur **"Mettre à jour le mot de passe"**.

---

### 8.4. Activité Système

**Description :** Historique personnel des actions effectuées par l'utilisateur dans le système. Permet à chaque collaborateur de consulter ses propres connexions récentes et les dernières modifications qu'il a apportées.

---

## 9. Paramètres du Système

*Ce module est réservé aux utilisateurs ayant le rôle Administrateur.*

### 9.1. Paramètres Généraux

**Rôle :** Configuration de l'identité de la plateforme.

**Description :** Permet de personnaliser l'apparence et les informations institutionnelles du CRM.

**Paramètres disponibles :**
- **Nom de l'entreprise** : Affiché dans la barre latérale et les en-têtes.
- **Logo de l'entreprise** : Image affichée dans la navigation et les documents exportés.
- **Coordonnées de contact** : Informations de référence de l'organisation.

---

### 9.2. Notifications

**Rôle :** Configuration des alertes automatiques du système.

**Description :** Permet à l'administrateur de définir quels événements déclenchent une notification et à qui elle est envoyée.

**Exemples de règles configurables :**
- Notifier l'administrateur lors de chaque nouvelle demande d'accès.
- Notifier le commercial assigné lors de la création d'un nouveau contact.
- Envoyer un rappel par email pour les tâches dont l'échéance approche.

---

### 9.3. Export & Rapports

**Rôle :** Extraction des données pour une analyse externe.

**Description :** Permet de générer des documents de synthèse à partir des données du CRM.

**Formats disponibles :**
- **CSV** : Fichier tableur compatible avec Microsoft Excel et Google Sheets, idéal pour des analyses personnalisées.
- **PDF** : Document formaté prêt à l'impression, adapté aux présentations et rapports de direction.

**Types de rapports :**
- Rapport des contacts
- Rapport du pipeline commercial
- Rapport des performances par commercial

---

### 9.4. Maintenance

**Rôle :** Outils de santé et de protection du système.

**Description :** Regroupe les fonctions techniques avancées pour assurer la pérennité et la sécurité des données.

**Fonctionnalités :**
- **Sauvegarde (Backup)** : Génère et télécharge une archive complète de la base de données. À effectuer régulièrement pour prévenir toute perte de données.
- **Nettoyage des logs** : Supprime les fichiers journaux obsolètes pour libérer de l'espace disque.
- **Export RGPD** : Génère un fichier contenant l'ensemble des données personnelles d'un utilisateur ou d'un contact, conformément aux obligations légales du Règlement Général sur la Protection des Données.

---

## 10. Gestion des Rôles et des Accès

Le CRM Nexus Pro repose sur une architecture de contrôle d'accès basée sur les rôles (RBAC). Deux rôles principaux sont définis, chacun avec des périmètres d'action distincts.

### 10.1. Rôle Administrateur

L'Administrateur dispose d'un accès complet et sans restriction à l'ensemble de la plateforme. Il est responsable de la configuration, de la sécurité et de la gouvernance du système.

**Pages et fonctionnalités accessibles :**
- Tableau de bord (vue globale de toute l'équipe)
- Module Contacts (lecture, création, modification, suppression)
- Module Opportunités (lecture, création, modification, suppression)
- Module Agenda & Tâches (lecture, création, modification, suppression)
- **Module Utilisateurs** (création, modification, désactivation de comptes)
- **Demandes d'Accès** (validation et rejet)
- **Journal d'Audit** (consultation complète)
- **Paramètres du Système** (configuration générale, notifications, maintenance)
- **Export & Rapports** (génération de tous les types de rapports)

---

### 10.2. Rôle Commercial

Le Commercial dispose d'un accès ciblé sur les fonctionnalités opérationnelles nécessaires à son activité quotidienne. Il n'a pas accès aux fonctions d'administration et de configuration du système.

**Pages et fonctionnalités accessibles :**
- Tableau de bord (vue personnelle de ses propres données uniquement)
- Module Contacts (lecture, création, modification — pas de suppression)
- Module Opportunités (lecture, création, modification — pas de suppression)
- Module Agenda & Tâches (lecture, création, modification, suppression de ses propres tâches)
- Profil Utilisateur (gestion de ses propres informations)

**Pages et fonctionnalités non accessibles :**
- Module Utilisateurs & Accès
- Journal d'Audit global
- Paramètres du Système
- Maintenance & Sauvegarde

---

### 10.3. Tableau Comparatif des Droits d'Accès

| Fonctionnalité | Administrateur | Commercial |
| :--- | :---: | :---: |
| Dashboard (vue globale équipe) | ✅ | ❌ |
| Dashboard (vue personnelle) | ✅ | ✅ |
| Contacts — Lecture | ✅ | ✅ |
| Contacts — Création & Modification | ✅ | ✅ |
| Contacts — Suppression | ✅ | ❌ |
| Opportunités — Lecture | ✅ | ✅ |
| Opportunités — Création & Modification | ✅ | ✅ |
| Opportunités — Suppression | ✅ | ❌ |
| Agenda & Tâches | ✅ | ✅ |
| Gestion des Utilisateurs | ✅ | ❌ |
| Validation des Demandes d'Accès | ✅ | ❌ |
| Journal d'Audit | ✅ | ❌ |
| Paramètres Généraux | ✅ | ❌ |
| Notifications Système | ✅ | ❌ |
| Export & Rapports | ✅ | ❌ |
| Maintenance & Sauvegarde | ✅ | ❌ |

---

*Guide Utilisateur Officiel — CRM Nexus Pro. Document de référence à usage interne.*
