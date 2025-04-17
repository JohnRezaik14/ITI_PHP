<?php
return [
    'form'  => [
        'max_name_length' => 100,
        'max_msg_length'  => 255,
        'thanks_msg'      => 'Thank you for contacting Us',

        'log_file'        => 'data/messages.log.txt',
        "err_msg"         => [
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
        ],
    ],
    'paths' => [
        'css' => ['main' => './assets/css/style.css'],
    ],
];
