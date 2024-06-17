<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ResponseResource\Pages;
use App\Filament\Resources\ResponseResource\RelationManagers;
use App\Models\Response;
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
use App\Models\Issue;

class ResponseResource extends Resource
{
    protected static ?string $model = Response::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-bottom-center-text';

    protected static ?string $navigationGroup = 'Master';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('issue_id')
                ->options(
                    Issue::all()->pluck('title', 'id')->toArray()
                )
                ->required()
                ->label('Issue Title'),
                Forms\Components\TextArea::make('decision_taken')
                    ->required(),
                Forms\Components\Select::make('meeting_type')
                    ->required()
                    ->searchable()
                    ->options(StaticDataHelper::getData()['meeting_type']),
                Forms\Components\DatePicker::make('meeting_date')
                    ->required(),
                Forms\Components\Select::make('status')
                    ->required()
                    ->options(StaticDataHelper::getData()['status']),
                Forms\Components\FileUpload::make('files')->label("Files")
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('decision_taken'),
                Tables\Columns\TextColumn::make('meeting_type'),
                Tables\Columns\TextColumn::make('meeting_date'),
                Tables\Columns\TextColumn::make('status'),
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
                SelectFilter::make('meeting_type')
                    ->searchable()
                    ->options(StaticDataHelper::getData()['meeting_type']),
                SelectFilter::make('status')
                    ->searchable()
                    ->options(StaticDataHelper::getData()['status'])
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                ->color('secondary'),
                Tables\Actions\DeleteAction::make()
                    ->requiresConfirmation()
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListResponses::route('/'),
            'create' => Pages\CreateResponse::route('/create'),
            'edit' => Pages\EditResponse::route('/{record}/edit'),
        ];
    }
}
