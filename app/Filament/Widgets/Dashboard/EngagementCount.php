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
        // Calculate the number of solved, pending, and compliance check issues
        $solvedCount = Issue::where('status', 'Resolved')->count();
        $pendingCount = Issue::where('status', 'Pending')->count();
        $complianceCheckCount = Issue::where('status', 'Compliance Check')->count();

        return [
            Stat::make(label: 'Engagement Count', value: Engagement::count())
                ->description('The total number of engagements.')
                ->color('secondary')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->Icon('heroicon-c-folder')
                ->chart([2, 10, 3, 6, 10, 13, 1])
                ->extraAttributes([
                    'class' => 'cursor-pointer',
                    'wire:click' => "\$dispatch('setStatusFilter', { filter: 'processed' })",
                ]),
            Stat::make(label: 'Issues Count', value: Issue::count())
                ->Icon('heroicon-o-list-bullet')
                ->description('The total number of issues.')
                ->color('secondary'),

            Stat::make(label: 'Solved Issues', value: $solvedCount)
                ->description('The total number of issues solved.')
                ->color('secondary')
                ->Icon('heroicon-o-shield-check')
                ->descriptionIcon('heroicon-m-arrow-trending-up'),
            Stat::make(label: 'Pending', value: $pendingCount)
                ->description('The total number of pending issues.')
                ->Icon('heroicon-m-chart-pie')
                ->color('primary')
                ->descriptionIcon('heroicon-m-chart-pie'),
            Stat::make(label: 'Compliance Check', value: $complianceCheckCount)
                ->description('The total number of compliance check issues.')
                ->color('primary')
                ->Icon('heroicon-c-clock')
                ->descriptionIcon('heroicon-m-chart-pie'),

            Stat::make(label: 'Audit Rating', value:"Click Here")
                ->description('To know the Audit Rating')
                ->url('admin/ratings')
                ->color('secondary')
                ->Icon('heroicon-c-pencil')
                // ->descriptionIcon('heroicon-m-chart-pie'),
               
            // Stat::make(label: 'Total Issues', value: Issue::count())
            // ->description(new \Illuminate\Support\HtmlString('
            //         <div style="display: flex; justify-content: space-between;">
            //             <div style="flex: 1; text-align: center;">
            //                 <span style="display: block; font-weight: small; color: green;">Solved</span>
            //                 <span style="font-size: 1.2em;">' . $solvedCount . '</span>
            //             </div>
            //             <div style="flex: 1; text-align: center;">
            //                 <span style="display: block; font-weight: small; color: orange;">Pending</span>
            //                 <span style="font-size: 1.2em;">' . $pendingCount . '</span>
            //             </div>
            //             <div style="flex: 1; text-align: center;">
            //                 <span style="display: block; font-weight: small; color: blue;">Compliance Check</span>
            //                 <span style="font-size: 1.2em;">' . $complianceCheckCount . '</span>
            //             </div>
            //         </div>
            //     '))
            //     ->color('info')
            //     ->descriptionIcon('heroicon-m-chart-pie')
            //     ->chart([1, 2, 3, 4, 5, 6, 7]),
        ];
    }
}
