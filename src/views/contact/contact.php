<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CheckRide</title>
    <link rel="stylesheet" href="../../../public/css/style.css">
    <link rel="shortcut icon" href="../../../public/img/faviconmoto.png" type="image/png">

</head>
<body id="body-contact">
<header>
    <nav>
        <a href="accueil.php">About</a>
        <a href="bikes.php">Bikes</a>
        <a href="contact.php">Contact</a>
        <span></span>
    </nav>
</header>
<section id="contacts" class="contact">
    <div class="container">
        <div class="section-header">
            <h2 class="section__tittle">CONTACT US ! </h2>
            <p>Need help, more information or just to chat ? Use our form to contact us !</p>
        </div>
    </div>
    <div class="container">
        <form action="https://formsubmit.co/boitemailenvoiephpmailer@gmail.com " method="POST" class="form-contact">
            <label for="firstname">
                <input class="input-contact" type="text" name="firstname" id="firstname" placeholder="Firstname">
            </label>
            <label for="lastname">
                <input class="input-contact" type="text" name="lastname" id="lastname" placeholder="Lastname">
            </label>
            <label for="email">
                <input class="input-contact" type="email" name="email" id="email" placeholder="Email">
            </label>
            <textarea name="message" id="message" placeholder="Message"></textarea>
            <input type="submit" class="btn intput-contact" value="Send">
        </form>
    </div>
</section>
</body>
</html>
