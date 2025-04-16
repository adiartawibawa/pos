<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('mail.mail_mailer', env('MAIL_MAILER', 'smtp'));
        $this->migrator->add('mail.mail_host', env('MAIL_HOST', 'mail.example.com'));
        $this->migrator->add('mail.mail_port', env('MAIL_PORT', 587));
        $this->migrator->add('mail.mail_username', env('MAIL_USERNAME'));
        $this->migrator->add('mail.mail_password', env('MAIL_PASSWORD'));
        $this->migrator->add('mail.mail_encryption', env('MAIL_ENCRYPTION', 'tls'));
        $this->migrator->add('mail.mail_from_address', env('MAIL_FROM_ADDRESS', 'hello@example.com'));
        $this->migrator->add('mail.mail_from_name', env('MAIL_FROM_NAME', 'POS Application'));
    }
};
