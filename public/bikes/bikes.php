<?php
$host = 'localhost'; // ou localhost
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

// Handle CRUD operations
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST['action'];
    if ($action == "create") {
        $brand = $_POST['brand'];
        $model = $_POST['model'];
        $cylinder = $_POST['cylinder'];
        $prod_year = $_POST['prod_year'];
        $plate = $_POST['plate'];
        $acquisition_date = $_POST['acquisition_date'];
        $Id_checkride_user = 1; // Ajustez cette valeur selon votre logique

        // Utilisation des requêtes préparées pour une meilleure sécurité
        $sql = "INSERT INTO motorcycle (brand, model, cylinder, prod_year, plate, acquisition_date, Id_checkride_user) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$brand, $model, $cylinder, $prod_year, $plate, $acquisition_date, $Id_checkride_user]);
    }
}

// Requête SQL pour récupérer les données pour le tableau
$sqlTable = "SELECT * FROM motorcycle";
$stmt = $conn->prepare($sqlTable);
$stmt->execute();
$resultTable = $stmt->fetchAll();

$tableRows = '';
if (count($resultTable) > 0) {
    foreach ($resultTable as $row) {
        $tableRows .= "<tr>
                    <td>{$row['brand']}</td>
                    <td>{$row['model']}</td>
                    <td>{$row['cylinder']}</td>
                    <td>{$row['prod_year']}</td>
                    <td>{$row['plate']}</td>
                  </tr>";
    }
} else {
    $tableRows .= "<tr><td colspan='5'>No results found</td></tr>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Motorcycle</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="shortcut icon" href="../img/faviconmoto.png" type="image/png">
</head>
<body>
<header>
    <nav>
        <a href="../checkride_home/accueil.php">Home</a>
        <a href="../bikes/bikes.php">Bikes</a>
        <a href="../contact/contact.php">Contact</a>
        <span></span>
    </nav>
</header>

<div class="main-container">
        <div class="form-container">
            <form method="post">
                <input type="hidden" name="action" value="create">
                <h2 class="section__tittle">Add a Motorcycle</h2>
                <ul>
                    <li>
                        <input type="text" name="brand" placeholder="Brand" required>
                        <input type="text" name="model" placeholder="Model" required>
                        <input type="date" name="prod_year" placeholder="Year" required>
                    </li>
                    <li>
                        <input type="text" name="cylinder" placeholder="Cylinder" required>
                        <input type="date" name="acquisition_date" placeholder="Year" required>
                        <input type="text" name="plate" placeholder="Plate" required>
                    </li>
                </ul>

                <button type="submit">Add</button>
            </form>
        </div>

    <div class="container">
            <table>
                <thead>
                <tr>
                    <th>Brand</th>
                    <th>Model</th>
                    <th>Cylinder</th>
                    <th>Year</th>
                    <th>Plate</th>
                </tr>
                </thead>
                <tbody>
                <?php echo $tableRows; ?>
                </tbody>
            </table>
    </div>
</div>
</body>
</html>
