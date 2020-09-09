<?php

namespace Bauboo\YouTube;

use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    /**
     * {@inheritdoc}
     */
    public function registerComponents()
    {
        return [
            'Bauboo\Obfuscation\Components\Mail' => 'mail',
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
                'icon' => 'oc-icon-youtube-play',
                'class' => 'Bauboo\obfuscation\Models\Settings',
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
