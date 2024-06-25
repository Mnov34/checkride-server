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
<header>
    <nav>
        <a href="../bikes/accueiltest.php">Home</a>
        <a href="../bikes/bikestest.php">Bikes</a>
        <a href="../bikes/contact.php">Contact</a>
        <span></span>
    </nav>
</header>
<div id="contacts" class="contact py-5 ">
    <div class="container">
        <h2 class="section__tittle text-center">CONTACT US !</h2>
        <p class="text-center">Need help, more information or just to chat? Use our form to contact us!</p>
        <form action="https://formsubmit.co/boitemailenvoiephpmailer@gmail.com" method="POST" class="form">
            <div class="mb-3">
                <label for="firstname" class="form-label">Firstname</label>
                <input type="text" name="firstname" id="firstname" class="form-control" placeholder="Firstname" required>
            </div>
            <div class="mb-3">
                <label for="lastname" class="form-label">Lastname</label>
                <input type="text" name="lastname" id="lastname" class="form-control" placeholder="Lastname" required>
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
                <input type="submit" class="btn btn-primary" value="Send">
            </div>
        </form>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXlHxhd5LYn3N1fV5RBbSCrL3yqU4J5pBIeFgDEBo7C7v8uSOq2u5Ixk6g4T" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cgmxk3Jd3Ks6VVR3GclMSRLTwKbs9IOVSAwtHUf3chszfue4ZmGn5w5YpRa4oz9d" crossorigin="anonymous"></script>
</body>
</html>
