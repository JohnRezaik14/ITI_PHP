<?php
    // ^ get configration and put in constant CONFIG
    require_once './src/config.php';
    require_once './src/ContactForm.php';
    // ? need to create instance of contact form and pass to it the configration needed
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Form</title>
    <link rel="stylesheet" href="./assets/css/style.css">
</head>
<body>
    <header>
        <a href="messages.php">Messages History</a>
    </header>
    <main>
        <?php $contactForm->renderForm(); ?>
    </main>
</body>
</html>