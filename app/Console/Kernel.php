<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\Issue;
use App\Notifications\IssueDueNotification;
use Carbon\Carbon;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Log;
use Chiiya\FilamentAccessControl\Models\FilamentUser;
use Illuminate\Support\Facades\Auth;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->call(function () {
            Log::info('Scheduled task started');

            try {
                $tomorrow = Carbon::tomorrow()->format('Y-m-d');
                $issues = Issue::where('completion_date', $tomorrow)->get();

                Log::info("Found {$issues->count()} issues due tomorrow");

                foreach ($issues as $issue) {
                    // Assuming you want to send this notification to all users
                    $users = FilamentUser::all();

                    foreach ($users as $user) {
                        Notification::make()
                            ->title('Issue Due Tomorrow')
                            ->icon('heroicon-o-exclamation-circle')
                            ->body("The issue **{$issue->title}** is due tomorrow.")
                            ->sendToDatabase($user);

                        Log::info("Notification sent for issue: {$issue->id} to user: {$user->id}");
                    }
                }
            } catch (\Exception $e) {
                Log::error("Error in scheduled task: " . $e->getMessage());
            }

            Log::info('Scheduled task ended');
        })->daily(); // For testing purposes, change to daily() in production
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
