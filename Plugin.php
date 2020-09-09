<?php

namespace Bauboo\Obfuscation;

use System\Classes\PluginBase;

class Plugin extends PluginBase
{
	/**
	 * {@inheritdoc}
	 */
	public function registerComponents()
	{
		return [
			'Bauboo\Obfuscation\Components\EMail' => 'email',
			'Bauboo\Obfuscation\Components\Phone' => 'phone',
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function registerSettings()
	{
		return [
			'general' => [
				'label' => 'bauboo.obfuscation::lang.plugin.name',
				'description' => 'bauboo.obfuscation::lang.settings_item.description',
				'icon' => 'oc-icon-at',
				'class' => 'Bauboo\Obfuscation\Models\Settings',
				'permissions' => ['bauboo.obfuscation.access_settings'],
				'keywords' => 'bauboo.obfuscation::lang.settings_item.keywords',
			],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function registerPermissions()
	{
		return [
			'bauboo.obfuscation.access_settings' => [
				'tab' => 'bauboo.obfuscation::lang.plugin.name',
				'label' => 'bauboo.obfuscation::lang.permissions.label',
			],
		];
	}
}
