<?php
header('Content-Type: application/json');
require_once __DIR__ . '/vendor/autoload.php';

$user = $_ENV['DB_USER'];
$pass = $_ENV['DB_PASSWORD'];  
$db =  $_ENV['DB_DB'];
$HOST = $_ENV['DB_HOST'];
$dsn = "pgsql:host=$HOST;port=5432;dbname=$db;user=$user;password=$pass;";

try {
    $dbh = new PDO($dsn, $user, $pass);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Erreur de connexion à la base de données']);
    exit;
}

$ressource = $_GET['ressource'] ?? '';

if ($ressource === 'pathologies') {
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
    $sql = 'SELECT * FROM patho';
    if ($where) {
        $sql .= ' WHERE ' . implode(' AND ', $where);
    }
    $sql .= ' ORDER BY mer LIMIT 50';
    $stmt = $dbh->prepare($sql);
    $stmt->execute($params);
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($data);
    exit;
}

http_response_code(404);
echo json_encode(['error' => 'Ressource non trouvée']);
