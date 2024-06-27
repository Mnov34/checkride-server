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
<?php
global $conn;
require('../config.php');

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
</body>
</html>
<?php } ?>
</body>
</html>