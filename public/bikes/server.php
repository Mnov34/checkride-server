<?php
include 'config.php';

// Fonction pour ajouter une nouvelle moto
function addMotorcycle($brand, $model, $cylinder, $prod_year, $plate): void
{
    global $conn;
    try {
        $stmt = $conn->prepare("INSERT INTO motorcycle (brand, model, cylinder, prod_year, plate, Id_checkride_user) VALUES (?, ?, ?, ?, ?, 1)");
        $stmt->execute([$brand, $model, $cylinder, $prod_year, $plate]);
        header('Location: index.php?success=Motorcycle added successfully.');
        exit();
    } catch (Exception $e) {
        die("Error inserting motorcycle: " . $e->getMessage());
    }
}

// Fonction pour mettre à jour une moto existante
function updateMotorcycle($id, $brand, $model, $cylinder, $prod_year, $plate): void
{
    global $conn;
    try {
        $stmt = $conn->prepare("UPDATE motorcycle SET brand=?, model=?, cylinder=?, prod_year=?, plate=? WHERE Id_motorcycle=?");
        $stmt->execute([$brand, $model, $cylinder, $prod_year, $plate, $id]);
        header('Location: index.php?success=Motorcycle updated successfully.');
        exit();
    } catch (Exception $e) {
        die("Error updating motorcycle: " . $e->getMessage());
    }
}

// Fonction pour supprimer une moto
function deleteMotorcycle($id): void
{
    global $conn;
    try {
        $stmt = $conn->prepare("DELETE FROM motorcycle WHERE Id_motorcycle=?");
        $stmt->execute([$id]);
        header('Location: index.php?success=Motorcycle deleted successfully.');
        exit();
    } catch (Exception $e) {
        die("Error deleting motorcycle: " . $e->getMessage());
    }
}

// Fonction pour récupérer les données d'une moto pour l'édition
function editMotorcycle($id): void
{
    global $conn;
    try {
        $stmt = $conn->prepare("SELECT * FROM motorcycle WHERE Id_motorcycle=?");
        $stmt->execute([$id]);
        $motorcycle = $stmt->fetch(PDO::FETCH_ASSOC);
        header('Location: index.php?edit=' . urlencode(json_encode($motorcycle)));
        exit();
    } catch (Exception $e) {
        die("Error fetching motorcycle: " . $e->getMessage());
    }
}

// Gérer la requête POST en fonction de l'action
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'];
    $id = $_POST['id'] ?? null;
    $brand = $_POST['motorcycle_brand'] ?? null;
    $model = $_POST['model'] ?? null;
    $cylinder = $_POST['cylinder'] ?? null;
    $prod_year = $_POST['prod_year'] ?? null;
    $plate = $_POST['plate'] ?? null;

    if ($action == 'insert') {
        if (empty($brand) || empty($model) || empty($cylinder) || empty($prod_year) || empty($plate)) {
            header('Location: index.php?error=All fields are required.');
            exit();
        }
        addMotorcycle($brand, $model, $cylinder, $prod_year, $plate);
    } elseif ($action == 'update') {
        if (empty($id) || empty($brand) || empty($model) || empty($cylinder) || empty($prod_year) || empty($plate)) {
            header('Location: index.php?error=All fields are required.');
            exit();
        }
        updateMotorcycle($id, $brand, $model, $cylinder, $prod_year, $plate);
    } elseif ($action == 'delete') {
        if (empty($id)) {
            header('Location: index.php?error=ID is required.');
            exit();
        }
        deleteMotorcycle($id);
    } elseif ($action == 'edit') {
        if (empty($id)) {
            header('Location: index.php?error=ID is required.');
            exit();
        }
        editMotorcycle($id);
    }
}
