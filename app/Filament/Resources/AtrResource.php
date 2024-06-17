<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AtrResource\Pages;
use App\Filament\Resources\IssueResource\RelationManagers;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Models\Issue;
use Filament\Tables\Filters\SelectFilter;
use App\Helpers\StaticDataHelper;
use App\Models\Engagement;
use Filament\Tables\Columns\ToggleColumn;

class AtrResource extends Resource
{
    protected static ?string $model = Issue::class;

    protected static ?string $navigationLabel = 'ATR';
    
    protected static ?string $navigationGroup = 'Master';

    protected static ?string $navigationIcon = 'heroicon-o-arrow-top-right-on-square';

    protected static ?int $navigationSort = 4;   


    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('status', 'Compliance Check')->orWhere('status', 'Pending');;
    }

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Forms\Components\Select::make('engagement_id')
            ->options(
                Engagement::all()->pluck('dispatch_number', 'id')->toArray()
            )
            ->required()
            ->label('Dispatch No'),
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
            Forms\Components\Select::make('status')
                ->required()
                ->searchable()
                ->options(StaticDataHelper::getData()['status'])
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->columns([
            Tables\Columns\TextColumn::make('title')
                ->searchable(),
            Tables\Columns\TextColumn::make('description'),
            Tables\Columns\TextColumn::make('remarks'),
            Tables\Columns\TextColumn::make('risk_type'),
            Tables\Columns\TextColumn::make('issue_type'),
            Tables\Columns\TextColumn::make('status'),
            Tables\Columns\TextColumn::make('completion_date')
            ->label('Completion Date'),
            ToggleColumn::make('atr')
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
                SelectFilter::make('atr')->label('Forward to ATR')
                ->options([
                    0 => 'No',
                    1 => 'Yes'
                ])
            ])
            ->actions([
                // Tables\Actions\EditAction::make()
                // ->color('secondary'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListAtrs::route('/'),
            'create' => Pages\CreateAtr::route('/create'),
            // 'edit' => Pages\EditAtr::route('/{record}/edit'),
        ];
    }
}
