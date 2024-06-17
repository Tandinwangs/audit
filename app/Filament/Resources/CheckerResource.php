<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CheckerResource\Pages;
use App\Filament\Resources\CheckerResource\RelationManagers;
use App\Models\OpinionChecker;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\ComponentContainer;
use Filament\Infolists\Components\TextEntry;
use Illuminate\Support\HtmlString;

class CheckerResource extends Resource
{
    protected static ?string $model = OpinionChecker::class;

    protected static ?string $navigationGroup = 'Master';
     
    protected static ?string $navigationLabel = 'Opinion Checker';

    protected static ?string $navigationIcon = 'heroicon-o-calculator';

    protected static ?int $navigationSort = 6;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('audit_issues')
                                ->label('Enter TOTAL numbers of audit issues')
                                ->afterStateUpdated(function ($state, \Filament\Forms\Set $set) {
                                    $auditIssues = $state;
                                    $set('audit_issues', $auditIssues);
                                })
                                ->required()
                                ->reactive(),

                Forms\Components\TextInput::make('high_issues')
                                ->label('Enter numbers of High issues')
                                ->afterStateUpdated(function ($state, \Filament\Forms\Get $get, \Filament\Forms\Set $set, ) {
                                    $highIssues = $state;
                                    $auditIssues = $get('audit_issues');

                                    if($highIssues  == 0){
                                        return;
                                    } else {
                                    $result = $auditIssues/$highIssues;
            
                                    $percentageHigh = ($highIssues / $auditIssues) * 100;
            
                                    if ($percentageHigh < 33) {
                                        $opinion = 'Effective';
                                    } elseif($percentageHigh >= 33 && $percentageHigh < 50){
                                        $opinion = 'Some improvement Needed';
                                    }elseif($percentageHigh >= 50 && $percentageHigh < 100) {
                                        $opinion = 'Major Improvement Needed';
                                    }else{
                                        $opinion = 'Unsatisfactory';
                                    }
                                }

                                    $showText = $opinion;
            
                                    $set('result', $showText);
            
                                })
                                ->required()
                                ->reactive(),
                    Forms\Components\Textarea::make('result')
                                ->readOnly()
                                ->placeholder('The Oppinion will be auto generated'),
                                 
                           
            ]);
    }


    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCheckers::route('/'),
            'create' => Pages\CreateChecker::route('/create'),
            'edit' => Pages\EditChecker::route('/{record}/edit'),
        ];
    }
}
