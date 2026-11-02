# Fonctionnalités, règles métier et parcours

## Modules

| Module | Fonctionnalités |
|---|---|
| Authentification et rôles | Connexion, limitation des tentatives, redirection vers le tableau de bord du rôle, demande d'accès publique validée par un administrateur. |
| Tableaux de bord | Vue administrateur (leads, CA prévisionnel, actions en attente, répartition par stade), vue commerciale (CA prévisionnel, conversion, quota, retards, rendez-vous), console support (tickets par statut et priorité). Rappel des tâches du jour et en retard. |
| Contacts et prospects | Recherche, filtres, tri ; création, modification, suppression ; fiche à onglets ; notes, activités, tâches ; export CSV ; conversion en opportunité. |
| Pipeline et opportunités | Kanban et liste ; total, valeur pondérée, conversion ; transitions d'étape par modales ; historique des stades. |
| Attribution des commerciaux | Manuelle ou par règles priorisées (source, montant, secteur, équilibrage de charge), historique, notification. |
| Tâches et calendrier | Kanban à faire / en cours / terminé ; agenda semaine et jour ; tâches liées à un contact ou une opportunité. |
| Support et tickets | Catégories, priorités, pièce jointe, assignation, réponses, statuts, rapports PDF par période. |
| Notifications | En base (cloche, liste, lecture, suppression) et par e-mail, selon des préférences globales et personnelles. |
| Rapports CSV / PDF | Exports filtrés par période et par commercial, page imprimable, journalisation. |
| Administration | Utilisateurs et rôles, demandes d'accès, paramètres, règles d'attribution, journal d'audit, sauvegarde, export RGPD. |

## Règles métier

| Domaine | Règle |
|---|---|
| Accès | Un commercial ne voit et ne modifie que ses contacts et ses opportunités ; il n'accède qu'aux tickets qu'il a créés ou qui concernent ses contacts. Le visiteur est en lecture seule. |
| Connexion | Au-delà de 5 tentatives échouées en une minute pour une même IP, la connexion est temporairement bloquée. |
| Pipeline | Six étapes : prospection, qualification, proposition, négociation, gagné, perdu ; chaque changement est historisé et journalisé. |
| Statut du contact | Il suit l'opportunité la plus avancée du contact (une affaire gagnée en fait un client). |
| Indicateurs | Valeur pondérée = montant × probabilité ; taux de conversion = gagnées / (gagnées + perdues). |
| Attribution | Seul l'administrateur choisit le commercial ou l'attribution automatique. En automatique, la première règle active correspondante (par priorité décroissante) s'applique ; à défaut, le commercial ayant le moins d'opportunités actives est choisi. |
| Opportunités | La date de clôture prévue doit être postérieure à la date du jour lors de la création. |
| Contacts | L'e-mail d'un contact est unique. |
| Tâches | Une tâche est en retard si son échéance est passée et qu'elle n'est pas terminée ; rappels et alertes quotidiens à 9 h. |
| Comptes | Une demande d'accès ne crée un compte qu'après approbation par un administrateur. |
| Traçabilité | Exports et actions sensibles sur les comptes sont inscrits au journal d'audit. |

## Parcours utilisateurs

**Commercial — faire avancer une affaire.** Tableau de bord personnel → pipeline → passage de
« qualification » à « proposition » via une modale (besoin, budget) → l'étape, les données et
l'historique sont enregistrés, la fiche du contact passe au statut « proposition ».

**Administrateur — répartir et superviser.** Création d'une opportunité en attribution automatique →
la règle correspondante désigne le commercial, qui est notifié → validation d'une demande d'accès →
consultation du journal d'audit → export PDF des opportunités.

**Agent support — traiter une demande.** Console support → création d'un ticket lié à un client →
priorisation et assignation → réponse → passage en « résolu ».

**Visiteur — consulter.** Tableau de bord, contacts, opportunités, agenda et rapports en lecture
seule ; toute tentative de modification est refusée (HTTP 403).
