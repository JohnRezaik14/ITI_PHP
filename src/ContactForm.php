<?php
    class ContactForm
    {
        private $config;
        private $errors      = [];
        private $formData    = [];
        private $isSubmitted = false;
        private $isValid     = false;

        public function __construct($config)
        {
            $this->config = $config;
        }
        // ? build class for FormValidation
        // ? DataLogger for logging user data

    }

    // importing form configration file
    $config = require_once './app.config.php';
    define("FORM_CONFIG", $config['form']);

    $err_msg = [
        "name"    => [
            "empty"  => "Please enter your name.",
            "length" => "Name must be less than 100 characters.",
        ],
        "email"   => [
            "empty"  => "Email address is required.",
            "format" => "Please enter a valid email address (example@domain.com).",
        ],
        "message" => [
            "empty"  => "Please enter your message.",
            "length" => "Message must be between 10 and 255 characters.",
        ],
    ];
    $errors_to_show = [
        "name_err"    => "",
        "email_err"   => "",
        "message_err" => "",
    ];
    $is_form_valid     = false;
    $is_form_submitted = false;

    function checkName(): string
    {
        global $err_msg;
        $error = "";
        if (isset($_POST['name'])) {
            $name = trim($_POST['name']);
            if (empty($name)) {
                $error = $err_msg['name']['empty'];
            } else if (strlen($name) > FORM_CONFIG['max_name_length']) {
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
            } else if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
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
            } else if (strlen($msg) < 10 || strlen($msg) > FORM_CONFIG['max_msg_length']) {
                $error = $err_msg['message']['length'];
            }
        }

        return $error;
    }
    function handle_submit()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            global $is_form_submitted;
            $is_form_submitted = true;
            validate_form();
            // To print to browser console
            // echo "<script>console.log(" . json_encode(trim($_POST['message'])) . ");</script>";
            // echo "<script>console.log(" . json_encode($form_config) . ");</script>";
        }
    }
    function validate_form()
    {
        $errors_to_show['name_err']    = checkName();
        $errors_to_show['email_err']   = checkEmail();
        $errors_to_show['message_err'] = checkMessage();
        if (empty($errors_to_show['name_err']) &&
            empty($errors_to_show['email_err']) &&
            empty($errors_to_show['message_err'])) {
            global $is_form_valid;
            $is_form_valid = true;
        }
    }
    // check if user submited
    function log_user_data()
    {
        global $is_form_valid;
        if ($is_form_valid) {
            $handle_file = fopen("messages.log.txt", "a");
            feof($handle_file);
            fwrite($handle_file, (string) $_POST['name'] . $_POST['email'] . PHP_EOL);
            fclose($handle_file);
        }

    }
    echo "<script>console.log(" . "submitted:" . "," . json_encode($is_form_submitted), "valid:", json_encode($is_form_valid), "errors:", json_encode($errors_to_show) . ");</script>";
    handle_submit();
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
    <header>
        <a href="">Messages History</a>
    </header>
    <main>
        <form id="contact_form" class="contactForm" action="#" method="POST" enctype="multipart/form-data">
            <div>
                <div class="header">
                    <h3> Contact Form </h3>
                </div>
                <div class="after_submit">
                    <?php
                        global $is_form_valid;
                        if (
                            $is_form_valid) {
                        ?>
                        <p class='success'><?php echo(FORM_CONFIG['thanks_msg']); ?></p>
                    <?php
                        }
                    ?>
                </div>
                <div class="row">
                    <label class="required" for="name"> Name</label>
                    <input id="name" class="input" name="name" placeholder="Enter your name" type="text" value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>" />
                    <div class="err-container">
                        <?php
                        if ($is_form_submitted && ! empty($errors_to_show['name_err'])) {?>
                            <p class="errMsg" id="name_err"><?php echo($errors_to_show['name_err']) ?></p>
                        <?php
                            }
                        ?>
                    </div>

                </div>
                <div class="row">
                    <label class="required" for="email"> Email</label>
                    <input id="email" class="input" name="email" type="text" placeholder="example@domain.com" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" size="30" />
                    <div class="err-container">                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              <?php
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              if ($is_form_submitted && ! empty($errors_to_show['email_err'])) {?>
                            <p class="errMsg" id="email_err"><?php echo($errors_to_show['email_err']) ?></p>
                        <?php
                            }
                        ?>
                    </div>


                </div>
                <div class="row">
                    <label class="required" for="message"> Message</label>
                    <textarea id="message" class="input" name="message" placeholder="Tell us your message"
                        autocomplete="true" rows="7"><?php echo isset($_POST['message']) ? htmlspecialchars($_POST['message']) : ''; ?></textarea>
                    <div class="err-container">                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              <?php
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              if ($is_form_submitted && ! empty($errors_to_show['message_err'])) {?>
                            <p class="errMsg" id="message_err"><?php echo($errors_to_show['message_err']) ?></p>
                        <?php
                            }
                        ?>
                    </div>


                </div>

                <div class="buttons">
                    <input id="submit" name="submit" type="submit" value="Send email" />
                    <input id="clear" name="clear" type="submit" value="Clear Form" formnovalidate formaction="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>?clear=true" />
                </div>
            </div>


            <?php
                if (isset($_GET['clear'])) {
                    // Reset all form values
                    $_POST = [];
                    echo '<script>window.location.href = "' . htmlspecialchars($_SERVER['PHP_SELF']) . '";</script>';
                }
            ?>

        </form>
    </main>
</body>

</html>