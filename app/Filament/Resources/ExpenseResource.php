<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ExpenseResource\Pages;
use App\Filament\Resources\ExpenseResource\RelationManagers;
use App\Models\Expense;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ExpenseResource extends Resource
{
    protected static ?string $model = Expense::class;
    protected static ?string $navigationLabel = 'Pengeluaran Kas';
    protected static ?string $navigationGroup = 'Keuangan';
    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('schedule_id')
                ->label('Terkait Jadwal')
                ->relationship('schedule', 'date')
                ->searchable()
                ->nullable(),

            Forms\Components\Select::make('category_id')
                ->label('Kategori')
                ->relationship('category', 'name')
                ->searchable()
                ->required(),

            Forms\Components\Textarea::make('description')
                ->label('Keterangan')
                ->rows(2)
                ->required(),

            Forms\Components\TextInput::make('amount')
                ->label('Nominal')
                ->prefix('Rp')
                ->numeric()
                ->required(),

            Forms\Components\Select::make('paid_by')
                ->label('Dibayarkan Oleh')
                ->relationship('payer', 'name')
                ->searchable()
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('schedule.date')->label('Jadwal')->sortable(),
            Tables\Columns\TextColumn::make('category.name')->label('Kategori'),
            Tables\Columns\TextColumn::make('description')->label('Keterangan')->limit(30),
            Tables\Columns\TextColumn::make('amount')->label('Nominal')->money('IDR'),
            Tables\Columns\TextColumn::make('payer.name')->label('Dibayar Oleh'),
            Tables\Columns\TextColumn::make('created_at')->label('Waktu')->dateTime(),
        ])->actions([
            Tables\Actions\EditAction::make(),
        ])->bulkActions([
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
            'index' => Pages\ListExpenses::route('/'),
            'create' => Pages\CreateExpense::route('/create'),
            'edit' => Pages\EditExpense::route('/{record}/edit'),
        ];
    }
}
