<?php

// config for Inventas/ContactSupport
return [

    'should_queue_mails' => true,

    'from_address' => 'info@example.org',
    'from_name' => 'Support System',

    'support_case_types' => [
        'default' => [
            'name' => 'Default',
            'subject_prefix' => 'Support case: ',
            'receiver' => [
                'info@example.org',
            ],
        ],
        'sales' => [
            'name' => 'Sales',
            'subject_prefix' => 'Sales inquiry: ',
            'receiver' => [
                'info@example.org',
            ],
        ],
    ],

];
