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
        <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas"
                data-bs-target="#offcanvasAddMotorcycle">
            <i class="fa-solid fa-user-plus fa-xs"></i>
            Add new maintenance
        </button>
        <form method="post" action="/export/maintenance" style="display:inline-block;">
            <button class="btn btn-primary" type="submit" name="export_csv">
                <i class="fa-solid fa-file-csv fa-xs"></i>
                Export to CSV
            </button>
        </form>
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
        <a href='/maintenance/edit?motorcycle_id={$row['Id_motorcycle']}' class='btn btn-primary' type='button' data-bs-toggle='offcanvas' data-bs-target='#offcanvasEditMotorcycle'>Edit</a>
        <form method='POST' action='server.php' style='display:inline-block;'>
            <input type='hidden' name='motorcycle_id' value='{$row['Id_motorcycle']}'>
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

<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasAddMotorcycle"
     style="width:600px; background-color: #132B40; color: white;">
    <?php include 'src/views/home/newMaintenance.php'; ?>
</div>

<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasEditMotorcycle"
     style="width:600px; background-color: #132B40; color: white;">
    <?php include 'src/views/home/editMaintenance.php'; ?>
</div>

<!-- Bootstrap  -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
        crossorigin="anonymous"></script>
<!-- Datatables  -->
<script src="https://cdn.datatables.net/v/bs5/dt-1.13.4/datatables.min.js"></script>
</body>

</html>