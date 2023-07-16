<?php

// config for Inventas/ContactSupport
return [

    'should_queue_mails' => true,

    'support_case_types' => [
        'default' => [
            'receiver' => [
                'info@example.org',
            ],
        ],
    ],

];
