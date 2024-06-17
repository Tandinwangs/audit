<?php

namespace App\Filament\Resources\AuditYearResource\Pages;

use App\Filament\Resources\AuditYearResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAuditYear extends EditRecord
{
    protected static string $resource = AuditYearResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
