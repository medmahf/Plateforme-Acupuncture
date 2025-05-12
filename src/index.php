<?php
require_once __DIR__ . '/vendor/autoload.php';

$user = $_ENV['DB_USER'];
$pass = $_ENV['DB_PASSWORD'];  
$db =  $_ENV['DB_DB'];
$HOST = $_ENV['DB_HOST'];
$dsn = "pgsql:host=$HOST;port=5432;dbname=$db;user=$user;password=$pass;";

try {
    $dbh = new PDO($dsn, $user, $pass);
} catch (PDOException $e) {
    die("Erreur de connexion (applicatif) : " . $e->getMessage());
}

// Récupération dynamique des types et méridiens pour le filtrage
$types = $dbh->query('SELECT DISTINCT type FROM patho ORDER BY type')->fetchAll(PDO::FETCH_COLUMN);
$mers = $dbh->query('SELECT DISTINCT mer FROM patho ORDER BY mer')->fetchAll(PDO::FETCH_COLUMN);

session_start();

use Twig\Loader\FilesystemLoader;
use Twig\Environment;

require_once __DIR__ . '/models/utilisateur.php';
require_once __DIR__ . '/controllers/authcontroller.php';

use App\Controllers\AuthController;
use App\Models\Utilisateur;

$loader = new FilesystemLoader('site');
$twig = new Environment($loader);

$authController = new AuthController($dbh, $twig);

// Routage authentification
if (isset($_GET['page'])) {
    switch ($_GET['page']) {
        case 'login':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $authController->connexion($_POST['username'], $_POST['password']);
            } else {
                $authController->afficherConnexion();
            }
            exit;
        case 'signup':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $authController->inscrire($_POST);
            } else {
                $authController->afficherInscription();
            }
            exit;
        case 'logout':
            $authController->deconnexion();
            exit;
        // ...autres routes...
    }
}

// Page d'accueil par défaut
if (!isset($_GET['page'])) {
    echo $twig->render('index.twig', [
        'succes_connexion' => $_SESSION['succes_connexion'] ?? null,
        'session' => $_SESSION
    ]);
    unset($_SESSION['succes_connexion']);
    exit;
}

// Gestion de la page info 
if (isset($_GET['page']) && $_GET['page'] === 'info' && isset($_GET['idp'])) {
    $idp = (int)$_GET['idp'];
    $sql = "SELECT 
                p.idp,
                s.desc AS sympt_desc, 
                p.type, 
                p.mer, 
                kw.name AS mot_cle, 
                p.desc AS desc_patho,
                meridien.nom AS nom_meridien,
                sp.aggr
            FROM symptpatho sp
            RIGHT JOIN symptome s ON sp.ids = s.ids
            LEFT JOIN patho p ON sp.idp = p.idp
            LEFT JOIN keysympt ks ON ks.ids = s.ids
            LEFT JOIN keywords kw ON ks.idk = kw.idk 
            LEFT JOIN meridien ON meridien.code = p.mer 
            WHERE p.idp = :idp";
    $stmt = $dbh->prepare($sql);
    $stmt->execute(['idp' => $idp]);
    $details = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($details && count($details) > 0) {
        $info = $details[0];
        $symptomes = [];
        $mots_cles = [];
        foreach ($details as $row) {
            if (!empty($row['sympt_desc'])) {
                $symptomes[] = $row['sympt_desc'];
            }
            if (!empty($row['mot_cle'])) {
                $mots_cles[] = $row['mot_cle'];
            }
        }
        echo $twig->render('info.twig', [
            'info' => $info,
            'symptomes' => array_unique($symptomes),
            'mots_cles' => array_unique($mots_cles),
            'session' => $_SESSION
        ]);
    } else {
        echo '<p>Pathologie non trouvée.</p>';
    }
    exit;
}

// Affichage de la liste des pathologies avec filtrage et pagination
if (isset($_GET['page']) && $_GET['page'] === 'patho') {
    $where = [];
    $params = [];
    if (!empty($_GET['type'])) {
        $where[] = 'type = :type';
        $params['type'] = $_GET['type'];
    }
    if (!empty($_GET['mer'])) {
        $where[] = 'mer = :mer';
        $params['mer'] = $_GET['mer'];
    }
    if (!empty($_GET['carac'])) {
        $where[] = 'LOWER(desc) LIKE :carac';
        $params['carac'] = '%' . strtolower($_GET['carac']) . '%';
    }
    // Pagination
    $page_num = max(1, (int)($_GET['page_num'] ?? 1));
    $per_page = 20;
    $offset = ($page_num - 1) * $per_page;
    // Compter le total pour la pagination
    $sql_count = 'SELECT COUNT(*) FROM patho';
    if ($where) {
        $sql_count .= ' WHERE ' . implode(' AND ', $where);
    }
    $stmt_count = $dbh->prepare($sql_count);
    $stmt_count->execute($params);
    $total = (int)$stmt_count->fetchColumn();
    $total_pages = max(1, ceil($total / $per_page));
    // Récupérer les pathologies paginées
    $sql = 'SELECT * FROM patho';
    if ($where) {
        $sql .= ' WHERE ' . implode(' AND ', $where);
    }
    $sql .= ' ORDER BY mer LIMIT :per_page OFFSET :offset';
    $stmt = $dbh->prepare($sql);
    foreach ($params as $k => $v) {
        $stmt->bindValue(":$k", $v);
    }
    $stmt->bindValue(':per_page', $per_page, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo $twig->render('patho.twig', [
        'data' => $data,
        'types' => $types,
        'mers' => $mers,
        'selected_type' => $_GET['type'] ?? '',
        'selected_mer' => $_GET['mer'] ?? '',
        'selected_carac' => $_GET['carac'] ?? '',
        'session' => $_SESSION,
        'page_num' => $page_num,
        'total_pages' => $total_pages
    ]);
    exit;
}

// Recherche par mot-clé (accessible uniquement aux utilisateurs connectés)
if (isset($_GET['page']) && $_GET['page'] === 'search') {
    if (empty($_SESSION['user_id'])) {
        header('Location: ../index.php?page=login');
        exit;
    }
    $motcle = trim($_GET['motcle'] ?? '');
    $data = [];
    if ($motcle !== '') {
        $sql = "SELECT DISTINCT p.* FROM patho p
                LEFT JOIN symptpatho sp ON sp.idp = p.idp
                LEFT JOIN symptome s ON sp.ids = s.ids
                WHERE LOWER(p.desc) LIKE :motcle OR LOWER(s.desc) LIKE :motcle
                ORDER BY p.mer LIMIT 50";
        $stmt = $dbh->prepare($sql);
        $stmt->execute(['motcle' => '%' . strtolower($motcle) . '%']);
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    echo $twig->render('patho.twig', [
        'data' => $data,
        'types' => $types,
        'mers' => $mers,
        'selected_type' => '',
        'selected_mer' => '',
        'selected_carac' => '',
        'search_mode' => true,
        'search_query' => $motcle,
        'session' => $_SESSION
    ]);
    exit;
}

// Gestion de la page contact
if (isset($_GET['page']) && $_GET['page'] === 'contact') {
    echo $twig->render('contact.twig', [
        'session' => $_SESSION
    ]);
    exit;
}

?>