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

// Handling POST requests for creating, updating, or deleting motorcycles
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST['action'];
    switch ($action) {
        case "create":
            $brand = $_POST['brand'];
            $model = $_POST['model'];
            $cylinder = $_POST['cylinder'];
            $prod_year = $_POST['prod_year'];
            $plate = $_POST['plate'];
            $acquisition_date = $_POST['acquisition_date'];
            $Id_checkride_user = 1;  // Replace with actual user session or secure method

            $sql = "INSERT INTO motorcycle (brand, model, cylinder, prod_year, plate, acquisition_date, Id_checkride_user) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$brand, $model, $cylinder, $prod_year, $plate, $acquisition_date, $Id_checkride_user]);
            break;
        case "update":
            $Id_motorcycle = $_POST['Id_motorcycle'];
            $brand = $_POST['brand'];
            $model = $_POST['model'];
            $cylinder = $_POST['cylinder'];
            $prod_year = $_POST['prod_year'];
            $plate = $_POST['plate'];

            $sql = "UPDATE motorcycle SET brand=?, model=?, cylinder=?, prod_year=?, plate=? WHERE Id_motorcycle=?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$brand, $model, $cylinder, $prod_year, $plate, $Id_motorcycle]);
            break;
        case "delete":
            $Id_motorcycle = $_POST['Id_motorcycle'];
            $sql = "DELETE FROM motorcycle WHERE Id_motorcycle=?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$Id_motorcycle]);
            break;
    }
    // Optional: Redirect to prevent form resubmission issues
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Fetch the motorcycles to display
$Id_checkride_user = 1;  // Replace with actual user session or secure method
$sqlTable = "SELECT * FROM motorcycle WHERE Id_checkride_user = ?";
$stmtTable = $conn->prepare($sqlTable);
$stmtTable->execute([$Id_checkride_user]);

$tableRows = '';
if ($stmtTable->rowCount() > 0) {
    while ($row = $stmtTable->fetch(PDO::FETCH_ASSOC)) {
        $tableRows .= "<tr>
            <form method='post'>
                <td><input type='text' name='brand' value='{$row['brand']}'></td>
                <td><input type='text' name='model' value='{$row['model']}'></td>
                <td><input type='text' name='cylinder' value='{$row['cylinder']}'></td>
                <td><input type='date' name='prod_year' value='{$row['prod_year']}'></td>
                <td><input type='text' name='plate' value='{$row['plate']}'></td>
                <td>
                    <input type='hidden' name='action' value='update'>
                    <input type='hidden' name='Id_motorcycle' value='{$row['Id_motorcycle']}'>
                    <button type='submit'>Save</button>
                </td>
                <td>
                    <form method='post'>
                        <input type='hidden' name='action' value='delete'>
                        <input type='hidden' name='Id_motorcycle' value='{$row['Id_motorcycle']}'>
                        <button type='submit'>Delete</button>
                    </form>
                </td>
            </form>
        </tr>";
    }
} else {
    $tableRows .= "<tr><td colspan='7'>No results found</td></tr>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Motorcycle Management</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="shortcut icon" href="../img/faviconmoto.png" type="image/png">
</head>
<body>
<header>
    <nav>
        <a href="../checkride_home/accueiltest.php">Home</a>
        <a href="../bikes/bikestest.php">Bikes</a>
        <a href="#">Contact</a>
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
                    <input type="text" name="brand" placeholder="Brand" required>
                    <input type="text" name="model" placeholder="Model" required>
                    <input type="date" name="prod_year" placeholder="Year" required>
                    <input type="text" name="cylinder" placeholder="Cylinder" required>
                    <input type="date" name="acquisition_date" placeholder="Acquisition Year" required>
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
                <th>Save</th>
                <th>Delete</th>
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
