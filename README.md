
# Projet Laravel : Arbre Généalogique Collaboratif - Test de Stage Développeur Full-Stack






## Introduction

Ce projet a été réalisé dans le cadre d'un test technique pour un stage de développeur full-stack. Il s'agit d'une application web développée avec Laravel, visant à créer et gérer un arbre généalogique de manière collaborative. L'objectif est de permettre à plusieurs utilisateurs de construire et maintenir un arbre généalogique en assurant l'intégrité des données grâce à un système de propositions et de validations par la communauté.

Ce README détaille la structure du projet, en mettant l'accent sur la conception de la base de données et le processus d'évolution des données pour les propositions et validations de modifications.
## PARTIE 3 : Diagramme de la Base de Données avec dbdiagram.io![Untitled](https://github.com/user-attachments/assets/3316e9bb-ddc5-46a5-b39d-6638b716cead)


La structure de la base de données a été conçue avec dbdiagram.io pour visualiser clairement les tables et leurs relations.


### Description Générale
Le script dbdiagram.io pour la structure de base de données de notre système de généalogie collaborative comprend les tables suivantes :

    users : Stocke les informations des utilisateurs du site.

    people : Contient les fiches des personnes dans l'arbre généalogique.

    relationships : Définit les relations familiales entre les personnes.

    invitations : Gère les invitations envoyées aux membres de la famille.

    modification_proposals : Enregistre les propositions de modifications ou d'ajouts.

    proposal_validations : Suit les validations ou refus des propositions par les utilisateurs.

Lien pour visualiser : https://dbdiagram.io/d/67b0b2c5263d6cf9a044a666


### Évolution des données pour les cas "Propositions de Modifications" et "Validation des Modifications"


Cette section décrit comment les données évoluent (insertions, mises à jour) au fil des cas "Propositions de Modifications" et "Validation des Modifications" pour montrer que la structure répond bien au problème posé par le test de stage.
Cas : Proposition d'ajout d'une relation parent-enfant

Supposons que l'utilisateur rose03 (ID: 3) propose d'ajouter une relation parent-enfant entre sa fiche Rose PERRET (ID: 5) et Jean PERRET (ID: 1).

#### 1.Création de la proposition

Une nouvelle entrée est ajoutée dans la table `modification_proposals`:


```sql
INSERT INTO modification_proposals
(proposer_id, type, person_id, new_value, status, created_at, updated_at)
VALUES
(3, 'relationship', 5, '{"parent_id": 1, "child_id": 5}', 'pending', NOW(), NOW());
```


#### 2. Processus de validation
Lorsque les utilisateurs valident ou refusent la proposition, des entrées sont ajoutées dans `proposal_validations` :


```sql
-- Jean (ID: 1) accepte
INSERT INTO proposal_validations (proposal_id, user_id, vote, created_at, updated_at)
VALUES (1, 1, 'accept', NOW(), NOW());

-- Marie (ID: 2) accepte
INSERT INTO proposal_validations (proposal_id, user_id, vote, created_at, updated_at)
VALUES (1, 2, 'accept', NOW(), NOW());

-- Paul (ID: 4) refuse
INSERT INTO proposal_validations (proposal_id, user_id, vote, created_at, updated_at)
VALUES (1, 4, 'reject', NOW(), NOW());

-- Marc (ID: 5) accepte, atteignant le seuil de validation
INSERT INTO proposal_validations (proposal_id, user_id, vote, created_at, updated_at)
VALUES (1, 5, 'accept', NOW(), NOW());
```

Une fois le seuil de 3 acceptations atteint, la proposition est validée :

```sql
-- Mise à jour du statut de la proposition
UPDATE modification_proposals
SET status = 'accepted', updated_at = NOW()
WHERE id = 1;

-- Ajout de la nouvelle relation dans la table relationships
INSERT INTO relationships (created_by, parent_id, child_id, created_at, updated_at)
VALUES (3, 1, 5, NOW(), NOW());
```


### Cas : Proposition de modification d'une information personnelle

Imaginons que Marie (ID: 2) propose de modifier la date de naissance de Jean (ID: 1).

#### 1.Création de la proposition
```sql
INSERT INTO modification_proposals
(proposer_id, type, person_id, field, old_value, new_value, status, created_at, updated_at)
VALUES
(2, 'person', 1, 'date_of_birth', '1950-01-01', '1951-01-01', 'pending', NOW(), NOW());
```



#### 2.Processus de validation

Similaire au cas précédent, les utilisateurs votent sur la proposition.

#### 3.Validation de la proposition

Une fois validée :

```sql
-- Mise à jour du statut de la proposition
UPDATE modification_proposals
SET status = 'accepted', updated_at = NOW()
WHERE id = 2;

-- Mise à jour de l'information dans la table people
UPDATE people
SET date_of_birth = '1951-01-01', updated_at = NOW()
WHERE id = 1;
```


Cette approche garantit que toutes les modifications sont soumises à l'approbation de la communauté avant d'être appliquées, préservant ainsi l'intégrité des données généalogiques tout en permettant des contributions collaboratives.
