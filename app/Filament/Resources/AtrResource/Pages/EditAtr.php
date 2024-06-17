<?php

namespace App\Filament\Resources\AtrResource\Pages;

use App\Filament\Resources\AtrResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAtr extends EditRecord
{
    protected static string $resource = AtrResource::class;

    protected static ?string $title = 'Edit ATR';

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
    
    protected function getRedirectUrl(): string{
        return $this->getResource()::getUrl('index');
    }
}
