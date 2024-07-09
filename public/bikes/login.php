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
<body class="vh-100 overflow-hidden">

<?php
session_start();
require('config.php');

// Générer un jeton CSRF si nécessaire
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    try {
        $pdo = new PDO("mysql:host=" . DB_SERVER . ";dbname=" . DB_NAME, DB_USERNAME, DB_PASSWORD);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $pdo->prepare("SELECT Id_checkride_user, CR_password, status FROM checkride_user WHERE CR_user = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['CR_password'])) {
            $_SESSION['username'] = $username;
            $_SESSION['user_id'] = $user['Id_checkride_user'];
            $_SESSION['role'] = $user['status'];  // Stocker le statut de l'utilisateur
            header("Location: accueiltest.php");
            exit();
        } else {
            echo "Nom d'utilisateur ou mot de passe incorrect";
        }
    } catch (PDOException $e) {
        echo "Échec de la connexion : " . $e->getMessage();
    }
}
?>



<div id="contacts" class="contact py-5 ">
    <div class="container text-white" style="background-color: #132B40; border-radius: 15px; max-width: 370px;">
        <h2 class="section__tittle text-center text-white" style="padding-top: 20px">Bienvenue</h2>
        <form action="" method="post" class="form">
            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
            <div>
                <label for="floatingInput" class="form-label">Utilisateur Checkride</label>
                <input type="text" name="username" id="floatingInput" class="form-control" placeholder="Utilisateur Checkride" style="max-width: 350px;" required>
            </div>
            <div>
                <label for="floatingPassword" class="form-label">Mot de passe</label>
                <input type="password" name="password" id="floatingPassword" class="form-control" placeholder="Mot de passe" style="max-width: 350px;" required>
            </div>
            <div class="text-center">
                <div style="max-width: 150px; margin: 0 auto;">
                    <button class="btn btn-primary w-100" type="submit" style="border-radius: 15px;">Connexion</button>
                </div>
            </div>
            <div class="mt-3 text-center">
                <a href="#" class="d-block text-white">Mot de passe oublié ?</a>
                <a href="./register.php" class="d-block text-white">Pas encore de compte ?</a>
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
