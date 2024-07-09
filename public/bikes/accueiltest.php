<?php
global $conn;
require('session_manager.php');
require_login();

require('config.php');

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION["username"])) {
    header("Location: ./bikes/login.php");
    exit();
}

$userId = $_SESSION['user_id'];

try {
    $dsn = 'mysql:host=' . DB_SERVER . ';dbname=' . DB_NAME;
    $pdo = new PDO($dsn, DB_USERNAME, DB_PASSWORD);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Gestion de la suppression
    if (isset($_GET['delete'])) {
        $id = $_GET['delete'];
        $stmt = $pdo->prepare("DELETE FROM maintenance WHERE Id_maintenance = ?");
        $stmt->execute([$id]);
        header("Location: accueiltest.php?success=Maintenance supprimée");
        exit();
    }

    // Gestion de la mise à jour
    if (isset($_POST['update'])) {
        $id = $_POST['id'];
        $id_motorcycle = $_POST['id_motorcycle'];
        $maintenance_kilometer = $_POST['maintenance_kilometer'];
        $parts = $_POST['parts'];
        $maintenance_date = $_POST['maintenance_date'];

        $stmt = $pdo->prepare("UPDATE maintenance SET Id_motorcycle = ?, maintenance_kilometer = ?, parts = ?, maintenance_date = ? WHERE Id_maintenance = ?");
        $stmt->execute([$id_motorcycle, $maintenance_kilometer, $parts, $maintenance_date, $id]);
        header("Location: accueiltest.php?success=Maintenance mise à jour");
        exit();
    }

    $stmt = $pdo->prepare("SELECT * FROM checkride_user WHERE Id_checkride_user = ?");
    $stmt->execute([$userId]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
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
    <link rel="shortcut icon" href="../img/faviconmoto.png" type="image/png">
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
                    <a href="./login.php"><img src="../img/deconnexion.png" alt="disconnect button"></a>
                </div>
            </div>
        </div>
    </div>
</nav>

<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="text-white">
            <span class="h5">Maintenance</span>
            <br>
            Manage all your existing maintenance or add a new one.
        </div>
        <div>
            <!-- Button to trigger Add maintenance offcanvas -->
            <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasAddMaintenance">
                <i class="fa-solid fa-user-plus fa-xs"></i>
                Add new maintenance
            </button>
            <!-- Button to export to CSV -->
            <form method="post" action="./exportMaintenance.php" style="display:inline-block;">
                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">
                <button class="btn btn-primary" type="submit" name="export_csv">
                    <i class="fa-solid fa-file-csv fa-xs"></i>
                    Export to CSV
                </button>
            </form>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover align-middle" id="myTable" style="width:100%;">
            <thead class="table">
            <tr class="blue">
                <th>#</th>
                <th>Brand</th>
                <th>Model</th>
                <th>Plate</th>
                <th>Maintenance Kilometer</th>
                <th>Parts</th>
                <th>Maintenance Date</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $stmt = $conn->prepare("
                SELECT 
                    m.Id_motorcycle, m.brand, m.model, m.plate, 
                    mt.Id_maintenance, mt.maintenance_kilometer, mt.parts, mt.maintenance_date
                FROM motorcycle m
                INNER JOIN maintenance mt ON m.Id_motorcycle = mt.Id_motorcycle
                WHERE m.Id_checkride_user = :userId
            ");
            $stmt->execute([':userId' => $userId]);
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($data as $row) {
                echo "<tr>
                    <td>{$row['Id_motorcycle']}</td>
                    <td>{$row['brand']}</td>
                    <td>{$row['model']}</td>
                    <td>{$row['plate']}</td>
                    <td>{$row['maintenance_kilometer']}</td>
                    <td>{$row['parts']}</td>
                    <td>{$row['maintenance_date']}</td>
                    <td>
                        <button class='btn btn-primary edit-btn' data-maintenance='" . json_encode($row) . "'>Edit</button>
                        <form method='POST' action='./server.php' style='display:inline-block;'>
                            <input type='hidden' name='csrf_token' value='{$_SESSION['csrf_token']}'>
                            <input type='hidden' name='entity' value='maintenance'>
                            <input type='hidden' name='action' value='delete'>
                            <input type='hidden' name='id' value='{$row['Id_maintenance']}'>
                            <button type='submit' class='btn btn-danger'>Delete</button>
                        </form>
                    </td>
                </tr>";
            }
            ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Add Maintenance offcanvas  -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasAddMaintenance" style="width:600px; background-color: #132B40; color: white;">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasExampleLabel">Add new Maintenance</h5>
        <button type="button" class="text-white btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <form method="POST" action="./server.php">
            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">
            <input type="hidden" name="entity" value="maintenance">
            <input type="hidden" name="action" value="insert">
            <input type="hidden" name="id_motorcycle" value="<?= $userId; ?>">
            <div class="col">
                <label class="form-label">Maintenance Kilometer</label>
                <input type="number" class="form-control" name="maintenance_kilometer" placeholder="Kilometer" required>
            </div>
            <div class="col">
                <label class="form-label">Parts</label>
                <input type="text" class="form-control" name="parts" placeholder="Parts" required>
            </div>
            <div class="col">
                <label class="form-label">Maintenance Date</label>
                <input type="date" class="form-control" name="maintenance_date" required>
            </div>
            <br>
            <div>
                <button type="submit" class="btn btn-primary me-1">Submit</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="offcanvas">Cancel</button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Maintenance offcanvas  -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasEditMaintenance" style="width:600px; background-color: #132B40; color: white;">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasExampleLabel">Edit Maintenance</h5>
        <button type="button" class="text-white btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <form method="POST" action="./server.php" id="editForm">
            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">
            <input type="hidden" name="entity" value="maintenance">
            <input type="hidden" name="action" value="update">
            <input type="hidden" name="id" id="edit-id">
            <input type="hidden" name="id_motorcycle" id="edit-id_motorcycle">
            <div class="col">
                <label class="form-label">Maintenance Kilometer</label>
                <input type="number" class="form-control" name="maintenance_kilometer" id="edit-maintenance_kilometer" placeholder="Kilometer" required>
            </div>
            <div class="col">
                <label class="form-label">Parts</label>
                <input type="text" class="form-control" name="parts" id="edit-parts" placeholder="Parts" required>
            </div>
            <div class="col">
                <label class="form-label">Maintenance Date</label>
                <input type="date" class="form-control" name="maintenance_date" id="edit-maintenance_date" required>
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
            let maintenance = $(this).data('maintenance');

            // Appliquer les données aux champs du formulaire dans le offcanvas
            $('#edit-id').val(maintenance.Id_maintenance);
            $('#edit-id_motorcycle').val(maintenance.Id_motorcycle);
            $('#edit-maintenance_kilometer').val(maintenance.maintenance_kilometer);
            $('#edit-parts').val(maintenance.parts);
            $('#edit-maintenance_date').val(maintenance.maintenance_date);

            // Afficher le offcanvas
            let offcanvasElement = document.getElementById('offcanvasEditMaintenance');
            let offcanvas = new bootstrap.Offcanvas(offcanvasElement);
            offcanvas.show();
        });
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js" integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</body>
</html>
