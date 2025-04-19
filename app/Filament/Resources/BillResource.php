<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BillResource\Pages;
use App\Filament\Resources\BillResource\RelationManagers;
use App\Models\Bill;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BillResource extends Resource
{
    protected static ?string $model = Bill::class;
    protected static ?string $navigationLabel = 'Tagihan';
    protected static ?string $navigationGroup = 'Manajemen';
    protected static ?string $navigationIcon = 'heroicon-o-receipt-refund';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('user_id')
                ->label('Pemain')
                ->relationship('user', 'name')
                ->searchable()
                ->required(),

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
                ->label('Nominal Awal')
                ->numeric()
                ->required(),

            Forms\Components\Toggle::make('is_custom')->label('Custom?'),

            Forms\Components\TextInput::make('custom_amount')
                ->label('Nominal Custom')
                ->numeric()
                ->nullable(),

            Forms\Components\Toggle::make('is_paid')->label('Sudah Dibayar?'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('schedule.date')->label('Tanggal'),
            Tables\Columns\TextColumn::make('user.name')->label('Pemain'),
            Tables\Columns\TextColumn::make('componentType.name')->label('Komponen'),
            Tables\Columns\TextColumn::make('amount')->label('Tagihan'),
            Tables\Columns\BooleanColumn::make('is_custom')->label('Custom'),
            Tables\Columns\TextColumn::make('custom_amount')->label('Nominal Custom')->money('IDR'),
            Tables\Columns\BooleanColumn::make('is_paid')->label('Lunas'),
        ])
            ->filters([])
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
            'index' => Pages\ListBills::route('/'),
            'create' => Pages\CreateBill::route('/create'),
            'edit' => Pages\EditBill::route('/{record}/edit'),
        ];
    }
}
