<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="../../../public/css/style.css">
    <script>
        function validatePassword() {
            const password = document.querySelector('input[name="CR_password"]').value;
            const confirmPassword = document.querySelector('input[name="confirm_password"]').value;
            if (password !== confirmPassword) {
                alert("Les mots de passe ne correspondent pas.");
                return false;
            }
            return true;
        }

        async function handleRegister(event) {
            event.preventDefault();
            if (!validatePassword()) {
                return;
            }

            const username = document.querySelector('input[name="CR_user"]').value;
            const password = document.querySelector('input[name="CR_password"]').value;
            const confirmPassword = document.querySelector('input[name="confirm_password"]').value;
            const email = document.querySelector('input[name="email"]').value;

            const response = await fetch('../../../public/api/register.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({username, password, confirm_password: confirmPassword, email}),
            });

            const result = await response.json();
            if (response.ok) {
                alert(result.message);
                setTimeout(() => {
                    window.location.href = "../login/login.php";
                }, 2000);
            } else {
                alert(result.message);
            }
        }
    </script>
</head>

<body id="body-register">
<div class="container">
    <form action="" method="post" onsubmit="handleRegister(event);">
        <h2>Inscription</h2>
        <input type="text" name="CR_user" placeholder="User" required/>
        <input type="password" name="CR_password" placeholder="Password" required/>
        <input type="password" name="confirm_password" placeholder="Confirm password" required/>
        <input type="email" name="email" placeholder="Email" required/>
        <input type="submit" name="submit" value="Register"/>
        <p>If you already have an account,<br> <a href="../login/login.php">click here to log in</a>.</p>
    </form>
    <div class="drop drop-1"></div>
    <div class="drop drop-2"></div>
    <div class="drop drop-3"></div>
    <div class="drop drop-4"></div>
</div>
<div class="container exception" id="messageContainer">
</div>
</body>

</html>