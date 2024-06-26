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
    <div class="container text-white" style="background-color: #132B40; border-radius: 5px;">
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
                <input type="submit" class="btn btn-primary" value="SEND">
            </div>
        </form>
        <p class="text-center" style="padding-bottom: 20px">Need help, more information or just to chat? Use our form to contact us!</p>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXlHxhd5LYn3N1fV5RBbSCrL3yqU4J5pBIeFgDEBo7C7v8uSOq2u5Ixk6g4T" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cgmxk3Jd3Ks6VVR3GclMSRLTwKbs9IOVSAwtHUf3chszfue4ZmGn5w5YpRa4oz9d" crossorigin="anonymous"></script>
</body>
</html>