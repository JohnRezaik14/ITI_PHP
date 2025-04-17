<?php
    // ^ get configration and put in constant CONFIG
    $formconfig = require_once './src/config.php';
    require_once './src/ContactForm.php';
    require_once './src/FormValidator.php';
    require_once './src/DataLogger.php';
    // print_r($formconfig);
    $contactForm = new ContactForm($formconfig);
    $contactForm->handle_submit();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Form</title>
    <link rel="stylesheet" href="/os/php/public/assets/css/style.css">
    <script src="/os/php/public/assets/js/contact.js" type="module"></script>
</head>
<body>
    <header>
        <a href="index.php?contact=1">Contact Form</a>
        <a href="messages.php">Messages History</a>
    </header>
    <main>
        <?php
            if (isset($_GET['contact'])) {
                global $contactForm;
                $contactForm->renderForm();
            } else {
                echo "<p>Visitors Count :</p>";
            }
        ?>
    </main>
</body>
</html>