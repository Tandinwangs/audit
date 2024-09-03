<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RatingResource\Pages;
use App\Filament\Resources\RatingResource\RelationManagers;
use App\Models\Engagement;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use PhpParser\Node\Stmt\Label;
use Filament\Tables\Filters\SelectFilter;

class RatingResource extends Resource
{
    protected static ?string $model = Engagement::class;

    protected static ?string $navigationGroup = 'Audit Rating';
     
    protected static ?string $navigationLabel = 'Audit Rating';

    protected static ?string $navigationIcon = 'heroicon-o-star';

    protected ?string $heading = 'Custom Page Subheading';

    protected static ?int $navigationSort = 7;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->columns([
            // Tables\Columns\TextColumn::make('dispatch_number')
            // ->label('Engagement ID')
            //     ->searchable(),
            Tables\Columns\TextColumn::make('address')
            ->label('Auditee')
                ->searchable(),
            Tables\Columns\TextColumn::make('unit')
                ->label('Unit')
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
                ->label('Compliance Check %'),
            Tables\Columns\TextColumn::make('created_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
            Tables\Columns\TextColumn::make('updated_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
        ])
        ->filters([
            SelectFilter::make('created_by')
                ->options([
                    auth()->id() => 'Self',
                ])
                
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
            'index' => Pages\ListRatings::route('/'),
            'create' => Pages\CreateRating::route('/create'),
            // 'edit' => Pages\EditRating::route('/{record}/edit'),
        ];
    }
}
