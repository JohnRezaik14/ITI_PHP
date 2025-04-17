<?php
    session_start();
    // ^ get configration and put in constant CONFIG
    require_once 'src/autoload.php';
    $contactForm = new ContactForm($config['form']);
    $contactForm->handle_submit();
    require_once 'src/services/CountVisitors.php';
    $visitors = CountVisitors::getCount($config);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Form</title>
    <link rel="stylesheet" href="/public/assets/css/style.css">
    <script src="/public/assets/js/contact.js" type="module"></script>
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
                echo "<p>Visitors Count: " . $visitors . "</p>";
            }
        ?>
    </main>
</body>
</html>