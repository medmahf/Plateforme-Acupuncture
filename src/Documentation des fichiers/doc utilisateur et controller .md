# Documentation : Modèle Utilisateur et Contrôleur d'Authentification (MVC)

## Contexte

Cette documentation décrit le fonctionnement du système d’authentification de l’application, basé sur le modèle MVC (Modèle-Vue-Contrôleur). Elle détaille le rôle du modèle `utilisateur.php` et du contrôleur `authcontroller.php`, ainsi que leurs interactions et les bonnes pratiques de sécurité mises en œuvre.

---

## utilisateur.php (Modèle)

Ce fichier définit la classe `Utilisateur` qui :

- Stocke les données d’un utilisateur : id, nom d’utilisateur, email, mot de passe, etc.
- Fournit des méthodes d’accès (getters)
- Implémente des méthodes statiques pour interagir avec la base de données :
  - `obtenirParUsername($username, $pdo)` : Recherche un utilisateur par son nom d’utilisateur
  - `inscrire($donnees, $pdo)` : Crée un nouvel utilisateur (avec vérification des doublons)
  - `mettreAJourDernierAcces($userId, $pdo)` : Met à jour la date de la dernière connexion

**Exemple de structure** :
```php
class Utilisateur {
    // ... propriétés ...
    public static function obtenirParUsername($username, $pdo) { /* ... */ }
    public static function inscrire($donnees, $pdo) { /* ... */ }
    public static function mettreAJourDernierAcces($userId, $pdo) { /* ... */ }
    // ... autres méthodes ...
}
```

---

## authcontroller.php (Contrôleur)

Ce contrôleur gère tout le processus d’authentification :

- Affiche les formulaires de connexion et d’inscription
- Traite l’envoi de ces formulaires
- Établit la session utilisateur lors d’une connexion réussie
- Termine la session lors d’une déconnexion
- Gère les messages d’erreur et de succès

**Exemple de structure** :
```php
class AuthController {
    public function connexion($username, $password) { /* ... */ }
    public function inscrire($donnees) { /* ... */ }
    public function deconnexion() { /* ... */ }
    public function afficherConnexion() { /* ... */ }
    public function afficherInscription() { /* ... */ }
    // ...
}
```

---

## Interaction Modèle/Contrôleur

- Lorsqu’un utilisateur tente de se connecter, le contrôleur `AuthController` reçoit les données du formulaire.
- Il utilise le modèle `Utilisateur` pour vérifier les identifiants.
- Si la connexion réussit, il initialise la session et redirige l’utilisateur.
- Sinon, il affiche un message d’erreur.
- Pour l’inscription, le contrôleur valide les données, utilise le modèle pour créer l’utilisateur, puis gère la réponse.

---

## Fonctionnalités de sécurité implémentées

- Stockage sécurisé des mots de passe avec `password_hash` et `password_verify`
- Validation des doublons de noms d’utilisateur
- Gestion des erreurs et des messages de retour
- Mise à jour de la date de dernière connexion pour le suivi

---

## Bonnes pratiques
- Respect strict du modèle MVC (aucune logique métier dans les vues)
- Utilisation de requêtes préparées pour toutes les interactions avec la base de données
- Jamais de mot de passe en clair
- Validation et échappement des entrées utilisateur
- Gestion centralisée des messages d’erreur/succès

---

## Résumé
- Le modèle `utilisateur.php` gère toutes les opérations liées aux utilisateurs et à la base de données.
- Le contrôleur `authcontroller.php` orchestre l’authentification et la gestion de session.
- L’ensemble garantit sécurité, maintenabilité et séparation des responsabilités.
