<?php
// Démarrer une session pour utiliser les variables de session
session_start();
// Inclure le fichier de configuration pour la connexion à la base de données
include 'config.php';

// Générer un nouveau jeton CSRF s'il n'est pas déjà défini dans la session
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Vérifier le jeton CSRF sur une requête POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Vérifier si le jeton CSRF est valide
    if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        die('Incompatibilité de jeton CSRF');
    }

    // Récupérer les données de l'entité et de l'action de la requête POST
    $entity = $_POST['entity'] ?? '';
    $action = $_POST['action'] ?? '';

    // Appeler la fonction appropriée en fonction de l'entité
    switch ($entity) {
        case 'motorcycle':
            handleMotorcycleAction($action);
            break;
        case 'maintenance':
            handleMaintenanceAction($action);
            break;
        default:
            echo "Entité non reconnue.";
            break;
    }
}

// Gérer les actions pour l'entité 'motorcycle'
function handleMotorcycleAction($action) {
    global $conn;
    switch ($action) {
        case 'insert':
            $brand = $_POST['motorcycle_brand'] ?? '';
            $model = $_POST['model'] ?? '';
            $cylinder = $_POST['cylinder'] ?? '';
            $prod_year = $_POST['prod_year'] ?? '';
            $plate = $_POST['plate'] ?? '';
            // Vérifier si tous les champs requis sont présents
            if ($brand && $model && $cylinder && $prod_year && $plate) {
                addMotorcycle($brand, $model, $cylinder, $prod_year, $plate);
            } else {
                echo "Tous les champs sont requis pour ajouter une moto.";
            }
            break;
        case 'update':
            $id = $_POST['id'] ?? null;
            $brand = $_POST['motorcycle_brand'] ?? '';
            $model = $_POST['model'] ?? '';
            $cylinder = $_POST['cylinder'] ?? '';
            $prod_year = $_POST['prod_year'] ?? '';
            $plate = $_POST['plate'] ?? '';
            // Vérifier si tous les champs requis sont présents pour la mise à jour
            if ($id && $brand && $model && $cylinder && $prod_year && $plate) {
                updateMotorcycle($id, $brand, $model, $cylinder, $prod_year, $plate);
            } else {
                echo "Tous les champs sont requis pour mettre à jour une moto.";
            }
            break;
        case 'delete':
            $id = $_POST['id'] ?? null;
            // Vérifier si l'ID de la moto est fourni pour la suppression
            if ($id) {
                deleteMotorcycle($id);
            } else {
                echo "L'ID de la moto est requis pour la suppression.";
            }
            break;
        default:
            echo "Action non reconnue pour les motos.";
            break;
    }
}

// Gérer les actions pour l'entité 'maintenance'
function handleMaintenanceAction($action) {
    global $conn;
    switch ($action) {
        case 'insert':
            $id_motorcycle = $_POST['id_motorcycle'] ?? '';
            $maintenance_kilometer = $_POST['maintenance_kilometer'] ?? '';
            $parts = $_POST['parts'] ?? '';
            $maintenance_date = $_POST['maintenance_date'] ?? '';
            // Vérifier si tous les champs requis sont présents
            if ($id_motorcycle && $maintenance_kilometer && $parts && $maintenance_date) {
                addMaintenance($id_motorcycle, $maintenance_kilometer, $parts, $maintenance_date);
            } else {
                echo "Tous les champs sont requis pour ajouter une maintenance.";
            }
            break;
        case 'update':
            $id = $_POST['id'] ?? null;
            $id_motorcycle = $_POST['id_motorcycle'] ?? '';
            $maintenance_kilometer = $_POST['maintenance_kilometer'] ?? '';
            $parts = $_POST['parts'] ?? '';
            $maintenance_date = $_POST['maintenance_date'] ?? '';
            // Vérifier si tous les champs requis sont présents pour la mise à jour
            if ($id && $id_motorcycle && $maintenance_kilometer && $parts && $maintenance_date) {
                updateMaintenance($id, $id_motorcycle, $maintenance_kilometer, $parts, $maintenance_date);
            } else {
                echo "Tous les champs sont requis pour mettre à jour une maintenance.";
            }
            break;
        case 'delete':
            $id = $_POST['id'] ?? null;
            // Vérifier si l'ID de la maintenance est fourni pour la suppression
            if ($id) {
                deleteMaintenance($id);
            } else {
                echo "L'ID de la maintenance est requis pour la suppression.";
            }
            break;
        default:
            echo "Action non reconnue pour les maintenances.";
            break;
    }
}

// Ajouter une nouvelle moto dans la base de données
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

// Mettre à jour une moto existante dans la base de données
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

// Supprimer une moto de la base de données
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

// Ajouter une nouvelle maintenance dans la base de données
function addMaintenance($id_motorcycle, $maintenance_kilometer, $parts, $maintenance_date): void {
    global $conn;
    try {
        $stmt = $conn->prepare("INSERT INTO maintenance (Id_motorcycle, maintenance_kilometer, parts, maintenance_date) VALUES (?, ?, ?, ?)");
        $stmt->execute([$id_motorcycle, $maintenance_kilometer, $parts, $maintenance_date]);
        header('Location: ./accueiltest.php?success=La maintenance a été ajoutée avec succès.');
        exit();
    } catch (Exception $e) {
        die("Erreur lors de l'insertion de la maintenance : " . $e->getMessage());
    }
}

// Mettre à jour une maintenance existante dans la base de données
function updateMaintenance($id, $id_motorcycle, $maintenance_kilometer, $parts, $maintenance_date): void {
    global $conn;
    try {
        $stmt = $conn->prepare("UPDATE maintenance SET Id_motorcycle = ?, maintenance_kilometer = ?, parts = ?, maintenance_date = ? WHERE Id_maintenance = ?");
        $stmt->execute([$id_motorcycle, $maintenance_kilometer, $parts, $maintenance_date, $id]);
        header('Location: ./accueiltest.php?success=Maintenance mise à jour.');
        exit();
    } catch (Exception $e) {
        die("Erreur lors de la mise à jour de la maintenance : " . $e->getMessage());
    }
}

// Supprimer une maintenance de la base de données
function deleteMaintenance($id): void {
    global $conn;
    try {
        $stmt = $conn->prepare("DELETE FROM maintenance WHERE Id_maintenance = ?");
        $stmt->execute([$id]);
        header('Location: ./accueiltest.php?success=Maintenance supprimée.');
        exit();
    } catch (Exception $e) {
        die("Erreur lors de la suppression de la maintenance : " . $e->getMessage());
    }
}
?>
