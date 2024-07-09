<?php
global $conn;
require('../config.php');
require('../session_manager.php');
require_admin();

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Vérifiez si l'utilisateur est connecté, sinon redirigez-le vers la page de connexion
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}

// Suppression de l'utilisateur
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $conn->prepare('DELETE FROM checkride_user WHERE Id_checkride_user = :id');
    $stmt->execute([':id' => $id]);
    header("Location: home.php?success=User deleted successfully");
    exit();
}

// Mise à jour de l'utilisateur
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $cr_user = $_POST['cr_user'];
    $email = $_POST['email'];
    $status = $_POST['status'];

    $stmt = $conn->prepare('UPDATE checkride_user SET CR_user = :cr_user, email = :email, status = :status WHERE Id_checkride_user = :id');
    $stmt->execute([
        ':cr_user' => $cr_user,
        ':email' => $email,
        ':status' => $status,
        ':id' => $id
    ]);
    header("Location: home.php?success=User updated successfully");
    exit();
}

// Récupérer tous les utilisateurs
$stmt = $conn->prepare('SELECT * FROM checkride_user');
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkride</title>
    <link rel="shortcut icon" href="../../img/faviconmoto.png" type="image/png">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <!-- Font Awesome  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Datatables CSS  -->
    <link href="https://cdn.datatables.net/v/bs5/dt-1.13.4/datatables.min.css" rel="stylesheet" />
    <!-- CSS  -->
    <link rel="stylesheet" href="../style.css">
</head>
<body class="vh-100 overflow-hidden">
<?php if (isset($_GET['error'])): ?>
    <div id="alert-error" class="alert alert-danger" role="alert">
        <?php echo htmlspecialchars($_GET['error']); ?>
    </div>
<?php endif; ?>

<?php if (isset($_GET['success'])): ?>
    <div id="alert-success" class="alert alert-success" role="alert">
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
                        <a class="nav-link" href="../../bikes/accueiltest.php">Home</a>
                    </li>
                    <li class="nav-item mx-2">
                        <a class="nav-link" href="../../bikes/bikestest.php">Bikes</a>
                    </li>
                    <li class="nav-item mx-2">
                        <a class="nav-link" href="../../bikes/contact.php">Contact</a>
                    </li>
                    <?php if (isset($_SESSION["role"]) && $_SESSION["role"] == "admin"): ?>
                        <li class="nav-item mx-2">
                            <a class="nav-link" href="../../bikes/admin/add_user.php">Add user</a>
                        </li>
                        <li class="nav-item mx-2">
                            <a class="nav-link" href="../../bikes/admin/home.php">Admin home</a>
                        </li>
                    <?php endif; ?>
                </ul>
                <div class="d-flex flex-column flex-lg-row justify-content-center align-items-center gap-3">
                    <a href="../login.php"><img src="../../img/deconnexion.png" alt="disconnect button"></a>
                </div>
            </div>
        </div>
    </div>
</nav>
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="text-white">
            <h5>CheckRide Users</h5>
            <p>Manage all your existing users.</p>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover align-middle" id="myTable" style="width:100%;">
            <thead class="table" style="background-color: #132B40;">
            <tr>
                <th class="col-3">User</th>
                <th class="col-4">Email</th>
                <th class="col-2">Status</th>
                <th class="col-3">Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($users as $row): ?>
                <tr>
                    <td><?php echo $row['CR_user']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td><?php echo $row['status']; ?></td>
                    <td>
                        <a href="#" class="btn btn-danger btn-sm delete-btn" data-id="<?php echo $row['Id_checkride_user']; ?>">Delete</a>
                        <button class="btn btn-primary btn-sm btn-edit" data-id="<?php echo $row['Id_checkride_user']; ?>" data-user="<?php echo $row['CR_user']; ?>" data-email="<?php echo $row['email']; ?>" data-status="<?php echo $row['status']; ?>">Edit</button>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Edit User Modal -->
<div class="modal fade custom-modal" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="home.php">
                <div class="modal-header">
                    <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="editUserId">
                    <div class="mb-3">
                        <label for="editUser" class="form-label">User</label>
                        <input type="text" class="form-control" id="editUser" name="cr_user" required>
                    </div>
                    <div class="mb-3">
                        <label for="editEmail" class="form-label">Email</label>
                        <input type="email" class="form-control" id="editEmail" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="editStatus" class="form-label">Status</label>
                        <select class="form-control" id="editStatus" name="status" required>
                            <option value="user">user</option>
                            <option value="admin">admin</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" name="update">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php $conn = null; // Fermer la connexion ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
<!-- Jquery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js" integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<!-- Datatables  -->
<script src="https://cdn.datatables.net/v/bs5/dt-1.13.4/datatables.min.js"></script>
<script>
    $(document).ready(function() {
        $('#myTable').DataTable({
            searching: false, // Disable search
            paging: false,    // Disable pagination
            info: false       // Disable the information about number of entries
        });

        // Hide success or error messages after 2 seconds
        setTimeout(function() {
            var successAlert = document.getElementById('alert-success');
            if (successAlert) {
                successAlert.style.display = 'none';
            }
            var errorAlert = document.getElementById('alert-error');
            if (errorAlert) {
                errorAlert.style.display = 'none';
            }
        }, 2000);

        // Handle edit button click
        $('.btn-edit').on('click', function() {
            var id = $(this).data('id');
            var user = $(this).data('user');
            var email = $(this).data('email');
            var status = $(this).data('status');

            $('#editUserId').val(id);
            $('#editUser').val(user);
            $('#editEmail').val(email);
            $('#editStatus').val(status);

            $('#editUserModal').modal('show');
        });

        // Handle delete button click
        $('.delete-btn').on('click', function(e) {
            e.preventDefault();
            var userId = $(this).data('id');
            var result = confirm("Are you sure you want to delete this user?");
            if (result) {
                window.location.href = 'home.php?delete=' + userId;
            }
        });
    });
</script>
</body>
</html>