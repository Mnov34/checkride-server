<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CheckRide</title>
    <link rel="stylesheet" href="./style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="shortcut icon" href="../img/faviconmoto.png" type="image/png">
</head>
<body>
<header>
    <nav class="nav nav-pills nav-justified">
        <a class="nav-link" href="../bikes/accueiltest.php">Home</a>
        <a class="nav-link" href="../bikes/bikestest.php">Bikes</a>
        <a class="nav-link" href="../bikes/contact.php">Contact</a>
    </nav>
</header>

<?php
global $conn;
require('config.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);

    try {
        $query = "SELECT * FROM `users` WHERE username = :username AND password = :password";
        $stmt = $conn->prepare($query);
        $stmt->execute([':username' => $username, ':password' => hash('sha256', $password)]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            $_SESSION['username'] = $username;
            header("Location: index.php"); // Redirect to home page
        } else {
            $message = "Le nom d'utilisateur ou le mot de passe est incorrect.";
        }
    } catch (PDOException $e) {
        $message = "Error: " . $e->getMessage();
    }
}
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <form action="" method="post" class="p-4 shadow rounded text-white" style="background-color: #132B40";>
                <h1 class="h3 mb-3 fw-normal text-center">Welcome</h1>
                <div class="form-floating mb-3">
                    <input type="text" name="username" class="form-control" id="floatingInput" placeholder="Email" required>
                    <label for="floatingInput">Email</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Password" required>
                    <label for="floatingPassword">Password</label>
                </div>
                <button class="w-100 btn btn-lg btn-secondary" type="submit">Connexion</button>
                <div class="mt-3 text-center">
                    <a href="#" class="d-block text-white">Forgotten password?</a>
                    <a href="register.php" class="d-block text-white">No account yet?</a>
                </div>
                <?php if (!empty($message)) { echo "<p class='text-danger text-center mt-3'>$message</p>"; } ?>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXlHxhd5LYn3N1fV5RBbSCrL3yQ4J5pBIeFgDEBo7C7v8uSOq2u5Ixk6g4T" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cgmxk3Jd3Ks6VVR3GclMSRLTwKbs9IOVSAwtHUf3chszfue4ZmGn5w5YpRa4oz9d" crossorigin="anonymous"></script>
</body>
</html>
