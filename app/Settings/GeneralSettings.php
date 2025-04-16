<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class GeneralSettings extends Settings
{

    public string $app_name;
    public ?string $app_description;
    public bool $app_active;
    public ?string $app_logo;
    public ?string $default_locale;
    public ?string $default_currency;
    public ?string $currency_symbol;
    public ?string $date_format;
    public ?string $time_format;
    public ?string $business_address;
    public ?string $business_phone;
    public ?string $business_email;
    public ?string $primary_color;

    public static function group(): string
    {
        return 'general';
    }
}
