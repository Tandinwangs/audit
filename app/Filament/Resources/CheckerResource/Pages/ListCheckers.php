<?php

namespace App\Filament\Resources\CheckerResource\Pages;

use App\Filament\Resources\CheckerResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\CreateRecord;
use Closure;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\Textarea;

class ListCheckers extends CreateRecord
{
    protected static string $resource = CheckerResource::class;
    
    protected static bool $canCreateAnother = false;

    protected static bool $canCancel = false;
    

    protected function getHeaderActions(): array
    {
    //     return [
    //         CreateAction::make(),
    //         Actions\Action::make('checker')
    //         ->label('Check Now')
    //         ->form([
    //             TextInput::make('audit_issues')
    //                 ->label('Enter TOTAL numbers of audit issues')
    //                 ->afterStateUpdated(function ($state, \Filament\Forms\Set $set) {
    //                     $auditIssues = $state;
    //                     $set('audit_issues', $auditIssues);
    //                 })
    //                 ->required()
    //                 ->reactive(),
    //             TextInput::make('high_issues')
    //                 ->label('Enter numbers of High issues')
    //                 ->afterStateUpdated(function ($state, \Filament\Forms\Get $get, \Filament\Forms\Set $set, ) {
    //                     $highIssues = $state;
    //                     $auditIssues = $get('audit_issues');
    //                     $result = $auditIssues/$highIssues;

    //                     $percentageHigh = ($highIssues / $auditIssues) * 100;

    //                     if ($percentageHigh < 33) {
    //                         $opinion = 'Effective';
    //                     } elseif($percentageHigh >= 33 && $percentageHigh < 50){
    //                         $opinion = 'Some improvement Needed';
    //                     }elseif($percentageHigh >= 50 && $percentageHigh < 100) {
    //                         $opinion = 'Major Improvement Needed';
    //                     }else{
    //                         $opinion = 'Unsatisfactory';
    //                     }

    //                     $set('result', $opinion);

    //                 })
    //                 ->required()
    //                 ->reactive(),
    //             Textarea::make('result')
    //             ->readOnly()
    //             ->placeholder('placeHolder')
    //         ])
    // ];

    return [

    ];
    }
}
