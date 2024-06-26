<?php
global $conn;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CheckRide</title>
    <link rel="stylesheet" href="./style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="shortcut icon" href="../img/faviconmoto.png" type="image/png">
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

<div id="contacts" class="contact py-5">
    <div class="container text-white" style="background-color: #132B40; border-radius: 5px;max-width: 800px;">
        <h2 class="section__tittle text-center text-white" style="padding-top: 20px">Inscription</h2>
        <form action="" method="post" class="form" onsubmit="return validatePassword();">
            <div>
                <label for="CR_user" class="form-label">User</label>
                <input type="text" name="CR_user" id="CR_user" class="form-control" placeholder="User" required>
            </div>
            <div class="row">
                <div class="col">
                    <label for="CR_password" class="form-label">Password</label>
                    <input type="password" name="CR_password" id="CR_password" class="form-control" placeholder="Password" required>
                </div>
                <div class="col">
                    <label for="confirm_password" class="form-label">Confirm password</label>
                    <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="Confirm password" required>
                </div>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control" placeholder="Email" required>
            </div>
            <div class="text-center">
                <input type="submit" name="submit" class="btn btn-primary w-100" value="REGISTER" style="max-width: 150px;border-radius: 15px;">
            </div>
            <p class="text-center mt-3 text-white">If you already have an account,<br> <a href="login.php" class="text-white">click here to log in</a>.</p>
        </form>
        <p class="text-center" style="padding-bottom: 20px">Need help, more information or just to chat? Use our form to contact us!</p>
    </div>
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
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXlHxhd5LYn3N1fV5RBbSCrL3yQ4J5pBIeFgDEBo7C7v8uSOq2u5Ixk6g4T" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cgmxk3Jd3Ks6VVR3GclMSRLTwKbs9IOVSAwtHUf3chszfue4ZmGn5w5YpRa4oz9d" crossorigin="anonymous"></script>
</body>
</html>
