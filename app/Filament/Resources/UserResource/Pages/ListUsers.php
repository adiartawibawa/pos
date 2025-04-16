<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use App\Filament\Resources\UserResource\Widgets\UserRegistrationChart;
use App\Filament\Resources\UserResource\Widgets\UserStatsOverview;
use App\Models\Role;
use Filament\Actions;
use Filament\Pages\Concerns\ExposesTableToWidgets;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListUsers extends ListRecords
{
    use ExposesTableToWidgets;

    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        $tabs = [
            null => Tab::make('All')->label('Semua Pengguna'),
        ];

        $roles = Role::all();

        foreach ($roles as $role) {
            $tabs[$role->name] = Tab::make()
                ->label(ucfirst($role->name))
                ->query(fn(Builder $query) => $query->whereHas('roles', function (Builder $roleQuery) use ($role) {
                    $roleQuery->where('name', $role->name);
                }));
        }

        return $tabs;
    }

    protected function getHeaderWidgets(): array
    {
        return [
            UserStatsOverview::class,
            // UserRegistrationChart::class,
        ];
    }
}
