<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CheckRide</title>
    <link rel="shortcut icon" href="../../../public/img/faviconmoto.png" type="image/png">
    <link rel="stylesheet" href="../../../public/css/style.css">
    <script>
        async function handleLogin(event) {
            event.preventDefault();
            const username = document.querySelector('input[name="username"]').value;
            const password = document.querySelector('input[name="password"]').value;

            const response = await fetch('../../../public/api/login.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({username, password}),
            });

            const result = await response.json();
            if (response.ok) {
                window.location.href = "home.php";
            } else {
                alert(result.message);
            }
        }
    </script>
</head>
<body id="body-login">
<div class="container">
    <form action="" method="post">
        <p>Welcome</p>
        <input type="text" name="username" placeholder="Email" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <input type="submit" value="Connexion"><br>
        <a href="#">Forgotten password?</a>
        <a href="register.php">No account yet?</a>
    </form>
    <div class="drop drop-1"></div>
    <div class="drop drop-2"></div>
    <div class="drop drop-3"></div>
    <div class="drop drop-4"></div>
    <?php if (!empty($message)) {
        echo "<p>$message</p>";
    } ?>
</div>
</body>

</html>
