<?php

namespace App\Filament\Resources\EngagementResource\RelationManagers;

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
use Filament\Tables\Columns\ToggleColumn;

class IssuesRelationManager extends RelationManager
{
    protected static string $relationship = 'issues';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
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
                        if($state === 'Pending'){
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
                ->label('Add to ATR(escaled to EMC?)')
                ->onColor('success')
                ->offColor('gray'),

                Forms\Components\Toggle::make('emc')
                ->label('To be escaled')
                ->onColor('success')
                ->offColor('gray'),

            ]);
    }

    public function table(Table $table): Table
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
                Tables\Columns\TextColumn::make('status'),
                Tables\Columns\TextColumn::make('response'),
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
                // SelectFilter::make('risk_type')
                // ->options([
                //     1 => 'Active',
                //     0 => 'In-active',
                // ])
                SelectFilter::make('risk_type')
                    ->options(StaticDataHelper::getData()['risk_type']),
                SelectFilter::make('issue_type')
                    ->searchable()
                    ->options(StaticDataHelper::getData()['issue_type']),
                // SelectFilter::make('status')
                //     ->searchable()
                //     ->options(StaticDataHelper::getData()['status'])
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make('Edit')
                    ->url(fn($record): string => url('admin/issues/'.$record->id.'/edit'))
                    ->color('secondary'),
                Tables\Actions\DeleteAction::make()
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
