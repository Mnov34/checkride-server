<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CheckRide</title>
    <link rel="stylesheet" href="stylecontact.css">
    <link rel="shortcut icon" href="public/img/faviconmoto.png" type="image/png">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            display: flex;
            flex-direction: column; /* Organize content in a vertical layout */
            align-items: center; /* Center content horizontally */
            height: 100vh;
            margin: 0;
            padding-top: 50px;
            font-family: 'Poppins', sans-serif;
            background-image: url("../img/fondsite2.jpg");
            background-size: cover;
            background-repeat: no-repeat;
            background-position: right center;
            background-attachment: fixed;
            overflow: hidden;
        }

        header {
            width: 100%;
            display: flex;
            justify-content: center;
            position: relative;
            z-index: 1000;
            margin-bottom: 30px;
        }

        nav {
            position: relative;
            width: 300px;
            height: 50px;
            background: #222;
            border-radius: 8px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        nav a {
            position: relative;
            display: inline-block;
            font-size: 1em;
            font-weight: 500;
            color: #fff;
            text-decoration: none;
            padding: 0 23px;
            transition: .5s;
            z-index: 1;
        }

        nav span {
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            background: linear-gradient(45deg, #191d4a 0%, #2b5787 69%);
            border-radius: 8px;
            transition: .5s;
            z-index: 0;
        }

        nav a:nth-child(1):hover ~ span {
            width: 105px;
            left: 0;
        }

        nav a:nth-child(2):hover ~ span {
            width: 75px;
            left: 105px;
        }

        nav a:nth-child(3):hover ~ span {
            width: 120px;
            left: 180px;
        }

        .container {
            position: relative;
        }

        section {
            background: rgba(255, 255, 255, .3);
            padding: 3rem;
            margin: 30px;
            border-radius: 20px;
            border-left: 1px solid rgba(255, 255, 255, .3);
            border-top: 1px solid rgba(255, 255, 255, .3);
            backdrop-filter: blur(10px);
            box-shadow: 20px 20px 40px -6px rgba(0, 0, 0, .2);
            text-align: center;
            font-family: 'Poppins', sans-serif;
            width: 900px;
            height: 600px;
        }

        form {
            background: rgba(255, 255, 255, .3);
            padding: 3rem;
            height: 370px;
            border-radius: 20px;
            border-left: 1px solid rgba(255, 255, 255, .3);
            border-top: 1px solid rgba(255, 255, 255, .3);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            -moz-backdrop-filter: blur(10px);
            box-shadow: 20px 20px 40px -6px rgba(0, 0, 0, .2);
            text-align: center;
        }

        p {
            color: white;
            font-weight: 500;
            opacity: .7;
            font-size: 1.4rem;
            margin-bottom: 60px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, .2);
        }

        a {
            text-decoration: none;
            color: #ddd;
            font-size: 12px;
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
            border-left: 1px solid rgba(255, 255, 255, .3);
            border-top: 1px solid rgba(255, 255, 255, .3);
            padding: 1rem;
            width: 200px;
            border-radius: 50px;
            backdrop-filter: blur(5px);
            box-shadow: 4px 4px 60px rgba(0, 0, 0, .2);
            color: white;
            font-weight: 500;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, .2);
            transition: all .3s;
            margin-bottom: 2em;
        }
        input:hover,
        input[type="email"]:focus,
        input[type="password"]:focus{
            background: rgba(255,255,255,0.1);
            box-shadow: 4px 4px 60px 8px rgba(0,0,0,0.2);
        }

        input[type="button"] {
            margin-top: 10px;
            width: 150px;
            font-size: 1rem;
            cursor: pointer;
        }

        ::placeholder {
            font-family: 'Poppins', sans-serif;
            color: #000;
        }
        .drop {
            background: rgba(255, 255, 255, .3);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-radius: 10px;
            border-left: 1px solid rgba(255, 255, 255, .3);
            border-top: 1px solid rgba(255, 255, 255, .3);
            box-shadow: 10px 10px 60px -8px rgba(0,0,0,0.2);
            position: absolute;
            transition: all 0.2s ease;
        }



        /*Formulaire*/
        #contacts {
            /*background-color: #f4f4f4; */
            padding: 40px;
        }

        .contact form {
            max-width: 600px;
            margin: 0 auto;
        }

        .contact form input,
        .contact form textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #333;
            border-radius: 5px;
        }

        .contact form .btn {
            background-color: #333;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }

        .contact .section__tittle {
            color: #000;
            margin-bottom: 20px;
        }

    </style>
</head>
<body>
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
            <textarea name="message" id="message" placeholder="Message"></textarea>
            <input type="submit" class="btn" value="Send">
        </form>
    </div>
</section>
</body>
</html>
