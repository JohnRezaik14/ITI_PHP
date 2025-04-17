<?php
    /**
     * Enables error reporting for all types of errors and warnings.
     *
     * - `error_reporting(E_ALL);`:
     *   Configures PHP to report all errors, warnings, and notices.
     *   This is useful during development to identify and fix issues.
     *
     * - `ini_set('display_errors', 1);`:
     *   Ensures that errors are displayed in the browser or output.
     *   This is helpful for debugging but should be disabled in production
     *   environments to avoid exposing sensitive information.
     */
    // ! error_reporting(E_ALL);
    // ! ini_set('display_errors', 1);

    class ContactForm
    {
        //form configuration
        private $config;
        // validation errors
        private $errors = [];
        // data entered from the user
        private $formData    = [];
        private $isSubmitted = false;
        private $isValid     = false;
        //instance of validator & logger classes
        private $validator;
        private $logger;
        public function __construct(array $config)
        {
            $this->config    = $config;
            $this->validator = new FormValidator($config);
            $this->logger    = new DataLogger($config['log_file']);
            $this->initializeFormData();
        }
        // ? DataLogger for logging user data
        public function initializeFormData()
        {
            $this->formData = [
                'name'    => '',
                'email'   => '',
                'message' => '',
            ];
        }
        private function clearForm()
        {
            header('Location: ' . htmlspecialchars($_SERVER['PHP_SELF']));
            exit;
        }
        private function sanitizeInput($input)
        {
            return trim(strip_tags($input));
        }
        public function handle_submit()
        {
            if (isset($_GET['clear'])) {
                // echo "Clearing form<br>";
                $this->clearForm();
                return;
            }
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // echo "POST request detected<br>";
                $this->isSubmitted = true;

                $this->collectFormData();

                $this->errors = $this->validator->validate($this->formData);

                $this->isValid = (empty($this->errors['name_err'])
                    && empty($this->errors['email_err'])
                    && empty($this->errors['message_err']));

                if ($this->isValid) {
                    $this->logger->logSubmission($this->formData);
                }
            }
        }
        public function clearFormData()
        {
            $this->formData = [];
            $this->renderForm();
        }
        public function collectFormData()
        {
            $this->formData = [
                'name'    => $this->sanitizeInput($_POST['name'] ?? ''),
                'email'   => $this->sanitizeInput($_POST['email'] ?? ''),
                'message' => $this->sanitizeInput($_POST['message'] ?? ''),
            ];
        }
        public function renderForm()
        {
        ?>
            <form id="contact_form" class="contactForm" action="#" method="POST">
                <div>
                    <div class="header">
                        <h3>Contact Form</h3>
                    </div>
                    <div class="after_submit">
                    <?php
                    if ($this->isSubmitted && $this->isValid) {?>
                            <p class="success-message"><?php echo htmlspecialchars($this->config['thanks_msg']); ?></p>
                            <?php
                                }
                                    ?>
                    </div>
                    <!-- Name Field -->
                    <div class="row">
                        <label class="required" for="name">Name</label>
                        <input id="name" class="input                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              <?php echo isset($this->errors['name']) ? 'error' : ''; ?>"
                               name="name" placeholder="Enter your name" type="text"
                               value="<?php echo htmlspecialchars($this->formData['name']); ?>" />
                        <?php if ($this->isSubmitted && isset($this->errors['name_err'])): ?>
                            <div class="err-container">
                                <p class="errMsg" id="name_err"><?php echo htmlspecialchars($this->errors['name_err']); ?></p>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Email Field -->
                    <div class="row">
                        <label class="required" for="email">Email</label>
                        <input id="email" class="input                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                       <?php echo isset($this->errors['email']) ? 'error' : ''; ?>"
                               name="email" type="text" placeholder="example@domain.com"
                               value="<?php echo htmlspecialchars($this->formData['email']); ?>" />
                        <?php if ($this->isSubmitted && isset($this->errors['email_err'])): ?>
                            <div class="err-container">
                                <p class="errMsg" id="email_err"><?php echo htmlspecialchars($this->errors['email_err']); ?></p>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Message Field -->
                    <div class="row">
                        <label class="required" for="message">Message</label>
                        <textarea id="message" class="input                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <?php echo isset($this->errors['message']) ? 'error' : ''; ?>"
                                  name="message" placeholder="Tell us your message" rows="7" cols="30"><?php echo htmlspecialchars($this->formData['message']); ?></textarea>
                        <?php if ($this->isSubmitted && isset($this->errors['message_err'])): ?>
                            <div class="err-container">
                                <p class="errMsg" id="message_err"><?php echo htmlspecialchars($this->errors['message_err']); ?></p>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Form Buttons -->
                    <div class="buttons">
                        <input id="submit" name="submit" type="submit" value="Send email" />
                        <a id="clear" href="index.php?contact=1" class="button">Clear Form</a>
                    </div>
                </div>
            </form>
            <?php
                }
            }
