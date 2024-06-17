<?php

namespace App\Filament\Resources\RatingResource\Pages;

use App\Filament\Resources\RatingResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListRatings extends ListRecords
{
    protected static string $resource = RatingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }

    // protected function getPageTableQuery(): ?Builder
    // {
    //     $query = parent::getPageTableQuery();

    //    $query->where('vertical', 'Customer Experience');

    //     return $query;
    //     dd($query);
    // }
}
