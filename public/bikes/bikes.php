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
    <title>Motorcycle CRUD</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            display: flex;
            flex-direction: column; /* Organize content in a vertical layout */
            align-items: center; /* Center content horizontally */
            height: 100vh;
            margin: 0;
            padding-top: 50px;
            font-family: 'Poppins', sans-serif;
            background-image: url("../img/fondsite2.jpg");
            background-size: cover;
            background-repeat: no-repeat;
            background-position: right center;
            background-attachment: fixed;
            overflow: hidden;
        }

        header {
            width: 100%; /* Ensures the header spans the entire width */
            display: flex;
            justify-content: center; /* Center navigation bar horizontally */
            position: relative; /* Set to relative for layering context */
            z-index: 10; /* Higher z-index to ensure it's above other content */
        }

        nav {
            position: relative;
            width: 300px;
            height: 50px;
            background: #222;
            border-radius: 8px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        nav a {
            position: relative;
            display: inline-block;
            font-size: 1em;
            font-weight: 500;
            color: #fff;
            text-decoration: none;
            padding: 0 23px;
            transition: .5s;
            z-index: 1;
        }

        nav span {
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            background: linear-gradient(45deg, #191d4a 0%, #2b5787 69%);
            border-radius: 8px;
            transition: .5s;
            z-index: 0;
        }

        nav a:nth-child(1):hover ~ span {
            width: 105px;
            left: 0;
        }

        nav a:nth-child(2):hover ~ span {
            width: 75px;
            left: 105px;
        }

        nav a:nth-child(3):hover ~ span {
            width: 120px;
            left: 180px;
        }

        .main-container {
            width: 100%;
            align-self: flex-start; /* Align container to the start of the main axis */
            padding-left: 40px; /* Add some padding for aesthetic */
            margin-top: auto; /* Pushes the container to the bottom */
            margin-bottom: 30px;
            margin-left: 150px;
        }

        .container {
            width: 900px;
            background: rgba(255, 255, 255, .3);
            padding: 2rem;
            margin-top: 50px;
            border-radius: 20px;
            backdrop-filter: blur(10px);
            box-shadow: 20px 20px 40px -6px rgba(0, 0, 0, .2);
            text-align: center;
            color: white;
        }

        .form-container {
            width: 900px;
            background: rgba(255, 255, 255, .3);
            padding: 2rem;
            margin-top: 50px;
            border-radius: 20px;
            backdrop-filter: blur(10px);
            box-shadow: 20px 20px 40px -6px rgba(0, 0, 0, .2);
            text-align: center;
            color: white;
        }

        .form-container h2 {
            margin-bottom: 20px;
        }

        .form-container input, .form-container button {
            display: block;
            width: calc(50% - 20px);
            margin: 10px auto;
            padding: 10px;
            background: rgba(255, 255, 255, 0.2);
            border: none;
            border-radius: 10px;
            color: white;
            text-align: center;
        }

        .form-container button {
            width: 100px;
            background: #00000080;
            cursor: pointer;
            transition: .3s;
        }

        .form-container button:hover {
            background: #ffffff40;
        }

        .table-container {
            background: rgba(255, 255, 255, 0.2);
            padding: 20px;
            border-radius: 20px;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            color: white;
            text-align: left;
        }

        th, td {
            padding: 10px;
        }

        th {
            background-color: rgba(0, 0, 0, 0.5);
        }

        tr:nth-child(even) {
            background-color: rgba(0, 0, 0, 0.1);
        }

        tr:nth-child(odd) {
            background-color: rgba(255, 255, 255, 0.1);
        }
    </style>
</head>
<body>
<header>
    <nav>
        <a href="#">Home</a>
        <a href="#">Bikes</a>
        <a href="#">Contact</a>
        <span></span>
    </nav>
</header>

<div class="main-container">
        <div class="form-container">
            <form method="post">
                <input type="hidden" name="action" value="create">
                <h2>Add a Motorcycle</h2>
                <input type="text" name="brand" placeholder="Brand" required>
                <input type="text" name="model" placeholder="Model" required>
                <input type="text" name="cylinder" placeholder="Cylinder" required>
                <input type="date" name="prod_year" placeholder="Year" required>
                <input type="text" name="plate" placeholder="Plate" required>
                <button type="submit">Add</button>
            </form>
        </div>

    <div class="container">
        <div class="table-container">
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
</div>
</body>
</html>
