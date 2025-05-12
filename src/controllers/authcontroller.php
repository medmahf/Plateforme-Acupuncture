<?php
namespace App\Controllers;

use App\Models\Utilisateur;

class AuthController {
    private $pdo;
    private $twig;
    
    public function __construct($pdo, $twig) {
        $this->pdo = $pdo;
        $this->twig = $twig;
    }
    
    public function afficherConnexion() {
        echo $this->twig->render('login.twig', [
            'erreur' => $_SESSION['erreur_connexion'] ?? null,
            'succes' => $_SESSION['succes_connexion'] ?? null
        ]);
        unset($_SESSION['erreur_connexion'], $_SESSION['succes_connexion']);
    }
    
    public function connexion($username, $password) {
        // Vérifier les identifiants
        $utilisateur = Utilisateur::obtenirParUsername($username, $this->pdo);
        if (!$utilisateur || !password_verify($password, $utilisateur->getPassword())) {
            $_SESSION['erreur_connexion'] = 'Nom d\'utilisateur ou mot de passe incorrect';
            header('Location: ../index.php?page=login');
            exit;
        }
        // Démarrer la session
        $_SESSION['user_id'] = $utilisateur->getId();
        $_SESSION['username'] = $utilisateur->getUsername();
        // Mettre à jour le dernier accès
        Utilisateur::mettreAJourDernierAcces($utilisateur->getId(), $this->pdo);
        // Ajouter un message de succès
        $_SESSION['succes_connexion'] = 'Connexion réussie, bienvenue ' . htmlspecialchars($utilisateur->getUsername()) . ' !';
        // Rediriger vers la page d'accueil (aucune info dans l'URL)
        header('Location: ../index.php');
        exit;
    }
    
    public function afficherInscription() {
        echo $this->twig->render('signup.twig', [
            'erreur' => $_SESSION['erreur_inscription'] ?? null,
            'succes' => $_SESSION['succes_inscription'] ?? null
        ]);
        unset($_SESSION['erreur_inscription'], $_SESSION['succes_inscription']);
    }
    
    public function inscrire($donnees) {
        // Valider les données
        if (empty($donnees['username']) || empty($donnees['password']) || empty($donnees['email'])) {
            $_SESSION['erreur_inscription'] = 'Tous les champs sont obligatoires';
            header('Location: ../index.php?page=signup');
            exit;
        }
        
        // Inscrire l'utilisateur
        $resultat = Utilisateur::inscrire($donnees, $this->pdo);
        
        if ($resultat['success']) {
            $_SESSION['succes_inscription'] = $resultat['message'];
            header('Location: ../index.php?page=login');
        } else {
            $_SESSION['erreur_inscription'] = $resultat['message'];
            header('Location: ../index.php?page=signup');
        }
        exit;
    }
    
    public function deconnexion() {
        // Détruire la session
        session_destroy();
        header('Location: ../index.php');
        exit;
    }
    
    public function estConnecte() {
        return isset($_SESSION['user_id']);
    }
}