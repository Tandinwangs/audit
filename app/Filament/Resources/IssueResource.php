<?php

namespace App\Filament\Resources;

use App\Filament\Resources\IssueResource\Pages;
use App\Filament\Resources\IssueResource\RelationManagers;
use App\Models\Issue;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Helpers\StaticDataHelper;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use App\Models\Engagement;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Notifications\Notification;

class IssueResource extends Resource
{
    protected static ?string $model = Issue::class;

    protected static ?string $navigationIcon = 'heroicon-o-list-bullet';

    protected static ?string $navigationGroup = 'Master';

    protected static ?string $navigationLabel = 'Audit Rating';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        $recipient = auth()->user();
 
        return $form
            ->schema([
                Forms\Components\Select::make('engagement_id')
                ->options(
                    Engagement::all()->pluck('dispatch_number', 'id')->toArray()
                )
                ->required()
                ->label('Engagement ID'),
                Forms\Components\TextInput::make('title')
                    ->required(),
                Forms\Components\TextArea::make('description')
                    ->required(),
                Forms\Components\TextArea::make('remarks')
                    ->required(),
                Forms\Components\Select::make('risk_type')
                    ->required()
                    ->searchable()
                    ->options(StaticDataHelper::getData()['risk_type']),
                Forms\Components\Select::make('issue_type')
                    ->required()
                    ->searchable()
                    ->options(StaticDataHelper::getData()['issue_type']),
                Forms\Components\TextArea::make('response')
                    ->required(),
                Forms\Components\Select::make('status')
                    ->required()
                    ->searchable()
                    ->reactive()
                    ->options(StaticDataHelper::getData()['status'])
                    ->afterStateUpdated(function ($state, \Filament\Forms\Set $set) {
                        if($state === 'Pending' || $state === 'Compliance Check'){
                            $set('show', true);
                        }else{
                            $set('show', false);
                        }
                    }),
                Forms\Components\DatePicker::make('completion_date')
                ->label('Completion Date')
                ->visible(function(callable $get){
                    if($get('show') == true){
                        return true;
                    }else{
                        return false;
                    }
                })
                ->required(function(callable $get){
                    if($get('show') == true){
                        return true;
                    }else{
                        return false;
                    }
                }),
                Forms\Components\Toggle::make('atr')
                ->label('Forward to ATR')
                ->onColor('success')
                ->offColor('gray'),

                Forms\Components\Toggle::make('emc')
                ->label('To be escalated')
                ->onColor('success')
                ->offColor('gray'),

            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('description'),
                Tables\Columns\TextColumn::make('remarks'),
                Tables\Columns\TextColumn::make('risk_type'),
                Tables\Columns\TextColumn::make('issue_type'),
                Tables\Columns\TextColumn::make('response'),
                Tables\Columns\TextColumn::make('status'),
                Tables\Columns\TextColumn::make('completion_date'),
                ToggleColumn::make('atr')
                ->disabled(),
                ToggleColumn::make('emc')
                ->disabled(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
            ])
            ->filters([
                SelectFilter::make('risk_type')
                    ->options([
                        'High' => 'High',
                        'Medium' => 'Medium',
                        'Low' => 'Low'
                    ]),
                SelectFilter::make('issue_type')
                    ->searchable()
                    ->options(StaticDataHelper::getData()['issue_type']),
                SelectFilter::make('status')
                    ->searchable()
                    ->options(StaticDataHelper::getData()['status'])
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                ->color('secondary'),
                Tables\Actions\DeleteAction::make()
                    ->requiresConfirmation(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->requiresConfirmation()
                ])
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\ResponsesRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListIssues::route('/'),
            'create' => Pages\CreateIssue::route('/create'),
            'edit' => Pages\EditIssue::route('/{record}/edit'),
        ];
    }
}
