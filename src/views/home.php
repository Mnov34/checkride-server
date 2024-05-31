<?php
$db = new \src\app\models\Database();
// Requête SQL pour récupérer les données pour le graphique
$sqlGraph = "SELECT date_kilometer, kilometer FROM kilometers WHERE Id_motorcycle = 1 ORDER BY date_kilometer";
$resultGraph = $this->db->Query($sqlGraph);
//$resultGraph = $conn->query($sqlGraph);

// Préparation des données pour le graphique
$data = [];
if ($resultGraph->num_rows > 0) {
    while ($row = $resultGraph->fetch_assoc()) {
        $data[] = [date('Y-m-d', strtotime($row["date_kilometer"])), (int)$row["kilometer"]];
    }
} else {
    echo "0 results";
}

// Requête SQL pour récupérer les données pour le tableau
$sqlTable = "SELECT m.brand, m.model, YEAR(m.prod_year) AS year, m.plate, k.kilometer, k.date_kilometer AS date, 'Maintenance placeholder' AS maintenance
             FROM motorcycle m
             JOIN kilometers k ON m.Id_motorcycle = k.Id_motorcycle
             WHERE k.date_kilometer = (
                 SELECT MAX(k2.date_kilometer)
                 FROM kilometers k2
                 WHERE k2.Id_motorcycle = m.Id_motorcycle
             )";
$resultTable = $conn->query($sqlTable);

// Préparation des données pour le tableau
$tableRows = '';
if ($resultTable->num_rows > 0) {
    while ($row = $resultTable->fetch_assoc()) {
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
    $tableRows .= "<tr><td colspan='7'>No results found</td></tr>";
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Motorcycle Information and Graph</title>
    <link rel="stylesheet" href="stylenav.css">
    <link rel="shortcut icon" href="/img/faviconmoto.png" type="image/png">
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {'packages': ['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Date');
            data.addColumn('number', 'Kilométrage');
            data.addRows(<?php echo json_encode($data); ?>);

            var options = {
                title: 'Kilométrage',
                curveType: 'function',
                legend: {position: 'none'}
            };

            var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));
            chart.draw(data, options);
        }
    </script>
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
            background-image: url("fondsite2.jpg");
            background-size: cover;
            background-repeat: no-repeat;
            background-position: right center; /* Adjusted for aesthetic preference */
            background-attachment: fixed;
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

        #main-container {
            width: 100%;
            align-self: flex-start; /* Align container to the start of the main axis */
            padding-left: 40px; /* Add some padding for aesthetic */
            margin-top: auto; /* Pushes the container to the bottom */
            margin-bottom: 30px;
        }

        #curve_chart, .container {
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
        <a href="home.php">About</a>
        <a href="bikes.php">Bikes</a>
        <a href="contact.php">Contact</a>
        <span></span>
    </nav>
</header>
<div id="main-container">
    <div id="curve_chart" style="height: 500px;"></div>
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
