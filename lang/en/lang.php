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
                'description' => 'The email address to display.',
                'validationMessage' => 'Not a valid email address.',
			],
			'anchor' => [
                'title' => 'Anchor',
                'description' => 'If given, display this text instead of the email address. Else, simply display the email address.',
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
    ],
];
