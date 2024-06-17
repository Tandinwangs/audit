<?php

namespace App\Filament\Resources\CheckerResource\Pages;

use App\Filament\Resources\CheckerResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateChecker extends CreateRecord
{
    protected static string $resource = CheckerResource::class;

    protected static bool $canCreateAnother = false;

    protected static bool $canCancel = false;

}
