<?php
//include "config/db_conn.php";

// Configuration de la connexion à la base de données
$host = 'localhost'; // ou localhost
$dbname = 'checkride';
$user = 'root';
$password = '';
$charset = 'utf8mb4';

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

$dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";
try {
    $pdo = new PDO($dsn, $user, $password, $options);
} catch (PDOException $e) {
    throw new PDOException($e->getMessage(), (int)$e->getCode());
}

$action = $_POST['action'] ?? '';

// Gestion des actions
switch ($action) {
    case 'fetchMotorcycles':
        fetchMotorcycles($pdo);
        break;
    case 'insertMotorcycle':
        insertMotorcycle($pdo, $_POST);
        break;
    case 'getMotorcycleDetails':
        getMotorcycleDetails($pdo, $_POST['id']);
        break;
    case 'updateMotorcycle':
        updateMotorcycle($pdo, $_POST);
        break;
    case 'deleteMotorcycle':
        deleteMotorcycle($pdo, $_POST['id']);
        break;
    default:
        echo "Action not recognized.";
}

// Fonctions pour gérer les requêtes SQL
function fetchMotorcycles($pdo): void
{
    $stmt = $pdo->query("SELECT * FROM motorcycle");
    $motorcycles = $stmt->fetchAll();
    echo json_encode(['data' => $motorcycles]);
}

function insertMotorcycle($pdo, $data): void
{
    $sql = "INSERT INTO motorcycle (brand, model, cylinder, prod_year, plate, acquisition_date, Id_checkride_user) VALUES (:brand, :model, :cylinder, :prod_year, :plate, :acquisition_date, :Id_checkride_user)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':brand' => $data['brand'],
        ':model' => $data['model'],
        ':cylinder' => $data['cylinder'],
        ':prod_year' => $data['prod_year'],
        ':plate' => $data['plate'],
        ':acquisition_date' => $data['acquisition_date'],
        ':Id_checkride_user' => $data['Id_checkride_user'] // Assurez-vous que cette valeur est transmise dans $_POST
    ]);
    echo json_encode(['statusCode' => 200]);
}


function getMotorcycleDetails($pdo, $id): void
{
    $sql = "SELECT * FROM motorcycle WHERE Id_motorcycle = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $id]);
    $motorcycle = $stmt->fetch();
    echo json_encode(['data' => $motorcycle]);
}

function updateMotorcycle($pdo, $data): void
{
    $sql = "UPDATE motorcycle SET brand = :brand, model = :model, cylinder = :cylinder, prod_year = :prod_year, plate = :plate, acquisition_date = :acquisition_date WHERE Id_motorcycle = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':brand' => $data['brand'],
        ':model' => $data['model'],
        ':cylinder' => $data['cylinder'],
        ':prod_year' => $data['prod_year'],
        ':plate' => $data['plate'],
        ':acquisition_date' => $data['acquisition_date'],
        ':id' => $data['Id_motorcycle']
    ]);
    echo json_encode(['statusCode' => 200]);
}

function deleteMotorcycle($pdo, $id): void
{
    $sql = "DELETE FROM motorcycle WHERE Id_motorcycle = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $id]);
    echo json_encode(['statusCode' => 200]);
}
