<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EngagementResource\Pages;
use App\Filament\Resources\EngagementResource\RelationManagers;
use App\Models\Engagement;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Helpers\StaticDataHelper;
use App\Services\EngagementService;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Forms\Get;
use Filament\Tables\Actions\Action;
use Illuminate\Support\Facades\Storage;

class EngagementResource extends Resource
{
    protected static ?string $model = Engagement::class;

    protected static ?string $navigationLabel = 'Engagement ID';

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static ?string $navigationGroup = 'Master';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('dispatch_number')
                    ->required()
                    ->label('Engagement ID')
                    ->readOnly(),
                Forms\Components\Select::make('address')
                    ->options(StaticDataHelper::getData()['address'])
                    ->reactive()
                    ->searchable()
                    ->afterStateUpdated(function ($state, $record, \Filament\Forms\Set $set) {
                        $engagementService = new EngagementService();
                        $dispatchNumber = $engagementService->generateDispatchNumber($state, $record ? $record->id : '');
                        $set('dispatch_number', $dispatchNumber);
                    })
                    ->required(),     
                Forms\Components\Select::make('unit')
                    ->options(StaticDataHelper::getData()['unit'])
                    ->reactive()
                    ->afterStateUpdated(function ($state, \Filament\Forms\Set $set) {
                        $engagementService = new EngagementService();
                        $vertical = $engagementService->getVertical($state);
                        $set('vertical', $vertical);
                    })
                    ->required(),
                 Forms\Components\TextInput::make('vertical')
                 ->readOnly()
                 ->required(),
                Forms\Components\DatePicker::make('coverage_start_date')
                    ->label('Period Coverage(Start Date)')
                    ->required(),
                Forms\Components\DatePicker::make('coverage_end_date')
                    ->label('Period Coverage(End Date)')
                    ->required(),
                Forms\Components\DatePicker::make('start_date')
                    ->label('Engagement Start Date')
                    ->required(),
                Forms\Components\DatePicker::make('end_date')
                    ->label('Engagement End Date')
                    ->required(),
                // Forms\Components\FileUpload::make('memo')
                //     ->hidden(fn(string $operation): bool => $operation === 'create'),
                Forms\Components\FileUpload::make('letter')->label("Engagement Letter")
                    ->hidden(fn(string $operation): bool => $operation === 'create')
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('dispatch_number')
                ->label('Engagement ID')
                    ->searchable(),
                Tables\Columns\TextColumn::make('address')
                    ->searchable(),
                Tables\Columns\TextColumn::make('unit')
                    ->searchable(),
                Tables\Columns\TextColumn::make('vertical')
                    ->searchable(),
                Tables\Columns\TextColumn::make('coverage_start_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('coverage_end_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('start_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('end_date')
                    ->date()
                    ->sortable(),
             
                // Tables\Columns\TextColumn::make('created_by')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('edited_by')
                //     ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            //         Tables\Columns\TextColumn::make('letter')
            //         ->searchable(),
            //     Tables\Columns\TextColumn::make('memo')
            //   ,
            ])
            ->filters([
                SelectFilter::make('address')
                    ->searchable()
                    ->options(StaticDataHelper::getData()['address']),
                SelectFilter::make('vertical')
                    ->searchable()
                    ->options(StaticDataHelper::getData()['vertical']),
                SelectFilter::make('unit')
                    ->searchable()
                    ->options(StaticDataHelper::getData()['unit'])
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                Action::make('Letter')
                ->action(function (Engagement $record) {
                    return EngagementResource::downloadFile($record->letter); 
                })
                ->visible(function (Engagement $record) {
                    return isset($record->letter);
                })
                ->icon('heroicon-m-eye')
                ->color('secondary'),

                Action::make('Memo')
                ->action(function (Engagement $record) {
                    return EngagementResource::downloadFile($record->memo); 
                })
                ->visible(function (Engagement $record) {
                    return isset($record->memo);
                })
                ->icon('heroicon-m-eye')
                ->color('secondary'),
                Tables\Actions\EditAction::make()
                ->color('secondary'),
                Tables\Actions\DeleteAction::make()
                    ->requiresConfirmation(),  
            ])
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
            RelationManagers\IssuesRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEngagements::route('/'),
            'create' => Pages\CreateEngagement::route('/create'),
            'edit' => Pages\EditEngagement::route('/{record}/edit'),
        ];
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

     
    protected function getTableQuery(): Builder
    {
        return parent::getTableQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
