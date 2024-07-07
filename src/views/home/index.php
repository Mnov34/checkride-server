<?php
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkride</title>
    <link rel="shortcut icon" href="/public/assets/img/faviconmoto.png" type="image/png">
    <link rel="stylesheet" href="/public/assets/css/style.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ"
          crossorigin="anonymous">
    <!-- Font Awesome  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
          integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <!-- Datatables CSS  -->
    <link href="https://cdn.datatables.net/v/bs5/dt-1.13.4/datatables.min.css" rel="stylesheet"/>
</head>

<body>
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

<header>
    <?php include 'src/views/shared/navBar.php'; ?>
</header>

<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="text-white">
            <h5>Maintenance</h5>
            <br>
            <p>Manage all your existing maintenance or add a new one.</p>
        </div>
        <!-- Button to trigger Add user offcanvas -->
        <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasAddUser">
            <i class="fa-solid fa-user-plus fa-xs"></i>
            Add new maintenance
        </button>
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
            if (empty($motorcycles)) {
                echo "<tr><td colspan='8' class='text-center'>No motorcycles found.</td></tr>";
            } else {
                foreach ($motorcycles as $row) {
                    echo "<tr>
    <td>{$row['Id_motorcycle']}</td>
    <td>{$row['brand']}</td>
    <td>{$row['model']}</td>
    <td>{$row['plate']}</td>
    <td>{$row['maintenance_kilometer']}</td>
    <td>{$row['parts']}</td>
    <td>{$row['maintenance_date']}</td>
    <td>
        <form method='POST' action='server.php' style='display:inline-block;'>
            <input type='hidden' name='id' value='{$row['Id_motorcycle']}'>
            <button type='submit' name='action' value='edit' class='btn btn-primary'>Edit</button>
        </form>
        <form method='POST' action='server.php' style='display:inline-block;'>
            <input type='hidden' name='id' value='{$row['Id_motorcycle']}'>
            <button type='submit' name='action' value='delete' class='btn btn-danger'>Delete</button>
        </form>
    </td>
</tr>";
                }
            } ?>
            </tbody>
        </table>
    </div>
</div>


<!-- Add Motorcycle offcanvas  -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasAddUser"
     style="width:600px; background-color: #132B40; color: white;">
    <?php include 'src/views/motorcycles/newMotorcycle.php'; ?>
</div>

<!-- Edit Motorcycle offcanvas  -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasAddUser"
     style="width:600px; background-color: #132B40; color: white;">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasExampleLabel">Edit Motorcycle</h5>
        <button type="button" class="text-white btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <form method="POST" action="server.php" id="editForm">
            <input type="hidden" name="id" id="id">
            <div class="row mb-3">
                <div class="col">
                    <label class="form-label">Brand</label>
                    <select name="motorcycle_brand" class="form-control" required>
                        <option value="">-------</option>
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
                    <label class="form-label">Parts</label>
                    <select name="maintenance_parts" class="form-control" required>
                        <option value="">-------</option>
                        <option value="Engine oil">Engine oil</option>
                        <option value="Oil filter">Oil filter</option>
                        <option value="Air filter">Air filter</option>
                        <option value="Front tires">Front tires</option>
                        <option value="Back tires">Back tires</option>
                        <option value="Brake pads">Brake pads</option>
                        <option value="Chain">Chain</option>
                        <option value="Spark plug">Spark plug</option>
                        <option value="Chain lubrication">Chain lubrication</option>
                        <option value="Chain tension">Chain tension</option>
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

<!-- Bootstrap  -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
        crossorigin="anonymous"></script>
<!-- Datatables  -->
<script src="https://cdn.datatables.net/v/bs5/dt-1.13.4/datatables.min.js"></script>
</body>

</html>