<?php
global $conn;
require('../config.php');
require('../session_manager.php');
require_admin();
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
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
<body>
<?php


if (isset($_POST['submit'], $_POST['username'], $_POST['email'], $_POST['type'], $_POST['CR_password'])) {
    $username = htmlspecialchars($_POST['username']);
    $email = htmlspecialchars($_POST['email']);
    $type = htmlspecialchars($_POST['type']);
    $password = htmlspecialchars($_POST['CR_password']); // Modifié pour correspondre au nom du champ dans le formulaire
    $hashed_password = hash('sha256', $password);

    try {
        $query = "INSERT INTO checkride_user (CR_user, email, status, CR_password) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->execute([$username, $email, $type, $hashed_password]);

        header('Location: add_user.php');
        exit();
    } catch (PDOException $e) {
        echo "<div class='alert alert-danger'>Erreur lors de la création de l'utilisateur : " . $e->getMessage() . "</div>";
    }
} else {
?>

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
                    <li class="nav-item mx-2">
                        <a class="nav-link" href="../../bikes/admin/add_user.php">Add user</a>
                    </li>
                    <li class="nav-item mx-2">
                        <a class="nav-link" href="../../bikes/admin/home.php">Admin home</a>
                    </li>
                </ul>
                <div class="d-flex flex-column flex-lg-row justify-content-center align-items-center gap-3">
                    <a href="./../login.php"><img src="../../img/deconnexion.png" alt="disconnect button"></a>
                </div>
            </div>
        </div>
    </div>
</nav>

<div class="container pt-1 mt-4" style="background-color: #132B40;border-radius: 15px;max-width: 600px; ">
    <h2 class="text-center text-white mb-1 mt-3">Add User</h2>
    <form action="" method="post" class="p-4 rounded">
        <div class="mb-1">
            <label for="username" class="form-label text-white">Username</label>
            <input type="text" class="form-control" name="username" id="username" placeholder="Nom d'utilisateur" required>
        </div>
        <div class="mb-1">
            <label for="email" class="form-label text-white">Email</label>
            <input type="email" class="form-control" name="email" id="email" placeholder="Email" required>
        </div>
        <div class="mb-1">
            <label for="type" class="form-label text-white">Type</label>
            <select class="form-select" name="type" id="type" required>
                <option value="" disabled selected>Select Type</option>
                <option value="admin">admin</option>
                <option value="user">user</option>
            </select>
        </div>
        <div class="row mb-3 text-white">
            <div class="col">
                <label for="CR_password" class="form-label">Password</label>
                <input type="password" name="CR_password" id="CR_password" class="form-control" placeholder="Password" required>
            </div>
            <div class="col">
                <label for="confirm_password" class="form-label">Confirm password</label>
                <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="Confirm password" required>
            </div>
        </div>
        <div class="text-center">
            <button type="submit" name="submit" class="btn btn-primary"> Add User</button>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXlHxhd5LYn3N1fV5RBbSCrL3yQ4J5pBIeFgDEBo7C7v8uSOq2u5Ixk6g4T" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cgmxk3Jd3Ks6VVR3GclMSRLTwKbs9IOVSAwtHUf3chszfue4ZmGn5w5YpRa4oz9d" crossorigin="anonymous"></script>

<?php } ?>
</body>
</html>