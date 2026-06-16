<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseStatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverviewWidget extends BaseStatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Kost', \App\Models\Kost::count()),
            Stat::make('Kost Tersedia', \App\Models\Kost::where('status', 'tersedia')->count()),
            Stat::make('Kost Penuh', \App\Models\Kost::where('status', 'penuh')->count()),
        ];
    }
}
