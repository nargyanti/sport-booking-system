<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SubsidyResource\Pages;
use App\Filament\Resources\SubsidyResource\RelationManagers;
use App\Models\Subsidy;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SubsidyResource extends Resource
{
    protected static ?string $model = Subsidy::class;
    protected static ?string $navigationLabel = 'Subsidi';
    protected static ?string $navigationGroup = 'Keuangan';
    protected static ?string $navigationIcon = 'heroicon-o-gift';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('schedule_id')
                ->label('Jadwal')
                ->relationship('schedule', 'date')
                ->searchable()
                ->required(),

            Forms\Components\Select::make('component_type_id')
                ->label('Komponen')
                ->relationship('componentType', 'name')
                ->searchable()
                ->required(),

            Forms\Components\TextInput::make('amount')
                ->label('Jumlah Subsidi')
                ->prefix('Rp')
                ->numeric()
                ->required(),

            Forms\Components\Select::make('paid_by_user_id')
                ->label('Ditraktir Oleh')
                ->relationship('paidBy', 'name')
                ->searchable()
                ->required(),

            Forms\Components\Textarea::make('note')
                ->label('Catatan (opsional)')
                ->rows(2)
                ->nullable(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('schedule.date')->label('Jadwal'),
            Tables\Columns\TextColumn::make('componentType.name')->label('Komponen'),
            Tables\Columns\TextColumn::make('amount')->label('Subsidi')->money('IDR'),
            Tables\Columns\TextColumn::make('paidBy.name')->label('Ditraktir Oleh'),
            Tables\Columns\TextColumn::make('note')->label('Catatan')->limit(20),
        ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListSubsidies::route('/'),
            'create' => Pages\CreateSubsidy::route('/create'),
            'edit' => Pages\EditSubsidy::route('/{record}/edit'),
        ];
    }
}
