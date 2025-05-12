<?php
namespace App\Models;

class Utilisateur {
    private $id;
    private $username;
    private $email;
    private $password;
    private $dateInscription;
    private $dernierAcces;
    private $etat;

    // Constructeur
    public function __construct($data = []) {
        $this->id = $data['id'] ?? null;
        $this->username = $data['username'] ?? '';
        $this->email = $data['email'] ?? '';
        $this->password = $data['password'] ?? '';
        $this->dateInscription = $data['date_inscription'] ?? null;
        $this->dernierAcces = $data['dernier_acces'] ?? null;
        $this->etat = $data['etat'] ?? 'actif';
    }

    // Getters
    public function getId() {
        return $this->id;
    }

    public function getUsername() {
        return $this->username;
    }

    public function getEmail() {
        return $this->email;
    }
    
    public function getPassword() {
        return $this->password;
    }

    public function getEtat() {
        return $this->etat;
    }

    // Méthodes pour le modèle
    public static function obtenirParUsername($username, $pdo) {
        $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE username = :username");
        $stmt->execute(['username' => $username]);
        $utilisateur = $stmt->fetch(\PDO::FETCH_ASSOC);
        
        if (!$utilisateur) {
            return null;
        }
        
        return new Utilisateur($utilisateur);
    }

    public static function inscrire($donnees, $pdo) {
        // Vérifier que le nom d'utilisateur n'existe pas déjà
        $checkStmt = $pdo->prepare("SELECT COUNT(*) FROM utilisateurs WHERE username = :username");
        $checkStmt->execute(['username' => $donnees['username']]);
        if ($checkStmt->fetchColumn() > 0) {
            return ['success' => false, 'message' => 'Le nom d\'utilisateur existe déjà'];
        }
        
        // Hachage du mot de passe
        $passwordHash = password_hash($donnees['password'], PASSWORD_DEFAULT);
        
        // Insérer le nouvel utilisateur
        $stmt = $pdo->prepare("
            INSERT INTO utilisateurs (username, email, password, date_inscription, dernier_acces, etat) 
            VALUES (:username, :email, :password, NOW(), NOW(), 'actif')
        ");
        
        $result = $stmt->execute([
            'username' => $donnees['username'],
            'email' => $donnees['email'],
            'password' => $passwordHash
        ]);
        
        if ($result) {
            return ['success' => true, 'message' => 'Utilisateur inscrit avec succès'];
        } else {
            return ['success' => false, 'message' => 'Erreur lors de l\'inscription de l\'utilisateur'];
        }
    }

    public static function mettreAJourDernierAcces($userId, $pdo) {
        $stmt = $pdo->prepare("UPDATE utilisateurs SET dernier_acces = NOW() WHERE id = :id");
        return $stmt->execute(['id' => $userId]);
    }
}