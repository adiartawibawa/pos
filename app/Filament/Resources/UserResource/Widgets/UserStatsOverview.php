<?php

namespace App\Filament\Resources\UserResource\Widgets;

use App\Filament\Resources\UserResource\Pages\ListUsers;
use App\Models\User;
use Carbon\Carbon;
use Filament\Widgets\Concerns\InteractsWithPageTable;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class UserStatsOverview extends BaseWidget
{
    use InteractsWithPageTable;

    // Menentukan polling interval jika diperlukan
    protected static ?string $pollingInterval = null;

    // Mendapatkan halaman tabel yang digunakan untuk widget
    protected function getTablePage(): string
    {
        return ListUsers::class;
    }

    // Mendapatkan statistik untuk ditampilkan di widget
    protected function getStats(): array
    {
        $now = now();
        $baseQuery = $this->getPageTableQuery(); // Mengambil query halaman tabel

        return [
            // Statistik total pengguna
            Stat::make('Total Pengguna', (clone $baseQuery)->count())
                ->description('Jumlah pengguna aktif')
                ->color('success'),
            Stat::make(
                'Pengguna Baru Bulan Ini',
                (clone $baseQuery)
                    ->whereMonth('created_at', $now->month) // Filter berdasarkan bulan ini
                    ->whereYear('created_at', $now->year)  // Filter berdasarkan tahun ini
                    ->count()
            )->description("Pendaftaran bulan ini ({$now->format('F')})")
                ->color('info'),

            // Statistik pengguna yang belum memverifikasi email
            Stat::make('Belum Verifikasi Email', (clone $baseQuery)->whereNull('email_verified_at')->count())
                ->description('Belum verifikasi email')
                ->color('danger'),
        ];
    }
}
