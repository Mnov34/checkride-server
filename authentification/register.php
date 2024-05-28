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
            overflow: hidden;
        }

        .container {
            position: relative;
            z-index: 1;
        }

        .container.exception {
            position: absolute;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            z-index: 10;
            /* Appliquer un z-index plus élevé */
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 50%;
            margin-top: 30px;
        }

        form {
            background: rgba(255, 255, 255, 0.3);
            padding: 2rem;
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
            margin-top: 20px;
            font-size: 0.9em;
            width: 60%;
            color: white;
            margin: 10px auto;
        }

        p {
            color: white;
            font-weight: 500;
            opacity: .7;
            margin-bottom: 20px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, .2);
            font-size: 1em;
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

        function redirectAfterDelay() {
            setTimeout(function() {
                window.location.href = "register.php";
            }, 2000);
        }
    </script>
</head>

<body>
<div class="container">
    <form action="" method="post" onsubmit="return validatePassword();">
        <h2>Inscription</h2>
        <input type="text" name="CR_user" placeholder="User" required />
        <input type="password" name="CR_password" placeholder="Password" required />
        <input type="password" name="confirm_password" placeholder="Confirm password" required />
        <input type="email" name="email" placeholder="Email" required />
        <input type="submit" name="submit" value="Register" />
        <p>If you already have an account,<br> <a href="login.php">click here to log in</a>.</p>
    </form>
    <div class="drop drop-1"></div>
    <div class="drop drop-2"></div>
    <div class="drop drop-3"></div>
    <div class="drop drop-4"></div>
</div>
<div class="container exception" id="messageContainer">
    <?php
    require('config.php');
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
        $CR_user = htmlspecialchars($_POST['CR_user']);
        $CR_password = htmlspecialchars($_POST['CR_password']);
        $confirm_password = htmlspecialchars($_POST['confirm_password']);
        $email = htmlspecialchars($_POST['email']);

        if ($CR_password !== $confirm_password) {
            echo "<div class='error'><h3>The passwords don’t match.</h3></div>";
            echo "<script>redirectAfterDelay();</script>";
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
                echo "<div class='success'><h3>you have successfully registered.</h3></div>";
                echo "<script>redirectAfterDelay();</script>";
            } catch (PDOException $e) {
                $conn->rollBack();
                echo "<div class='error'><h3>Error while registering: " . $e->getMessage() . "</h3></div>";
                echo "<script>redirectAfterDelay();</script>";
            }
        }
    }
    ?>
</div>
</body>

</html>