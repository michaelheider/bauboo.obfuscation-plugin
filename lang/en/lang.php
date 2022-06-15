<?php

return [
	'plugin' => [
		'name' => 'Obfuscation',
		'description' => 'Obfuscate emails and phone numbers for spammers, but not for your human visitors.',
	],
	'settings_item' => [
		'description' => 'Manage settings for Obfuscation plugin.',
		'keywords' => 'Obfuscation Bauboo email phone',
	],
	'settings' => [
		'obfuscation_inject_label' => 'Inject Obfuscation Script?',
		'obfuscation_inject_comment' => 'Whether to inject the obfuscation script. Disable this for testing purposes.',
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
			'display' => [
				'title' => 'Display Text',
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
			'display' => [
				'title' => 'Display Text',
				'description' => 'If given, display this text instead of the phone number. NOT your phone number, this is not obfuscated.',
			],
		],
	],
];
