<?php
global $conn;
require('../config.php');

// Initialiser la session
session_start();

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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CheckRide</title>
    <link rel="stylesheet" href="../style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="shortcut icon" href="../../img/faviconmoto.png" type="image/png">
</head>
<body>
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

<header>
    <nav>
        <a href="../../bikes/accueiltest.php">Home</a>
        <a href="../../bikes/bikestest.php">Bikes</a>
        <a href="../../bikes/contact.php">Contact</a>
        <a href="./add_user.php">Add user</a>
        <a href="./home.php">Admin home</a>
        <span></span>
    </nav>
</header>
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="text-white">
            <span class="h5">CheckRide Users</span>
            <br>
            Manage all your existing users.
        </div>
    </div>
    <div class="table-responsive table-responsive-home">
        <table class="table table-bordered table-striped table-hover align-middle" id="myTable" style="width:100%;">
            <thead class="table">
            <tr class="blue">
                <th>User</th>
                <th>Email</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($users as $row): ?>
                <tr>
                    <td><?php echo $row['CR_user']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td><?php echo $row['status']; ?></td>
                    <td>
                        <a href="home.php?delete=<?php echo $row['Id_checkride_user']; ?>" class="btn btn-danger">Delete</a>
                        <button class="btn btn-primary btn-edit" data-id="<?php echo $row['Id_checkride_user']; ?>" data-user="<?php echo $row['CR_user']; ?>" data-email="<?php echo $row['email']; ?>" data-status="<?php echo $row['status']; ?>">Edit</button>
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
    });
</script>
</body>
</html>
