<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('general.app_name', 'POS it!');
        $this->migrator->add('general.app_description', 'Aplikasi Point of Sale');
        $this->migrator->add('general.app_active', true);
        $this->migrator->add('general.app_logo', null);
        $this->migrator->add('general.default_locale', 'id');
        $this->migrator->add('general.default_currency', 'IDR');
        $this->migrator->add('general.currency_symbol', 'Rp');
        $this->migrator->add('general.date_format', 'Y-m-d');
        $this->migrator->add('general.time_format', 'H:i');
        $this->migrator->add('general.business_address', null);
        $this->migrator->add('general.business_phone', null);
        $this->migrator->add('general.business_email', null);
        $this->migrator->add('general.primary_color', '#22c55e');
    }
};
