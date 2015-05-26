<?php

return
[
    'validation' => [
        'templateName' => [
            'required' => 'Template name should not be empty'
        ],
        'subject' => [
            'required' => 'Subject should not be empty'
        ],
        'fromName' => [
            'required' => 'From/Sender Name should not be empty'
        ],
        'fromAddress' => [
            'required' => 'From/Sender email address should not be empty',
            'email' => 'From/Sender email address should be a valid email address format'
        ],
        'body' => [
            'required' => 'Template body should not be empty'
        ]
    ]
];