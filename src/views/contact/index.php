<?php
/*require('session_manager.php');
require_login();

global $conn;
require('config.php');

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION["username"])) {
    header("Location: ./bikes/login.php");
    exit();
}*/
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkride</title>
    <link rel="shortcut icon" href="../img/faviconmoto.png" type="image/png">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <!-- Font Awesome  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Datatables CSS  -->
    <link href="https://cdn.datatables.net/v/bs5/dt-1.13.4/datatables.min.css" rel="stylesheet" />
    <!-- CSS  -->
    <link rel="stylesheet" href="./style.css">
</head>
<body class="vh-100 overflow-hidden">

<header>
    <?php include 'src/views/shared/navBar.php'; ?>
</header>

<div class="container">
    <div id="contacts" class="contact py-5 ">
        <div class="container text-white" style="background-color: #132B40; border-radius: 15px; max-width: 800px;">
            <h2 class="section__tittle text-center text-white" style="padding-top: 20px">CONTACT US !</h2>
            <form action="https://formsubmit.co/boitemailenvoiephpmailer@gmail.com" method="POST" class="form">
                <div class="mb-3">
                    <label for="CR_user" class="form-label">Checkride user</label>
                    <input type="text" name="CR_user" id="CR_user" class="form-control" placeholder="Checkride user" required>
                </div>
                <div class="mb-3">
                    <label for="Object" class="form-label">Object</label>
                    <input type="text" name="Object" id="Object" class="form-control" placeholder="Object" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" id="email" class="form-control" placeholder="Email" required>
                </div>
                <div class="mb-3">
                    <label for="message" class="form-label">Message</label>
                    <textarea name="message" id="message" class="form-control" rows="4" placeholder="Message" required></textarea>
                </div>
                <div class="text-center">
                    <input type="submit" class="btn btn-primary" value="SEND" style="max-width: 150px;">
                </div>
            </form>
            <p class="text-center" style="padding-bottom: 20px">Need help, more information or just to chat? Use our form to contact us !</p>
        </div>
    </div>
</div
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous">
</script>
</body>
</html>