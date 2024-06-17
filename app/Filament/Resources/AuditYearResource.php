<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AuditYearResource\Pages;
use App\Filament\Resources\AuditYearResource\RelationManagers;
use App\Models\AuditYear;
use App\Models\Engagement;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Carbon\Carbon;

class AuditYearResource extends Resource
{
    protected static ?string $model = Engagement::class;

    protected static ?string $navigationGroup = 'Audit Rating';
     
    protected static ?string $navigationLabel = 'Audit Year';

    protected static ?string $navigationIcon = 'heroicon-o-star';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        $currentYear = Carbon::now()->year;
        return $table
        ->query(Engagement::currentYear())
        ->columns([
            Tables\Columns\TextColumn::make('address')
            ->label('Auditee')
                ->searchable(),
            Tables\Columns\TextColumn::make('year')
                ->label('Year')  
            ,
            // Tables\Columns\TextColumn::make('audit_opinion')
            //     ->label('Audit Opinion'),
            Tables\Columns\TextColumn::make('pending_percentage')
                ->label('Pending %'),
            Tables\Columns\TextColumn::make('resolved_percentage')
                ->label('Resolved %'),
            Tables\Columns\TextColumn::make('compliance_check_percentage')
                ->label('Compliance Check %')
        ])
            ->filters([
                //
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAuditYears::route('/'),
            'create' => Pages\CreateAuditYear::route('/create'),
            'edit' => Pages\EditAuditYear::route('/{record}/edit'),
        ];
    }
}
