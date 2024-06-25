<?php
// Connexion à la base de données
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

// Gestion des requêtes POST pour créer une moto
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST['action'];
    if ($action == "create") {
        $brand = $_POST['brand'];
        $model = $_POST['model'];
        $cylinder = $_POST['cylinder'];
        $prod_year = $_POST['prod_year'];
        $plate = $_POST['plate'];
        $acquisition_date = $_POST['acquisition_date'];
        $Id_checkride_user = 3;  // Ce devrait être récupéré de manière sécurisée ou de la session utilisateur

        $sql = "INSERT INTO motorcycle (brand, model, cylinder, prod_year, plate, acquisition_date, Id_checkride_user) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$brand, $model, $cylinder, $prod_year, $plate, $acquisition_date, $Id_checkride_user]);
    }
}

// Affichage des motos de l'utilisateur connecté
$Id_checkride_user = 3;  // Supposons que vous avez obtenu l'ID de l'utilisateur de manière sécurisée

$sqlTable = "SELECT * FROM motorcycle WHERE Id_checkride_user = ?";
$stmtTable = $conn->prepare($sqlTable);
$stmtTable->execute([$Id_checkride_user]);

$tableRows = '';
if ($stmtTable->rowCount() > 0) {
    while ($row = $stmtTable->fetch(PDO::FETCH_ASSOC)) {
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
    <title>Motorcycle Management</title>
    <link rel="stylesheet" href="../css/styleChekride.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link rel="shortcut icon" href="../img/faviconmoto.png" type="image/png">
</head>
<body>
<header>
    <nav>
        <a href="accueil.php">Home</a>
        <a href="../bikes/bikes.php">Bikes</a>
        <a href="../bikes/contact.php">Contact</a>
        <span></span>
    </nav>
</header>
<div class="main-container">
    <div class="form-container">
        <form method="post">
            <input type="hidden" name="action" value="create">
            <h2 class="section_title">Add a Motorcycle</h2>
            <ul>
                <li>

                    <label>
                        <input type="text" name="brand" placeholder="Brand" required>
                        <input type="text" name="model" placeholder="Model" required>
                        <input type="date" name="prod_year" placeholder="Year" required>
                    </label>
                    <label>
                        <input type="text" name="cylinder" placeholder="Cylinder" required>
                        <input type="date" name="acquisition_date" placeholder="Acquisition Year" required>
                        <input type="text" name="plate" placeholder="Plate" required>
                    </label>
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
