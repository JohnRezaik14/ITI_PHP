<?php
class FormValidator
{
    private $config;
    private $errorsMessages = [
        "name_err"    => "",
        "email_err"   => "",
        "message_err" => "",
    ];
    private $formErrorsConfig = [];
    public function __construct(array $config)
    {
        $this->config           = $config;
        $this->formErrorsConfig = $this->config['form']['err_msg'];

    }
    public function validate(array $data)
    {
        $this->errorsMessages['name_err']    = $this->validateName($data['name'] ?? '');
        $this->errorsMessages['email_err']   = $this->validateEmail($data['email'] ?? '');
        $this->errorsMessages['message_err'] = $this->validateMessage($data['message'] ?? '');
        return $this->errorsMessages;
    }

    public function validateName(string $name)
    {

        $error = "";

        $name = trim($name);
        if (empty($name)) {
            $error = $this->formErrorsConfig['name']['empty'];
        } else if (strlen($name) > $this->config['form']['max_name_length']) {
            $error = $this->formErrorsConfig['name']['length'];
        }

        return $error;
    }
    public function validateEmail(string $email)
    {
        $error = "";
        $email = trim($email);
        if (empty($email)) {
            $error = $this->formErrorsConfig['email']['empty'];
        } else if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = $this->formErrorsConfig['email']['format'];
        }
        return $error;
    }
    public function validateMessage(string $message)
    {
        $error   = "";
        $message = trim($message);
        if (empty($message)) {
            $error = $this->formErrorsConfig['message']['empty'];
        } else if (strlen($message) < 10 || strlen($message) > $this->config['form']['max_msg_length']) {
            $error = $this->formErrorsConfig['message']['length'];
        }
        return $error;
    }
}
