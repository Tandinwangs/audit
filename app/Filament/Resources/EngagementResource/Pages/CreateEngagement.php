<?php

namespace App\Filament\Resources\EngagementResource\Pages;

use App\Filament\Resources\EngagementResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateEngagement extends CreateRecord
{
    protected static string $resource = EngagementResource::class;

    protected static bool $canCreateAnother = false;
    
    protected function getRedirectUrl(): string{
        return $this->getResource()::getUrl('index');
    }
}
