# Documentation du fichier index.php

## Rôle

`index.php` est le point d’entrée unique (contrôleur frontal) de l’application. Il orchestre le routage des différentes pages, initialise la connexion à la base de données, gère la session utilisateur, et transmet les données aux templates Twig.

## Fonctionnalités principales

- Initialise la connexion PDO à PostgreSQL
- Démarre la session PHP
- Instancie Twig pour le rendu des vues
- Gère le routage des pages via le paramètre `page` (accueil, patho, info, login, signup, logout, search)
- Passe les variables de session et les données dynamiques aux templates
- Applique les contrôles d’accès (ex : recherche par mot-clé accessible uniquement aux utilisateurs connectés)
- Sécurise les accès et les redirections

## Structure du routage

- `page=patho` : Affiche la liste des pathologies, avec filtrage dynamique
- `page=info&idp=...` : Affiche le détail d’une pathologie
- `page=login` : Affiche ou traite le formulaire de connexion
- `page=signup` : Affiche ou traite le formulaire d’inscription
- `page=logout` : Déconnecte l’utilisateur
- `page=search` : Recherche par mot-clé (utilisateur connecté uniquement)
- (aucun paramètre) : Affiche la page d’accueil

## Sécurité

- Utilise des requêtes préparées pour toutes les interactions avec la BDD
- Ne transmet jamais d’informations sensibles dans l’URL
- Gère les droits d’accès aux fonctionnalités sensibles (connexion requise pour la recherche avancée)

## Points d’extension

- Ajout de nouvelles routes/pages dynamiques
- Ajout de contrôles d’accès supplémentaires (ex : rôles, statuts)
- Intégration de pagination, d’API, etc.

## Bonnes pratiques

- Centralise toute la logique de routage et de sécurité
- Facilite la maintenance et l’extension de l’application
