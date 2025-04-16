<?php

namespace App\Filament\Pages;

use App\Settings\GeneralSettings;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Pages\SettingsPage;

class GeneralSettingsPage extends SettingsPage
{
    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static ?string $navigationLabel = 'General';
    protected static ?string $navigationGroup = 'Pengaturan';
    protected static ?string $title = 'Pengaturan Umum';
    protected static string $settings = GeneralSettings::class;

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('app_name')
                    ->label('Nama Aplikasi')
                    ->required(),
                Forms\Components\Textarea::make('app_description')
                    ->label('Deskripsi Aplikasi'),
                Forms\Components\Toggle::make('app_active')
                    ->label('Aplikasi Aktif'),
                Forms\Components\FileUpload::make('app_logo')
                    ->label('Logo Aplikasi')
                    ->image()
                    ->maxSize(2048),
                Forms\Components\Select::make('default_locale')
                    ->label('Bahasa Default')
                    ->options([
                        'id' => 'Indonesia',
                        'en' => 'English',
                        // Tambahkan pilihan bahasa lain
                    ]),
                Forms\Components\TextInput::make('default_currency')
                    ->label('Mata Uang Default')
                    ->maxLength(3),
                Forms\Components\TextInput::make('currency_symbol')
                    ->label('Simbol Mata Uang')
                    ->maxLength(5),
                Forms\Components\TextInput::make('date_format')
                    ->label('Format Tanggal')
                    ->default('Y-m-d'),
                Forms\Components\TextInput::make('time_format')
                    ->label('Format Waktu')
                    ->default('H:i'),
                Forms\Components\Textarea::make('business_address')
                    ->label('Alamat Bisnis'),
                Forms\Components\TextInput::make('business_phone')
                    ->label('Nomor Telepon Bisnis'),
                Forms\Components\TextInput::make('business_email')
                    ->label('Email Bisnis')
                    ->email(),
                Forms\Components\ColorPicker::make('primary_color')
                    ->label('Warna Utama'),
            ]);
    }
}
