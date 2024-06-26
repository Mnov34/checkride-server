<?php
include 'config.php';

// Fonction pour ajouter une nouvelle maintenance
function addMaintenance($maintenance_kilometer, $parts, $bills, $maintenance_date, $Id_motorcycle): void
{
    global $conn;
    try {
        $stmt = $conn->prepare("INSERT INTO maintenance (maintenance_kilometer, parts, bills, maintenance_date, Id_motorcycle) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$maintenance_kilometer, $parts, $bills, $maintenance_date, $Id_motorcycle]);
        header('Location: index.php?success=Maintenance added successfully.');
        exit();
    } catch (Exception $e) {
        die("Error inserting maintenance: " . $e->getMessage());
    }
}

// Fonction pour mettre à jour une maintenance existante
function updateMaintenance($id, $maintenance_kilometer, $parts, $bills, $maintenance_date, $Id_motorcycle): void
{
    global $conn;
    try {
        $stmt = $conn->prepare("UPDATE maintenance SET maintenance_kilometer=?, parts=?, bills=?, maintenance_date=?, Id_motorcycle=? WHERE Id_maintenance=?");
        $stmt->execute([$maintenance_kilometer, $parts, $bills, $maintenance_date, $Id_motorcycle, $id]);
        header('Location: index.php?success=Maintenance updated successfully.');
        exit();
    } catch (Exception $e) {
        die("Error updating maintenance: " . $e->getMessage());
    }
}

// Fonction pour supprimer une maintenance
function deleteMaintenance($id): void
{
    global $conn;
    try {
        $stmt = $conn->prepare("DELETE FROM maintenance WHERE Id_maintenance=?");
        $stmt->execute([$id]);
        header('Location: index.php?success=Maintenance deleted successfully.');
        exit();
    } catch (Exception $e) {
        die("Error deleting maintenance: " . $e->getMessage());
    }
}

// Fonction pour récupérer les données d'une maintenance pour l'édition
function editMaintenance($id): void
{
    global $conn;
    try {
        $stmt = $conn->prepare("SELECT * FROM maintenance WHERE Id_maintenance=?");
        $stmt->execute([$id]);
        $maintenance = $stmt->fetch(PDO::FETCH_ASSOC);
        header('Location: index.php?edit=' . urlencode(json_encode($maintenance)));
        exit();
    } catch (Exception $e) {
        die("Error fetching maintenance: " . $e->getMessage());
    }
}

// Gérer la requête POST en fonction de l'action
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'];
    $id = $_POST['id'] ?? null;
    $maintenance_kilometer = $_POST['maintenance_kilometer'] ?? null;
    $parts = $_POST['parts'] ?? null;
    $bills = $_POST['bills'] ?? null;
    $maintenance_date = $_POST['maintenance_date'] ?? null;
    $Id_motorcycle = $_POST['Id_motorcycle'] ?? null;

    if ($action == 'insert') {
        if (empty($maintenance_kilometer) || empty($parts) || empty($bills) || empty($maintenance_date) || empty($Id_motorcycle)) {
            header('Location: index.php?error=All fields are required.');
            exit();
        }
        addMaintenance($maintenance_kilometer, $parts, $bills, $maintenance_date, $Id_motorcycle);
    } elseif ($action == 'update') {
        if (empty($id) || empty($maintenance_kilometer) || empty($parts) || empty($bills) || empty($maintenance_date) || empty($Id_motorcycle)) {
            header('Location: index.php?error=All fields are required.');
            exit();
        }
        updateMaintenance($id, $maintenance_kilometer, $parts, $bills, $maintenance_date, $Id_motorcycle);
    } elseif ($action == 'delete') {
        if (empty($id)) {
            header('Location: index.php?error=ID is required.');
            exit();
        }
        deleteMaintenance($id);
    } elseif ($action == 'edit') {
        if (empty($id)) {
            header('Location: index.php?error=ID is required.');
            exit();
        }
        editMaintenance($id);
    }
}
