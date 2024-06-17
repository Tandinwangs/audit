<?php

namespace App\Filament\Resources\AuditYearResource\Pages;

use App\Filament\Resources\AuditYearResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAuditYears extends ListRecords
{
    protected static string $resource = AuditYearResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}
