<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CheckRide</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="shortcut icon" href="../assets/img/faviconmoto.png" type="image/png">
</head>
<body>
<!--<header>
    <nav>
        <a href="../checkride_home/accueil.php">Home</a>
        <a href="../bikes/bikes.php">Bikes</a>
        <a href="../contact/contact.php">Contact</a>
        <span></span>
    </nav>
</header>-->
<div id="contacts" class="contact">
    <div class="container">
        <h2 class="section__tittle">CONTACT US ! </h2>
        <p>Need help, more information or just to chat ? Use our form to contact us !</p>
        <form action="https://formsubmit.co/boitemailenvoiephpmailer@gmail.com " method="POST" class="form">
            <label for="firstname">
                <input type="text" name="firstname" id="firstname" placeholder="Firstname">
            </label>
            <label for="lastname">
                <input type="text" name="lastname" id="lastname" placeholder="Lastname">
            </label>
            <label for="email">
                <input type="email" name="email" id="email" placeholder="Email">
            </label>
            <label for="message"></label><textarea name="message" id="message" placeholder="Message"></textarea>
            <input type="submit" class="btn" value="Send">
        </form>
    </div>
</div>
</body>
</html>