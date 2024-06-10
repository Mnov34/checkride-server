<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP MySQL Ajax CRUD with Bootstrap 5 and Datatables Library</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <!-- Font Awesome  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Datatables CSS  -->
    <link href="https://cdn.datatables.net/v/bs5/dt-1.13.4/datatables.min.css" rel="stylesheet" />
    <!-- CSS  -->
    <link rel="stylesheet" href="style.css">
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
<div class="container">
    <div class="custom-text-white d-flex justify-content-between align-items-center mb-3">
        <div class="text-body-secondary">
            <span class="h5">Motorcycle</span>
            <br>
            Manage all your existing motorcyle or add a new one.
        </div>
        <!-- Button to trigger Add user offcanvas -->
        <button class="btn btn-dark" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasAddUser">
            <i class="fa-solid fa-user-plus fa-xs"></i>
            Add new motorcycle
        </button>
    </div>


    <table class="table table-bordered table-striped table-hover align-middle" id="myTable" style="width:100%;">
        <thead class="table-dark">
        <tr>
            <th>#</th>
            <th>Brand</th>
            <th>Model</th>
            <th>Cylinder</th>
            <th>Year</th>
            <th>Plate</th>
        </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>



<!-- Add Motorcycle offcanvas  -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasAddUser" style="width:600px;">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasExampleLabel">Add new Motorcycle</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <form method="POST" id="insertForm">
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
                    <input type="text" class="form-control" name="Model" placeholder="Model">
                </div>
            </div>
            <div class="col">
                <label class="form-label">Cylinder</label>
                <input type="text" class="form-control" name="Cylinder" placeholder="Cylinder">
            </div>
            <div class="col">
                <label class="form-label">Year</label>
                <input type="date" class="form-control" name="Year">
            </div>
            <div class="col">
                <label class="form-label">Plate</label>
                <input type="text" class="form-control" name="Plate" placeholder="AA-123-AA">
            </div>
            <br>
            <div>
                <button type="submit" class="btn btn-primary me-1" id="insertBtn">Submit</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="offcanvas">Cancel</button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Motorcycle offcanvas  -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasEditUser" style="width:600px;">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasExampleLabel">Edit user data</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <form method="POST" id="editForm">
            <input type="hidden" name="id" id="id">
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
                    <input type="text" class="form-control" name="Model" placeholder="Model">
                </div>
            </div>
            <div class="col">
                <label class="form-label">Cylinder</label>
                <input type="text" class="form-control" name="Cylinder" placeholder="Cylinder">
            </div>
            <div class="col">
                <label class="form-label">Year</label>
                <input type="date" class="form-control" name="Year">
            </div>
            <div class="col">
                <label class="form-label">Plate</label>
                <input type="text" class="form-control" name="Plate" placeholder="AA-123-AA">
            </div>
            <br>
            <div>
                <button type="submit" class="btn btn-primary me-1" id="insertBtn">Submit</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="offcanvas">Cancel</button>
            </div>
        </form>
    </div>
</div>



<!-- Toast container  -->
<div class="toast-container position-fixed bottom-0 end-0 p-3">
    <!-- Success toast  -->
    <div class="toast align-items-center text-bg-success" role="alert" aria-live="assertive" aria-atomic="true" id="successToast">
        <div class="d-flex">
            <div class="toast-body">
                <strong>Success!</strong>
                <span id="successMsg"></span>
            </div>
            <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
    <!-- Error toast  -->
    <div class="toast align-items-center text-bg-danger" role="alert" aria-live="assertive" aria-atomic="true" id="errorToast">
        <div class="d-flex">
            <div class="toast-body">
                <strong>Error!</strong>
                <span id="errorMsg"></span>
            </div>
            <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>


<!-- Bootstrap  -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
<!-- Jquery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js" integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<!-- Datatables  -->
<script src="https://cdn.datatables.net/v/bs5/dt-1.13.4/datatables.min.js"></script>
<!-- JS  -->
<script src="script.js"></script>
</body>

</html>