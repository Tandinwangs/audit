<?php

namespace App\Filament\Widgets\Dashboard;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Engagement;
use App\Models\Issue;

class EngagementCount extends BaseWidget
{
    protected static ?string $pollingInterval = null;

    protected function getStats(): array
    {
        return [
            Stat::make(label: 'Engagement Count', value: Engagement::count())
            ->description(description: 'The total number of engagements.')
            ->color('secondary')
            ->descriptionIcon('heroicon-m-arrow-trending-up')
            // ->chart([2, 10, 3, 6, 10, 13, 1])
            ->extraAttributes([
                'class' => 'cursor-pointer',
                'wire:click' => "\$dispatch('setStatusFilter', { filter: 'processed' })",
            ]),
            Stat::make(label: 'Issues Count', value: Issue::count())
            ->description(description: 'The total number of issues.')
            ->color('success'),
        ];
    }
}
