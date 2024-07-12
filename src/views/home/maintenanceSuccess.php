<?php

if (!isset($maintenanceId)) {
    return;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Motorcycle Added</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .popup {
            display: block; /* Ensure it is displayed */
            position: fixed;
            top: 90%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: auto;
            height: 2em;
            max-width: 300px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            background-color: #1f1f1f;
            border-radius: 8px;
            text-align: center;
            z-index: 1000;
        }

        .popup .title {
            margin-top: 0;
        }

        p {
            color: white;
        }

        .title {
            font-size: 0.5em;
        }

        .message {
            font-size: 0.5em;
        }
    </style>
</head>
<body>
<div class="popup">
    <p class="title">New Motorcycle Added</p>
    <p class="message">Motorcycle ID: <?php echo htmlspecialchars($maintenanceId); ?></p>
</div>
</body>
</html>
