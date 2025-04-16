<?php

namespace App\Filament\Pages;

use App\Settings\MailSettings;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Pages\SettingsPage;

class MailSettingsPage extends SettingsPage
{
    protected static ?string $navigationIcon = 'heroicon-o-envelope';
    protected static ?string $navigationLabel = 'Email';
    protected static ?string $navigationGroup = 'Pengaturan';
    protected static ?string $title = 'Pengaturan Email';
    protected static string $settings = MailSettings::class;

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('mail_mailer')
                    ->label('Mailer')
                    ->options([
                        'smtp' => 'SMTP',
                        'mailgun' => 'Mailgun',
                        'ses' => 'Amazon SES',
                        'sendmail' => 'Sendmail',
                        'log' => 'Log',
                        'array' => 'Array',
                        'failover' => 'Failover',
                    ])
                    ->default('smtp'),
                Forms\Components\TextInput::make('mail_host')
                    ->label('Host')
                    ->required(),
                Forms\Components\TextInput::make('mail_port')
                    ->label('Port')
                    ->numeric()
                    ->required(),
                Forms\Components\TextInput::make('mail_username')
                    ->label('Username')
                    ->nullable(),
                Forms\Components\TextInput::make('mail_password')
                    ->label('Password')
                    ->password()
                    ->nullable(),
                Forms\Components\Select::make('mail_encryption')
                    ->label('Enkripsi')
                    ->options([
                        'tls' => 'TLS',
                        'ssl' => 'SSL',
                        null => 'Tanpa Enkripsi',
                    ])
                    ->nullable(),
                Forms\Components\TextInput::make('mail_from_address')
                    ->label('Alamat "Dari"')
                    ->email()
                    ->required(),
                Forms\Components\TextInput::make('mail_from_name')
                    ->label('Nama "Dari"')
                    ->required(),
            ]);
    }
}
