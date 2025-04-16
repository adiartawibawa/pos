<?php

namespace App\Filament\Resources\UserResource\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\User;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class UserRegistrationChart extends ChartWidget
{
    protected static ?string $heading = 'Pendaftaran Pengguna Bulanan';

    protected function getData(): array
    {
        $data = Trend::model(User::class)
            ->dateColumn('created_at')
            ->perMonth()
            ->count();

        return [
            'datasets' => [
                [
                    'label' => 'Pengguna Baru',
                    'data' => $data->map(fn(TrendValue $value) => $value->aggregate)->toArray(),
                    'backgroundColor' => '#36A2EB',
                    'borderColor' => '#36A2EB',
                    'tension' => 0.3,
                ],
            ],
            'labels' => $data->map(fn(TrendValue $value) => date('M Y', strtotime($value->date)))->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'line'; // Anda bisa mengubahnya menjadi 'bar', 'pie', dll.
    }
}
