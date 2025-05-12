# Projet TIDAL - Plateforme pour l'Association des Acupuncteurs

## Auteurs
**Module TIDAL - CPE Lyon**

- Projet réalisé par : Agustin Alvarez Bianco Luciano, Ahmed Sidi Mohamed Mahfoud, Belbachir Yassine, Martin Maxence.


## Description

Ce projet a été réalisé dans le cadre du module Techniques de l’Internet Dynamique et Architecture Logicielle (TIDAL). Il s'agit d'une application web permettant aux acupuncteurs de consulter et rechercher des pathologies et leurs symptômes.

Le projet respecte les contraintes de l'énoncé, notamment :
- Utilisation exclusive de PHP natif (pas de frameworks).
- Templating avec Twig.
- Base de données PostgreSQL fournie.
- Respect des normes d’accessibilité (niveau AAA).

## Fonctionnalités principales

- **Consultation** de la liste des pathologies.
- **Affichage détaillé** d’une pathologie avec ses symptômes associés.
- **Filtrage** des pathologies par méridien, type et caractéristiques.
- **Recherche** de pathologies par mot-clé (réservée aux utilisateurs connectés).
- **Connexion utilisateur** (système de sessions PHP).
- **Consommation d'une API REST** pour certaines données.

## Notes sur l'installation
Créer **manuellement** la table `utilisateurs` (non fournie par script) pour gérer les comptes. 
```sql
CREATE TABLE IF NOT EXISTS utilisateurs (
    id SERIAL PRIMARY KEY,
    username VARCHAR(255) NOT NULL UNIQUE,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    date_inscription TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    dernier_acces TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    etat VARCHAR(50) DEFAULT 'actif'
);
```

## Utilisation

- Accueil : connexion ou accès à la liste des pathologies.
- Navigation par filtres ou recherche par symptôme.
- Connexion obligatoire pour la recherche avancée.

## Organisation du code

- `/index.php` : point d'entrée principal (gestion des routes et des actions).
- `/site/` : templates Twig pour la génération des vues et pages    + css
- `/src/` : fichiers PHP de logique (connexion à la base, traitement des données).

## Limitations et améliorations possibles

- **MVC** : Le projet pourrait être amélioré en décomposant `index.php` en suivant rigoureusement le principe MVC (Model-View-Controller) afin de mieux séparer la logique, les vues et le contrôleur.

- **Base de données utilisateurs** : La création manuelle de la table `utilisateurs` est nécessaire actuellement, ce qui n'est pas optimal. Un script d'installation automatique pourrait être ajouté pour améliorer l’expérience d'installation.

## Remerciements et Répartition
L'equipe des Diapazouzes tient a chaleuresement remercier Ahmed Sidi Mohamed Mahfoud et son brave PC portable, qui nous ont apportés soutient, tant moral que pratique, tout au long de ce projet.

### Répartition 

Le travail à été globalement équilibré, avec une répartition comme suit: 

Mohamed : 30%
Augustin : 23.3333333%
Yassine : 23.3333333%
Maxence : 23.3333333%
