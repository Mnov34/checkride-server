<?php
session_start();
include 'config.php';

// Vérifier si un jeton CSRF est défini pour la session, sinon en générer un nouveau
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Fonction pour ajouter une nouvelle moto
function addMotorcycle($brand, $model, $cylinder, $prod_year, $plate): void
{
    global $conn;
    try {
        $stmt = $conn->prepare("INSERT INTO motorcycle (brand, model, cylinder, prod_year, plate, Id_checkride_user) VALUES (?, ?, ?, ?, ?, 1)");
        $stmt->execute([$brand, $model, $cylinder, $prod_year, $plate]);
        header('Location: bikestest.php?success=Motorcycle added successfully.');
        exit();
    } catch (Exception $e) {
        die("Error inserting motorcycle: " . $e->getMessage());
    }
}

// Gérer la requête POST en fonction de l'action
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Vérifier le jeton CSRF avant de traiter la requête
    if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        die('CSRF token mismatch');
    }

    $action = $_POST['action'];
    $id = $_POST['id'] ?? null;
    $brand = $_POST['motorcycle_brand'] ?? null;
    $model = $_POST['model'] ?? null;
    $cylinder = $_POST['cylinder'] ?? null;
    $prod_year = $_POST['prod_year'] ?? null;
    $plate = $_POST['plate'] ?? null;

    if ($action == 'insert') {
        if (empty($brand) || empty($model) || empty($cylinder) || empty($prod_year) || empty($plate)) {
            header('Location: bikestest.php?error=All fields are required.');
            exit();
        }
        addMotorcycle($brand, $model, $cylinder, $prod_year, $plate);
    } elseif ($action == 'update') {
        if (empty($id) || empty($brand) || empty($model) || empty($cylinder) || empty($prod_year) || empty($plate)) {
            header('Location: bikestest.php?error=All fields are required.');
            exit();
        }
        updateMotorcycle($id, $brand, $model, $cylinder, $prod_year, $plate);
    } elseif ($action == 'delete') {
        if (empty($id)) {
            header('Location: bikestest.php?error=ID is required.');
            exit();
        }
        deleteMotorcycle($id);
    } elseif ($action == 'edit') {
        if (empty($id)) {
            header('Location: bikestest.php?error=ID is required.');
            exit();
        }
        editMotorcycle($id);
    }
}
?>
