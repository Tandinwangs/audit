<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReportResource\Pages;
use App\Filament\Resources\ReportResource\RelationManagers;
use App\Models\Report;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Models\Engagement;
use Filament\Tables\Actions\Action;
use Illuminate\Support\Facades\Storage;

class ReportResource extends Resource
{
    protected static ?string $model = Report::class;

    protected static ?string $navigationLabel = 'Report Upload';

    protected static ?string $navigationGroup = 'Master';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    
    protected static ?int $navigationSort = 8;


    public static function form(Form $form): Form
    {
        $engagementIdsInReports = Report::pluck('engagement_id')->toArray();

        // Get the dispatch numbers for engagements that are not in the Report table
        $engagementOptions = Engagement::whereNotIn('id', $engagementIdsInReports)
            ->pluck('dispatch_number', 'id')
            ->toArray()
            ;
        return $form
            ->schema([
                Forms\Components\Select::make('engagement_id')
                ->options($engagementOptions)
                ->required()
                ->label('Engagement ID')
                ->hidden(fn(string $operation): bool => $operation === 'edit'),
                Forms\Components\FileUpload::make('mom')->label("MOM")
                ->preserveFilenames(),
                Forms\Components\FileUpload::make('final_report')->label("Final Report")
                ->preserveFilenames()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('engagement.dispatch_number'),
                Tables\Columns\TextColumn::make('mom'),
                Tables\Columns\TextColumn::make('final_report')
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                Action::make('mom')
                ->action(function (Report $record) {
                    return ReportResource::downloadFile($record->mom); 
                })
                ->visible(function (Report $record) {
                    return isset($record->mom);
                })
                ->icon('heroicon-m-eye')
                ->color('secondary'),

                Action::make('final_report')
                ->action(function (Report $record) {
                    return ReportResource::downloadFile($record->final_report); 
                })
                ->visible(function (Report $record) {
                    return isset($record->final_report);
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
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListReports::route('/'),
            'create' => Pages\CreateReport::route('/create'),
            'edit' => Pages\EditReport::route('/{record}/edit'),
        ];
    }
}
