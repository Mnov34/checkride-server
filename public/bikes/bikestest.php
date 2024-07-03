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
    <!-- Datatables CSS  -->
    <link href="https://cdn.datatables.net/v/bs5/dt-1.13.4/datatables.min.css" rel="stylesheet" />
    <!-- CSS  -->
    <link rel="stylesheet" href="./style.css">
</head>

<body class="vh-100 overflow-hidden">
<?php if (isset($_GET['error'])): ?>
    <div class="alert alert-danger" role="alert">
        <?php echo htmlspecialchars($_GET['error']); ?>
    </div>
<?php endif; ?>

<?php if (isset($_GET['success'])): ?>
    <div class="alert alert-success" role="alert">
        <?php echo htmlspecialchars($_GET['success']); ?>
    </div>
<?php endif; ?>

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
                        <a class="nav-link" href="../bikes/accueiltest.php">Home</a>
                    </li>
                    <li class="nav-item mx-2">
                        <a class="nav-link" href="../bikes/bikestest.php">Bikes</a>
                    </li>
                    <li class="nav-item mx-2">
                        <a class="nav-link" href="../bikes/contact.php">Contact</a>
                    </li>
                    <li class="nav-item mx-2">
                        <a class="nav-link" href="../bikes/admin/add_user.php">Add user</a>
                    </li>
                    <li class="nav-item mx-2">
                        <a class="nav-link" href="../bikes/admin/home.php">Admin home</a>
                    </li>
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
            <span class="h5">Motorcycle</span>
            <br>
            Manage all your existing motorcycle or add a new one.
        </div>
        <div>
            <!-- Button to trigger Add user offcanvas -->
            <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasAddUser">
                <i class="fa-solid fa-user-plus fa-xs"></i>
                Add new maintenance
            </button>
            <!-- Button to export to CSV -->
            <form method="post" action="./exportBikes.php" style="display:inline-block;">
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
                <th>Cylinder</th>
                <th>Year</th>
                <th>Plate</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $stmt = $conn->prepare("SELECT * FROM motorcycle");
            $stmt->execute();
            $motorcycles = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($motorcycles as $motorcycle) {
                echo "<tr>
                                    <td>{$motorcycle['Id_motorcycle']}</td>
                                    <td>{$motorcycle['brand']}</td>
                                    <td>{$motorcycle['model']}</td>
                                    <td>{$motorcycle['cylinder']}</td>
                                    <td>{$motorcycle['prod_year']}</td>
                                    <td>{$motorcycle['plate']}</td>
                                    <td>
                                        <button class='btn btn-primary edit-btn' data-motorcycle='" . json_encode($motorcycle) . "'>Edit</button>
                                        <form method='POST' action='server.php' style='display:inline-block;'>
                                            <input type='hidden' name='id' value='{$motorcycle['Id_motorcycle']}'>
                                            <button type='submit' name='action' value='delete' class='btn btn-danger'>Delete</button>
                                        </form>
                                    </td>
                                  </tr>";
            }
            ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Add Motorcycle offcanvas  -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasAddUser" style="width:600px; background-color: #132B40; color: white;">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasExampleLabel">Add new Motorcycle</h5>
        <button type="button" class="text-white btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <form method="POST" action="server.php">
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
                <button type="submit" class="btn btn-primary me-1" name="action" value="insert">Submit</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="offcanvas">Cancel</button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Motorcycle offcanvas  -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasEditUser" style="width:600px; background-color: #132B40; color: white;">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasExampleLabel">Edit Motorcycle</h5>
        <button type="button" class="text-white btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <form method="POST" action="server.php" id="editForm">
            <input type="hidden" name="id" id="edit-id">
            <div class="row mb-3">
                <div class="col">
                    <label class="form-label">Brand</label>
                    <select name="motorcycle_brand" class="form-control">
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
                    <input type="text" class="form-control" name="model" placeholder="Model">
                </div>
            </div>
            <div class="col">
                <label class="form-label">Cylinder</label>
                <input type="text" class="form-control" name="cylinder" placeholder="Cylinder">
            </div>
            <div class="col">
                <label class="form-label">Year</label>
                <input type="date" class="form-control" name="prod_year">
            </div>
            <div class="col">
                <label class="form-label">Plate</label>
                <input type="text" class="form-control" name="plate" placeholder="AA-123-AA">
            </div>
            <br>
            <div>
                <button type="submit" class="btn btn-primary me-1" name="action" value="update">Submit</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="offcanvas">Cancel</button>
            </div>
        </form>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#myTable').DataTable();

        $('.edit-btn').on('click', function() {
            let motorcycle = $(this).data('motorcycle');
            if (motorcycle) {
                $('#edit-id').val(motorcycle.Id_motorcycle);
                $('select[name="motorcycle_brand"]').val(motorcycle.brand);
                $('input[name="model"]').val(motorcycle.model);
                $('input[name="cylinder"]').val(motorcycle.cylinder);
                $('input[name="prod_year"]').val(motorcycle.prod_year);
                $('input[name="plate"]').val(motorcycle.plate);
                $('#offcanvasEditUser').offcanvas('show');
            }
        });
    });
</script>

<!-- Bootstrap  -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
<!-- Jquery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js" integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<!-- Datatables  -->
<script src="https://cdn.datatables.net/v/bs5/dt-1.13.4/datatables.min.js"></script>
</body>

</html>
