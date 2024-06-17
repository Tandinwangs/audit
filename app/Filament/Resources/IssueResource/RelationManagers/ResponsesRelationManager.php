<?php

namespace App\Filament\Resources\IssueResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Helpers\StaticDataHelper;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Actions\Action;
use App\Models\Response;
use Illuminate\Support\Facades\Storage;

class ResponsesRelationManager extends RelationManager
{
    protected static string $relationship = 'responses';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
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

    public function table(Table $table): Table
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
                Tables\Actions\ActionGroup::make([
                Action::make('files')
                ->action(function (Response $record) {
                    return ResponsesRelationManager::downloadFile($record->files); 
                })
                ->visible(function (Response $record) {
                    return isset($record->files);
                })
                ->icon('heroicon-m-eye')
                ->color('secondary'),

                Tables\Actions\EditAction::make()
                ->color('secondary'),

                Tables\Actions\DeleteAction::make()
                    ->requiresConfirmation(),  
            ])
            ])  
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])

            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->requiresConfirmation()
                ])
            ]);
    }
    public static function downloadFile($record)
    {
        // Use Storage::url to generate the proper URL for the file
        $filePath = 'public/' . $record; // assuming 'public' is the disk name

        // Check if the file exists in storage
        if (!Storage::exists($filePath)) {
            abort(404, 'File not found');
        }
    
        return Storage::download($filePath);
    }

}
