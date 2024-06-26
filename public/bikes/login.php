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


<?php
global $conn;
require('config.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);

    try {
        $query = "SELECT * FROM `checkride_user` WHERE CR_user = :username AND CR_password = :password";
        $stmt = $conn->prepare($query);
        $stmt->execute([':username' => $username, ':password' => hash('sha256', $password)]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            $_SESSION['username'] = $username;
            // Assurez-vous que la colonne 'user_type' existe dans votre base de données
            $_SESSION['user_type'] = $result['user_type']; // Sauvegarde du type d'utilisateur en session
            if ($result['user_type'] === 'admin') {
                header("Location: admin/home.php"); // Redirection des administrateurs
            } else {
                header("Location: accueiltest.php"); // Redirection des autres utilisateurs
            }
        } else {
            $message = "Le nom d'utilisateur ou le mot de passe est incorrect.";
        }
    } catch (PDOException $e) {
        $message = "Error: " . $e->getMessage();
    }
}
?>

<div id="contacts" class="contact py-5 ">
    <div class="container text-white" style="background-color: #132B40; border-radius: 15px;max-width: 370px;">
        <h2 class="section__tittle text-center text-white" style="padding-top: 20px">Welcome</h2>
        <form action="" method="post" class="form">
            <div>
                <label for="floatingInput" class="form-label">Checkride user</label>
                <input type="text" name="Checkride user" id="floatingInput" class="form-control" placeholder="Checkride user" style="max-width: 350px;required>
            </div>
            <div>
                <label for="floatingPassword" class="form-label"">Password</label>
                <input type="password" name="password" id="floatingPassword" class="form-control" placeholder="Password" style="max-width: 350px; required>
            </div>
            <div class="text-center">
                <div style="max-width: 150px; margin: 0 auto;">
                    <button class="btn btn-primary w-100" type="submit" style="border-radius: 15px;">Connexion</button>
                </div>
            </div>
            <div class="mt-3 text-center">
                <a href="#" class="d-block text-white">Forgotten password?</a>
                <a href="./register.php" class="d-block text-white">No account yet?</a>
            </div>
            <?php if (!empty($message)) { echo "<p class='text-danger text-center mt-3'>$message</p>"; } ?>
        </form>
        <br>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXlHxhd5LYn3N1fV5RBbSCrL3yQ4J5pBIeFgDEBo7C7v8uSOq2u5Ixk6g4T" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cgmxk3Jd3Ks6VVR3GclMSRLTwKbs9IOVSAwtHUf3chszfue4ZmGn5w5YpRa4oz9d" crossorigin="anonymous"></script>
</body>
</html>
