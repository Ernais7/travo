# 🏗️ Travo - Module de Décisions & Workflow (Architecture MVC)

Ce dépôt contient l'extension de l'application de suivi de chantiers **Travo**, réalisée dans le cadre du TP sur l'architecture MVC. 

L'objectif de ce projet a été de concevoir et d'implémenter un véritable **workflow métier sécurisé et historisé** pour la gestion des décisions sur un chantier, en allant bien au-delà d'un simple CRUD.

## 🚀 Fonctionnalités Principales

* **Machine à États (Workflow) :** Implémentation stricte du cycle de vie d'une décision (`draft` ➔ `pending` ➔ `approved` / `rejected` / `cancelled`). Les transitions illogiques sont physiquement bloquées.
* **Traçabilité totale (Logs) :** Chaque changement de statut déclenche une écriture automatique dans un journal d'historique (`decision_logs`) garantissant que l'action et sa trace sont indissociables.
* **Sécurité Métier (Backend) :** * Verrouillage des décisions finalisées : une décision `approved` ou `cancelled` ne peut plus être modifiée ni changer de statut.
  * Validation des droits : un utilisateur ne peut agir que sur les décisions des chantiers dont il est le propriétaire.
  * Protection contre la suppression physique en cours de validation.
* **Interface Dynamique :** Les actions (boutons) proposées à l'utilisateur s'adaptent conditionnellement au statut courant de la décision.

## 🛠️ Stack Technique

* **Langage :** PHP 8+ (Orienté Objet)
* **Base de données :** MySQL (Base interfacée avec PDO)
* **Architecture :** MVC (Modèle - Vue - Contrôleur) personnalisé et sans framework externe.

## 📂 Organisation du code source ajouté

* `app/Controllers/DecisionController.php` : Cerveau du module, gestion des droits, lecture des requêtes (`$_POST`) et redirection.
* `app/Models/Decision.php` : Logique métier, requêtes préparées PDO, transactions SQL et "guards" interdisant les opérations illégales.
* `app/Views/decisions/` : Vues d'affichage dynamique (création, liste, détails, timeline de l'historique).
* `database/schema.sql` : Schéma complet de la base de données incluant les nouvelles tables métier.

## ⚙️ Installation & Lancement

1. Cloner le dépôt.
2. Importer le fichier `database/schema.sql` dans votre SGBD (ex: phpMyAdmin) pour recréer la base de données avec les tables `decisions` et `decision_logs`.
3. Configurer les variables d'environnement dans le fichier d'entrée si nécessaire (identifiants DB).
4. Lancer l'application via un serveur local (MAMP, XAMPP, etc.).
