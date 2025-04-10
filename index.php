<?php
// importing form configration file
$form_config = require_once './config/app.php';
// check if user submited 
$err_msg = [
    "name" => [
        "empty" => "Please enter your name.",
        "length" => "Name must be less than 100 characters."
    ],
    "email" => [
        "empty" => "Email address is required.",
        "format" => "Please enter a valid email address (example@domain.com)."
    ],
    "message" => [
        "empty" => "Please enter your message.",
        "length" => "Message must be between 10 and 255 characters."
    ]
];
$errors_to_show = [
    "name_err" => "",
    "email_err" => "",
    "message_err" => ""
];
$is_form_submitted = false;

function checkName(): string
{
    global $err_msg;
    $error = "";
    if (isset($_POST['name'])) {
        $name = trim($_POST['name']);
        if (empty($name)) {
            $error = $err_msg['name']['empty'];
        } else if (strlen($name) > 100) {
            $error = $err_msg['name']['length'];
        }
    }

    return $error;
}
function checkEmail(): string
{
    global $err_msg;
    $error = "";
    if (isset($_POST['email'])) {
        $email = trim($_POST['email']);
        if (empty($email)) {
            $error = $err_msg['email']['empty'];
        } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = $err_msg['email']['format'];
        }
    }

    return $error;
}
function checkMessage(): string
{
    global $err_msg;
    $error = "";
    if (isset($_POST['message'])) {
        $msg = trim($_POST['message']);
        if (empty($msg)) {
            $error = $err_msg['message']['empty'];
        } else if (strlen($msg) < 10 || strlen($msg) > 255) {
            $error = $err_msg['message']['length'];
        }
    }

    return $error;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $is_form_submitted = true;
    $errors_to_show['name_err'] = checkName();
    $errors_to_show['email_err'] = checkEmail();
    $errors_to_show['message_err'] = checkMessage();
    // To print to browser console


    echo "<script>console.log(" . json_encode(trim($_POST['message'])) . ");</script>";
    echo "<script>console.log(" . json_encode($form_config) . ");</script>";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> contact form </title>
    <link rel="stylesheet" href="/os/php/public/assets/css/style.css">
</head>

<body>
    <div class="container">


        <form id="contact_form" action="#" method="POST" enctype="multipart/form-data">
            <h3> Contact Form </h3>
            <div class="row">
                <label class="required" for="name">Your name:</label><br />
                <input id="name" class="input" name="name" type="text" value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>" size="30" /><br />
                <?php
                if ($is_form_submitted && !empty($errors_to_show['name_err'])) { ?>
                    <p class="errMsg" id="name_err"><?php echo ($errors_to_show['name_err']) ?></p>
                <?php
                }
                ?>
            </div>
            <div class="row">
                <label class="required" for="email">Your email:</label><br />
                <input id="email" class="input" name="email" type="text" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" size="30" /><br />
                <?php
                if ($is_form_submitted && !empty($errors_to_show['email_err'])) { ?>
                    <p class="errMsg" id="email_err"><?php echo ($errors_to_show['email_err']) ?></p>
                <?php
                }
                ?>

            </div>
            <div class="row">
                <label class="required" for="message">Your message:</label><br />
                <textarea id="message" class="input" name="message" rows="7" cols="30"><?php echo isset($_POST['message']) ? htmlspecialchars($_POST['message']) : ''; ?></textarea><br />
                <?php
                if ($is_form_submitted && !empty($errors_to_show['message_err'])) { ?>
                    <p class="errMsg" id="message_err"><?php echo ($errors_to_show['message_err']) ?></p>
                <?php
                }
                ?>

            </div>

            <input id="submit" name="submit" type="submit" value="Send email" />
            <input id="clear" name="clear" type="submit" value="Clear Form" formnovalidate formaction="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>?clear=true" />
            <?php
            if (isset($_GET['clear'])) {
                // Reset all form values
                $_POST = array();
                echo '<script>window.location.href = "' . htmlspecialchars($_SERVER['PHP_SELF']) . '";</script>';
            }
            ?>

        </form>
        <div id="after_submit">
            <?php
            if (
                $is_form_submitted &&
                empty($errors_to_show['name_err']) &&
                empty($errors_to_show['email_err']) &&
                empty($errors_to_show['message_err'])
            ) {
                echo "<p class='success'>{$form_config['form']['thanks_msg']}</p>";
            }
            ?>
        </div>
    </div>

</body>

</html>