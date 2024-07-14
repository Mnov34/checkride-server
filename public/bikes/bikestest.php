<?php
// connexion à la bdd

global $conn;
require('config.php');

// gestion des sessions

require('session_manager.php');
require_login();

// demarrage des sessions

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// redirection si utlisateurs pas connecté

if (!isset($_SESSION["username"])) {
    header("Location: ./bikes/login.php");
    exit();
}

$userId = $_SESSION['user_id'];

// gestion du CRUD et des erreurs lier au CRUD grace au try-catch

try {
    $dsn = 'mysql:host=' . DB_SERVER . ';dbname=' . DB_NAME;
    $pdo = new PDO($dsn, DB_USERNAME, DB_PASSWORD);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Gestion de la suppression
    if (isset($_GET['delete'])) {
        $id = $_GET['delete'];
        $stmt = $pdo->prepare("DELETE FROM motorcycle WHERE Id_motorcycle = ?");
        $stmt->execute([$id]);
        header("Location: bikestest.php?success=Moto supprimée");
        exit();
    }

    // Gestion de la mise à jour
    if (isset($_POST['update'])) {
        $id = $_POST['id'];
        $brand = $_POST['motorcycle_brand'];
        $model = $_POST['model'];
        $cylinder = $_POST['cylinder'];
        $prod_year = $_POST['prod_year'];
        $plate = $_POST['plate'];

        $stmt = $pdo->prepare("UPDATE motorcycle SET brand = ?, model = ?, cylinder = ?, prod_year = ?, plate = ? WHERE Id_motorcycle = ?");
        $stmt->execute([$brand, $model, $cylinder, $prod_year, $plate, $id]);
        header("Location: bikestest.php?success=Moto mise à jour");
        exit();
    }

    $stmt = $pdo->prepare("SELECT * FROM motorcycle WHERE Id_checkride_user = ?");
    $stmt->execute([$userId]);
    $bikes = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Échec de la connexion : " . $e->getMessage();
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkride</title>
    <link rel="shortcut icon" href="img/faviconmoto.png" type="image/png">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <!-- Font Awesome  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- CSS  -->
    <link rel="stylesheet" href="./style.css">
</head>
<body class="vh-100">
<!--Navbar-->
<nav class="navbar navbar-expand-lg navbar-dark" style="background-color: rgba(19, 43, 64, 0.8);">
    <div class="container">
        <!--Logo-->
        <a class="navbar-brand" href="#">CHECKRIDE</a>
        <!--Toggle btn-->
        <button class="navbar-toggler shadow-none border-0" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!--SideBar-->
        <div class="sidebar offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
            <!--Sidebar Header-->
            <div class="offcanvas-header text-white border-bottom shadow-none">
                <h5 class="offcanvas-title" id="offcanvasNavbarLabel">CHECKRIDE</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>

            <!--Sidebar Body-->
            <div class="text-white offcanvas-body d-flex flex-column flex-lg-row p-4 p-lg-0">
                <ul class="navbar-nav justify-content-center align-items-center fs-5 flex-grow-1 pe-3">
                    <li class="nav-item mx-2">
                        <a class="nav-link" href="./accueiltest.php">Home</a>
                    </li>
                    <li class="nav-item mx-2">
                        <a class="nav-link" href="./bikestest.php">Bikes</a>
                    </li>
                    <li class="nav-item mx-2">
                        <a class="nav-link" href="./contact.php">Contact</a>
                    </li>
                    <?php if (isset($_SESSION["role"]) && $_SESSION["role"] == "admin"): ?>
                        <li class="nav-item mx-2">
                            <a class="nav-link" href="./admin/add_user.php">Add user</a>
                        </li>
                        <li class="nav-item mx-2">
                            <a class="nav-link" href="./admin/home.php">Admin home</a>
                        </li>
                    <?php endif; ?>
                </ul>
                <div class="d-flex flex-column flex-lg-row justify-content-center align-items-center gap-3">
                    <a href="./login.php"><img src="img/deconnexion.png" alt="disconnect button"></a>
                </div>
            </div>
        </div>
    </div>
</nav>

<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="text-white">
            <span class="h5">Motorcycles</span>
            <br>
            Manage all your existing motorcycles or add a new one.
        </div>
        <div>
            <!-- Button Add motorcycle offcanvas -->
            <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasAddMotorcycle">
                <i class="fa-solid fa-user-plus fa-xs"></i>
                Add new motorcycle
            </button>
            <!-- Button export to CSV -->
            <form method="post" action="./exportBikes.php" style="display:inline-block;">
                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">
                <button class="btn btn-primary" type="submit" name="export_csv">
                    <i class="fa-solid fa-file-csv fa-xs"></i>
                    Export to CSV
                </button>
            </form>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover align-middle" style="width:100%;">
            <thead class="table">
            <tr class="blue">
                <th>#</th>
                <th>Brand</th>
                <th>Model</th>
                <th>Cylinder</th>
                <th>Year</th>
                <th>Plate</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($bikes as $motorcycle): ?>
                <tr>
                    <td><?= $motorcycle['Id_motorcycle']; ?></td>
                    <td><?= $motorcycle['brand']; ?></td>
                    <td><?= $motorcycle['model']; ?></td>
                    <td><?= $motorcycle['cylinder']; ?></td>
                    <td><?= $motorcycle['prod_year']; ?></td>
                    <td><?= $motorcycle['plate']; ?></td>
                    <td>
                        <button class='btn btn-primary edit-btn' data-motorcycle='<?= json_encode($motorcycle); ?>'>Edit</button>
                        <form method='POST' action='./server.php' style='display:inline-block;'>
                            <input type='hidden' name='csrf_token' value='<?= $_SESSION['csrf_token']; ?>'>
                            <input type='hidden' name='entity' value='motorcycle'>
                            <input type='hidden' name='id' value='<?= $motorcycle['Id_motorcycle']; ?>'>
                            <input type='hidden' name='action' value='delete'>
                            <button type='submit' class='btn btn-danger'>Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Add Motorcycle offcanvas (hidden slidebar)-->
<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasAddMotorcycle" style="width:600px; background-color: #132B40; color: white;">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasExampleLabel">Add new Motorcycle</h5>
        <button type="button" class="text-white btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <form method="POST" action="./server.php">
            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">
            <input type="hidden" name="entity" value="motorcycle">
            <input type="hidden" name="action" value="insert">
            <div class="row mb-3">
                <div class="col">
                    <label class="form-label">Brand</label>
                    <select name="motorcycle_brand" class="form-control" required>
                        <option value="Aprilia">Aprilia</option>
                        <option value="Benelli">Benelli</option>
                        <option value="Beta">Beta</option>
                        <option value="BMW">BMW</option>
                        <option value="Buell">Buell</option>
                        <option value="Cagiva">Cagiva</option>
                        <option value="Can-Am">Can-Am</option>
                        <option value="Ducati">Ducati</option>
                        <option value="Gas Gas">Gas Gas</option>
                        <option value="Harley-Davidson">Harley-Davidson</option>
                        <option value="Honda">Honda</option>
                        <option value="Husaberg">Husaberg</option>
                        <option value="Husqvarna">Husqvarna</option>
                        <option value="Indian">Indian</option>
                        <option value="Kawasaki">Kawasaki</option>
                        <option value="KTM">KTM</option>
                        <option value="Moto Guzzi">Moto Guzzi</option>
                        <option value="MV Agusta">MV Agusta</option>
                        <option value="Norton">Norton</option>
                        <option value="Peugeot">Peugeot</option>
                        <option value="Piaggio">Piaggio</option>
                        <option value="Royal Enfield">Royal Enfield</option>
                        <option value="Sherco">Sherco</option>
                        <option value="Suzuki">Suzuki</option>
                        <option value="Triumph">Triumph</option>
                        <option value="Vespa">Vespa</option>
                        <option value="Victory">Victory</option>
                        <option value="Yamaha">Yamaha</option>
                    </select>
                </div>
                <div class="col">
                    <label class="form-label">Model</label>
                    <input type="text" class="form-control" name="model" placeholder="Model" required>
                </div>
            </div>
            <div class="col">
                <label class="form-label">Cylinder</label>
                <input type="text" class="form-control" name="cylinder" placeholder="Cylinder" required>
            </div>
            <div class="col">
                <label class="form-label">Year</label>
                <input type="date" class="form-control" name="prod_year" required>
            </div>
            <div class="col">
                <label class="form-label">Plate</label>
                <input type="text" class="form-control" name="plate" placeholder="AA-123-AA" required>
            </div>
            <br>
            <div>
                <button type="submit" class="btn btn-primary me-1">Submit</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="offcanvas">Cancel</button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Motorcycle offcanvas (hidden slidebar)-->
<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasEditMotorcycle" style="width:600px; background-color: #132B40; color: white;">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasExampleLabel">Edit Motorcycle</h5>
        <button type="button" class="text-white btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <form method="POST" action="./server.php" id="editForm">
            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">
            <input type="hidden" name="entity" value="motorcycle">
            <input type="hidden" name="action" value="update">
            <input type="hidden" name="id" id="edit-id">
            <div class="row mb-3">
                <div class="col">
                    <label class="form-label">Brand</label>
                    <select name="motorcycle_brand" id="edit-motorcycle_brand" class="form-control" required>
                        <option value="Aprilia">Aprilia</option>
                        <option value="Benelli">Benelli</option>
                        <option value="Beta">Beta</option>
                        <option value="BMW">BMW</option>
                        <option value="Buell">Buell</option>
                        <option value="Cagiva">Cagiva</option>
                        <option value="Can-Am">Can-Am</option>
                        <option value="Ducati">Ducati</option>
                        <option value="Gas Gas">Gas Gas</option>
                        <option value="Harley-Davidson">Harley-Davidson</option>
                        <option value="Honda">Honda</option>
                        <option value="Husaberg">Husaberg</option>
                        <option value="Husqvarna">Husqvarna</option>
                        <option value="Indian">Indian</option>
                        <option value="Kawasaki">Kawasaki</option>
                        <option value="KTM">KTM</option>
                        <option value="Moto Guzzi">Moto Guzzi</option>
                        <option value="MV Agusta">MV Agusta</option>
                        <option value="Norton">Norton</option>
                        <option value="Peugeot">Peugeot</option>
                        <option value="Piaggio">Piaggio</option>
                        <option value="Royal Enfield">Royal Enfield</option>
                        <option value="Sherco">Sherco</option>
                        <option value="Suzuki">Suzuki</option>
                        <option value="Triumph">Triumph</option>
                        <option value="Vespa">Vespa</option>
                        <option value="Victory">Victory</option>
                        <option value="Yamaha">Yamaha</option>
                    </select>
                </div>
                <div class="col">
                    <label class="form-label">Model</label>
                    <input type="text" class="form-control" name="model" id="edit-model" placeholder="Model" required>
                </div>
            </div>
            <div class="col">
                <label class="form-label">Cylinder</label>
                <input type="text" class="form-control" name="cylinder" id="edit-cylinder" placeholder="Cylinder" required>
            </div>
            <div class="col">
                <label class="form-label">Year</label>
                <input type="date" class="form-control" name="prod_year" id="edit-prod_year" required>
            </div>
            <div class="col">
                <label class="form-label">Plate</label>
                <input type="text" class="form-control" name="plate" id="edit-plate" placeholder="AA-123-AA" required>
            </div>
            <br>
            <div>
                <button type="submit" class="btn btn-primary me-1">Submit</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="offcanvas">Cancel</button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', (event) => {
        $('.edit-btn').on('click', function() {
            let motorcycle = $(this).data('motorcycle');

            // Applique les données aux champs du formulaire dans le offcanvas
            $('#edit-id').val(motorcycle.Id_motorcycle);
            $('#edit-motorcycle_brand').val(motorcycle.brand);
            $('#edit-model').val(motorcycle.model);
            $('#edit-cylinder').val(motorcycle.cylinder);
            $('#edit-prod_year').val(motorcycle.prod_year);
            $('#edit-plate').val(motorcycle.plate);

            // Affiche le offcanvas
            let offcanvasElement = document.getElementById('offcanvasEditMotorcycle');
            let offcanvas = new bootstrap.Offcanvas(offcanvasElement);
            offcanvas.show();
        });
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js" integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</body>
</html>
