<?php

namespace App\Filament\Resources\IssueResource\Pages;

use App\Filament\Resources\IssueResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Events\DatabaseNotificationsSent;
use Filament\Notifications\Notification;

class CreateIssue extends CreateRecord
{
    protected static string $resource = IssueResource::class;

    protected function getRedirectUrl(): string{
        return $this->getResource()::getUrl('index');
    }

    // protected function afterCreate(): void {

    //     $issue = $this->record;

    //     Notification::make()
    //     ->title('New Issue Added')
    //     ->icon('heroicon-o-shopping-bag')
    //     ->body("**New Issue {$issue->title} created!**")
    //     ->sendToDatabase(auth()->user());
    // }

}
