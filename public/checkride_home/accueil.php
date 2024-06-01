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

// Requête SQL pour récupérer les données pour le graphique
// Préparation de la requête pour le graphique
$sqlGraph = "SELECT date_kilometer, kilometer FROM kilometers WHERE Id_motorcycle = ? ORDER BY date_kilometer";
$stmtGraph = $conn->prepare($sqlGraph);
$stmtGraph->execute([1]); // Assurez-vous que cette valeur est dynamique si nécessaire

// Préparation des données pour le graphique
$data = [];
if ($stmtGraph->rowCount() > 0) {
    while ($row = $stmtGraph->fetch(PDO::FETCH_ASSOC)) {
        $data[] = [date('Y-m-d', strtotime($row["date_kilometer"])), (int)$row["kilometer"]];
    }
} else {
    echo "0 results";
}


// Requête SQL pour récupérer les données pour le tableau
// Préparation de la requête pour le tableau
$sqlTable = "SELECT m.brand, m.model, YEAR(m.prod_year) AS year, m.plate, k.kilometer, k.date_kilometer AS date
             FROM motorcycle m
             JOIN kilometers k ON m.Id_motorcycle = k.Id_motorcycle
             WHERE k.date_kilometer = (
                 SELECT MAX(k2.date_kilometer)
                 FROM kilometers k2
                 WHERE k2.Id_motorcycle = m.Id_motorcycle
             )";
$stmtTable = $conn->prepare($sqlTable);
$stmtTable->execute();

// Préparation des données pour le tableau
$tableRows = '';
if ($stmtTable->rowCount() > 0) {
    while ($row = $stmtTable->fetch(PDO::FETCH_ASSOC)) {
        $tableRows .= "<tr>
                    <td>{$row['brand']}</td>
                    <td>{$row['model']}</td>
                    <td>{$row['year']}</td>
                    <td>{$row['plate']}</td>
                    <td>{$row['kilometer']}</td>
                    <td>{$row['date']}</td>
                  </tr>";
    }
} else {
    $tableRows .= "<tr><td colspan='6'>No results found</td></tr>";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Home</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="shortcut icon" href="/img/faviconmoto.png" type="image/png">
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Date');
            data.addColumn('number', 'Kilométrage');
            data.addRows(<?php echo json_encode($data); ?>);

            var options = {
                title: 'Kilométrage',
                curveType: 'function',
                legend: { position: 'none' }
            };

            var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));
            chart.draw(data, options);
        }
    </script>
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
    <div class="curve_chart" id="curve_chart" style="height: 500px;"></div>
    <div class="container">
        <table>
            <thead>
            <tr>
                <th>Brand</th>
                <th>Model</th>
                <th>Year</th>
                <th>Plate</th>
                <th>Kilometer</th>
                <th>Date</th>
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
