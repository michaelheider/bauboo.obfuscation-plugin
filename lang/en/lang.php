<?php

return [
    'plugin' => [
        'name' => 'Obfuscation',
        'description' => 'Embed a YouTube video with additional data such as its description.',
    ],
    'settings_item' => [
        'description' => 'Set your YouTube API key and manage settings for embedded videos.',
        'keywords' => 'YouTube Bauboo API key API-key',
    ],
    'settings' => [
        'spamspan_inject_label' => 'Inject SpamSpan',
		'spamspan_inject_comment' => 'Whether to inject the modifed SpanSpam script. Disable this, if you are injecting it manually.',
		'hint_title' => 'Credits',
		'hint_text_prelink' => 'This plugin uses a modified version of the SpanSpam script provided ',
		'hint_text_link' => 'here',
		'hint_text_postlink' => '.',
    ],
    'permissions' => [
        'label' => 'Manage YouTube settings.',
    ],
    'components' => [
        'email' => [
            'name' => 'Obfuscated E-Mail',
            'description' => 'Dispaly an email address to users, but obfuscate it for spammers.',
            'email' => [
                'title' => 'E-Mail',
                'description' => 'The email address to display and link to.',
                'validationMessage' => 'Not a valid email address.',
			],
			'anchor' => [
                'title' => 'Anchor',
                'description' => 'If given, display this text instead of the email address. NOT your email address, this is not obfuscated.',
			],
			'subject' => [
                'title' => 'Subject',
                'description' => 'Default subject for the email.',
			],
			'body' => [
                'title' => 'Body',
                'description' => 'Default body for the email.',
            ],
        ],
        'phone' => [
            'name' => 'Obfuscated Phone Number',
            'description' => 'Dispaly a phone number to users, but obfuscate it for spammers.',
            'phone' => [
                'title' => 'Phone Number',
                'description' => 'The phone number to display and link to.',
                'validationMessage' => 'Not a valid phone number.',
			],
			'anchor' => [
                'title' => 'Anchor',
                'description' => 'If given, display this text instead of the phone number. NOT your phone number, this is not obfuscated.',
			],
        ],
    ],
];
