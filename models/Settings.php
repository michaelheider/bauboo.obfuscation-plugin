<?php
namespace Bauboo\YouTube\Models;

use Model;
use October\Rain\Database\Traits\Validation as ValidationTrait;

class Settings extends Model
{
    use ValidationTrait;

    public $implement = ['System.Behaviors.SettingsModel'];

    public $settingsCode = 'Bauboo_Obfuscation_Settings';

    public $settingsFields = 'fields.yaml';

    public $rules = [];
}
