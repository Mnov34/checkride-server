<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            position: relative;
            height: 100vh;
            font-family: Arial, sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(to top right, #482673 0%, #2b5876 100%);
            color: white;
            flex-direction: column;
        }

        .container {
            position: relative;
        }

        .container.exception {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 50%;
            margin-top: 30px;
        }

        form {
            background: rgba(255, 255, 255, 0.3);
            padding: 3rem;
            border-radius: 20px;
            border-left: 1px solid rgba(255, 255, 255, 0.3);
            border-top: 1px solid rgba(255, 255, 255, 0.3);
            backdrop-filter: blur(10px);
            box-shadow: 20px 20px 40px -6px rgba(0, 0, 0, 0.2);
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .success,
        .error {
            text-align: center;
            background-color: rgba(0, 0, 0, 0.5);
            border-radius: 10px;
            padding: 10px;
            /* reduced padding */
            margin-top: 20px;
            font-size: 0.9em;
            /* reduced font size */
            width: 60%;
            /* reduced width */
            color: white;
            margin: 10px auto;
            /* reduced margin */
        }

        p {
            color: white;
            font-weight: 500;
            opacity: .7;
            font-size: 1.4rem;
            margin-bottom: 60px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, .2);
            font-size: 2em;
        }

        a {
            text-decoration: none;
            color: #ddd;
            font-size: 1em;
        }

        a:hover {
            text-shadow: 2px 2px 6px #00000040;
        }

        a:active {
            text-shadow: none;
        }

        input {
            background: transparent;
            border: none;
            border-radius: 50px;
            padding: 1rem;
            width: 250px;
            margin-bottom: 1.5em;
            backdrop-filter: blur(5px);
            box-shadow: 4px 4px 60px rgba(0, 0, 0, 0.2);
            color: white;
            transition: all 0.3s;
        }

        input[type="submit"] {
            margin-top: 10px;
            width: 150px;
            cursor: pointer;
        }

        ::placeholder {
            color: #fff;
        }

        .drop {
            background: rgba(255, 255, 255, 0.3);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-radius: 10px;
            border-left: 1px solid rgba(255, 255, 255, 0.3);
            border-top: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 10px 10px 60px -8px rgba(0, 0, 0, 0.2);
            position: absolute;
            transition: all 0.2s ease;
        }

        .drop-1 {
            height: 80px;
            width: 80px;
            top: -20px;
            left: -40px;
            z-index: -1;
        }

        .drop-2 {
            height: 80px;
            width: 80px;
            bottom: -40px;
            right: -40px;
        }

        .drop-3 {
            height: 100px;
            width: 100px;
            bottom: -40px;
            left: -40px;
            z-index: -1;
        }

        .drop-4 {
            height: 120px;
            width: 120px;
            top: -60px;
            right: -60px;
        }
    </style>
    <script>
        function validatePassword() {
            var password = document.getElementsByName("CR_password")[0].value;
            var confirmPassword = document.getElementsByName("confirm_password")[0].value;
            if (password != confirmPassword) {
                alert("Les mots de passe ne correspondent pas.");
                return false;
            }
            return true;
        }
    </script>
</head>

<body>
<div class="container">
    <form action="" method="post" onsubmit="return validatePassword();">
        <h2>Inscription</h2>
        <input type="text" name="CR_user" placeholder="Nom d'utilisateur" required />
        <input type="password" name="CR_password" placeholder="Mot de passe" required />
        <input type="password" name="confirm_password" placeholder="Confirmez le mot de passe" required />
        <input type="email" name="email" placeholder="Email" required />
        <input type="submit" name="submit" value="S'inscrire" />
    </form>
    <div class="drop drop-1"></div>
    <div class="drop drop-2"></div>
    <div class="drop drop-3"></div>
    <div class="drop drop-4"></div>
</div>
<div class="container exception">
    <?php
    require('config.php');
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
        $CR_user = htmlspecialchars($_POST['CR_user']);
        $CR_password = htmlspecialchars($_POST['CR_password']);
        $confirm_password = htmlspecialchars($_POST['confirm_password']);
        $email = htmlspecialchars($_POST['email']);

        if ($CR_password !== $confirm_password) {
            echo "<div class='error'><h3>Les mots de passe ne correspondent pas.</h3></div>";
        } else {
            try {
                $conn->beginTransaction();
                $statut = 'user';

                $query1 = "INSERT INTO checkride_user (CR_user, CR_password, email, statut) VALUES (:CR_user, :CR_password, :email, :statut)";
                $stmt1 = $conn->prepare($query1);
                $stmt1->execute([
                    ':CR_user' => $CR_user,
                    ':CR_password' => hash('sha256', $CR_password),
                    ':email' => $email,
                    ':statut' => $statut
                ]);
                $id_checkride_user = $conn->lastInsertId();

                $conn->commit();
                echo "<div class='success'><h3>Vous êtes inscrit avec succès.</h3><p>Cliquez ici pour vous <a href='login.php'>connecter</a></p></div>";
            } catch (PDOException $e) {
                $conn->rollBack();
                echo "<div class='error'><h3>Erreur lors de l'inscription : " . $e->getMessage() . "</h3></div>";
            }
        }
    }
    ?>
</div>
</body>

</html>