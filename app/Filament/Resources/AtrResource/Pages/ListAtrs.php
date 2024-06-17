<?php

namespace App\Filament\Resources\AtrResource\Pages;

use App\Filament\Resources\AtrResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Forms\Components\Builder;

class ListAtrs extends ListRecords
{
    protected static string $resource = AtrResource::class;

    protected static ?string $title = ('ATR');

    protected static ?string $color = '#252D60';
    

    // protected function getHeaderActions(): array
    // {
    //     return [
    //         Actions\CreateAction::make(),
    //     ];
    // }


}
