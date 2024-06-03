<?php

// Database connection setup
$host = 'localhost';
$dbname = 'checkride';
$user = 'root';
$password = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

try {
    $conn = new PDO($dsn, $user, $password, $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}
// Initialize variables
$Id_motorcycle = $_GET['Id_motorcycle'] ?? ''; // Using GET for initial load, POST for form submissions

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $Id_motorcycle = $_POST['Id_motorcycle'];
    // Fetch the existing details first
    $sql = "SELECT * FROM motorcycle WHERE Id_motorcycle = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$Id_motorcycle]);
    $motorcycle = $stmt->fetch(PDO::FETCH_ASSOC);

    // Prepare an array to store the updated data
    $updateData = [
        'brand' => $_POST['brand'] ?? $motorcycle['brand'],
        'model' => $_POST['model'] ?? $motorcycle['model'],
        'cylinder' => $_POST['cylinder'] ?? $motorcycle['cylinder'],
        'prod_year' => $_POST['prod_year'] ?? $motorcycle['prod_year'],
        'plate' => $_POST['plate'] ?? $motorcycle['plate'],
    ];

    // Update statement
    $sqlUpdate = "UPDATE motorcycle SET brand=?, model=?, cylinder=?, prod_year=?, plate=? WHERE Id_motorcycle=?";
    $stmtUpdate = $conn->prepare($sqlUpdate);
    if ($stmtUpdate->execute([
        $updateData['brand'],
        $updateData['model'],
        $updateData['cylinder'],
        $updateData['prod_year'],
        $updateData['plate'],
        $Id_motorcycle
    ])) {
        // Redirect back to the bikes page after update
        header("Location: bikes.php");
        exit;
    } else {
        echo "Failed to update motorcycle.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Motorcycle</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="shortcut icon" href="../img/faviconmoto.png" type="image/png">
</head>
<body>
<h1>Edit Motorcycle</h1>
<form action="../bikes/edit_bike.php" method="post">
    <input type="hidden" name="Id_motorcycle" value="<?php echo htmlspecialchars($Id_motorcycle); ?>">
    <label for="brand">Brand:</label>
    <input type="text" id="brand" name="brand" value="<?php echo htmlspecialchars($motorcycle['brand'] ?? ''); ?>" required><br>
    <label for="model">Model:</label>
    <input type="text" id="model" name="model" value="<?php echo htmlspecialchars($motorcycle['model'] ?? ''); ?>" required><br>
    <label for="cylinder">Cylinder:</label>
    <input type="text" id="cylinder" name="cylinder" value="<?php echo htmlspecialchars($motorcycle['cylinder'] ?? ''); ?>" required><br>
    <label for="prod_year">Production Year:</label>
    <input type="date" id="prod_year" name="prod_year" value="<?php echo htmlspecialchars($motorcycle['prod_year'] ?? ''); ?>" required><br>
    <label for="plate">Plate:</label>
    <input type="text" id="plate" name="plate" value="<?php echo htmlspecialchars($motorcycle['plate'] ?? ''); ?>" required><br>
    <button type="submit">Update Motorcycle</button>
</form>
</body>
</html>

