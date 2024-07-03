<?php
require('session_manager.php');
require_login();

global $conn;
require('config.php');

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION["username"])) {
    header("Location: ./bikes/login.php");
    exit();
}

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=maintenance_data.csv');

$output = fopen('php://output', 'w');
if ($output === false) {
    die('Impossible d\'ouvrir le flux de sortie');
}

$delimiter = ',';

fputcsv($output, ['#', 'Brand', 'Model', 'Plate', 'Maintenance Kilometer', 'Parts', 'Maintenance Date'], $delimiter);

$sql = "
    SELECT 
        m.Id_motorcycle, m.brand, m.model, m.plate, 
        mt.maintenance_kilometer, mt.parts, mt.maintenance_date
    FROM motorcycle m
    INNER JOIN maintenance mt ON m.Id_motorcycle = mt.Id_motorcycle
";
$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die('Erreur de préparation de la requête SQL');
}

$stmt->execute();
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
if ($data === false) {
    die('Erreur lors de la récupération des données');
}

foreach ($data as $row) {
    fputcsv($output, $row, $delimiter);
}

fclose($output);

exit();

