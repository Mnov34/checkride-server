<?php
require('session_manager.php');
require_login();
require('config.php');

global $conn;

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION["username"])) {
    header("Location: ./bikes/login.php");
    exit();
}

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=bikes_data.csv');

$output = fopen('php://output', 'w');
if ($output === false) {
    die('Impossible d\'ouvrir le flux de sortie');
}

$delimiter = ',';

// Headers matching the columns in bikestest.php
fputcsv($output, ['#', 'Brand', 'Model', 'Cylinder', 'Year', 'Plate'], $delimiter);

$sql = "
    SELECT 
        Id_motorcycle, brand, model, cylinder, prod_year, plate
    FROM motorcycle
";

try {
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($data === false) {
        throw new Exception('Erreur lors de la récupération des données');
    }

    foreach ($data as $row) {
        $row = array_map(function($value) {
            return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
        }, $row);
        fputcsv($output, $row, $delimiter);
    }
} catch (Exception $e) {
    die('Erreur: ' . $e->getMessage());
}

fclose($output);
exit();
?>
