<?php require_once APPROOT . "/src/views/shared/header.php";

// Check if user is already logged in
if (isset($_SESSION['user_id'])) {
    header("Location: index.php"); // Redirect if already logged in
    exit;
}

// Example of handling form data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // Here you would typically check the credentials against a database
    if ($email == 'example@example.com' && $password == 'password123') {
        $_SESSION['user_id'] = 123; // Set a session variable
        header("Location: dashboard.php");
        exit;
    } else {
        $error_message = "Invalid credentials!";
    }
}
?>

    <main>
        <div class="container">
            <form method="post">
                <p>Bienvenue</p>
                <label><input type="email" name="email" placeholder="Email"></label><br>
                <label><input type="password" name="password" placeholder="Mot de passe"></label><br>
                <input type="submit" value="Connexion"><br>
                <?php if (!empty($error_message)) echo "<p style='color: red;'>$error_message</p>"; ?>
                <a href="#">Mot de passe oublié ?</a>
                <a href="../newaccount/newaccount.html">Pas de compte ?</a>
            </form>

            <div class="drop drop-1"></div>
            <div class="drop drop-2"></div>
            <div class="drop drop-3"></div>
            <div class="drop drop-4"></div>
            <div class="drop drop-5"></div>
        </div>
    </main>

<?php require_once APPROOT . "/src/views/shared/footer.php"; ?>