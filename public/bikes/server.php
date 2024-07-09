<?php
session_start();
include 'config.php';

// Générer un nouveau jeton CSRF s'il n'est pas défini
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Vérifier le jeton CSRF sur une requête POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Vérifier le jeton CSRF
    if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        die('Incompatibilité de jeton CSRF');
    }

    $action = $_POST['action'] ?? '';
    switch ($action) {
        case 'insert':
            $brand = $_POST['motorcycle_brand'] ?? '';
            $model = $_POST['model'] ?? '';
            $cylinder = $_POST['cylinder'] ?? '';
            $prod_year = $_POST['prod_year'] ?? '';
            $plate = $_POST['plate'] ?? '';
            if ($brand && $model && $cylinder && $prod_year && $plate) {
                addMotorcycle($brand, $model, $cylinder, $prod_year, $plate);
            }
            break;
        case 'update':
            $id = $_POST['id'] ?? null;
            $brand = $_POST['motorcycle_brand'] ?? '';
            $model = $_POST['model'] ?? '';
            $cylinder = $_POST['cylinder'] ?? '';
            $prod_year = $_POST['prod_year'] ?? '';
            $plate = $_POST['plate'] ?? '';
            if ($id && $brand && $model && $cylinder && $prod_year && $plate) {
                updateMotorcycle($id, $brand, $model, $cylinder, $prod_year, $plate);
            }
            break;
        case 'delete':
            $id = $_POST['id'] ?? null;
            if ($id) {
                deleteMotorcycle($id);
            }
            break;
        default:
            echo "Action non reconnue";
            break;
    }
}

// Fonctions pour ajouter, mettre à jour et supprimer une moto
function addMotorcycle($brand, $model, $cylinder, $prod_year, $plate): void {
    global $conn;
    $userId = $_SESSION['user_id'];
    try {
        $stmt = $conn->prepare("INSERT INTO motorcycle (brand, model, cylinder, prod_year, plate, Id_checkride_user) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$brand, $model, $cylinder, $prod_year, $plate, $userId]);
        header('Location: ./bikestest.php?success=La moto a été ajoutée avec succès.');
        exit();
    } catch (Exception $e) {
        die("Erreur lors de l'insertion de la moto : " . $e->getMessage());
    }
}

function updateMotorcycle($id, $brand, $model, $cylinder, $prod_year, $plate): void {
    global $conn;
    try {
        $stmt = $conn->prepare("UPDATE motorcycle SET brand = ?, model = ?, cylinder = ?, prod_year = ?, plate = ? WHERE Id_motorcycle = ?");
        $stmt->execute([$brand, $model, $cylinder, $prod_year, $plate, $id]);
        header('Location: ./bikestest.php?success=Motorcycle updated successfully.');
        exit();
    } catch (Exception $e) {
        die("Error updating motorcycle: " . $e->getMessage());
    }
}

function deleteMotorcycle($id): void {
    global $conn;
    try {
        $stmt = $conn->prepare("DELETE FROM motorcycle WHERE Id_motorcycle = ?");
        $stmt->execute([$id]);
        header('Location: ./bikestest.php?success=Motorcycle deleted successfully.');
        exit();
    } catch (Exception $e) {
        die("Error deleting motorcycle: " . $e->getMessage());
    }
}
