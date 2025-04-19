<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransactionResource\Pages;
use App\Filament\Resources\TransactionResource\RelationManagers;
use App\Models\Transaction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TransactionResource extends Resource
{
    protected static ?string $model = Transaction::class;
    protected static ?string $navigationLabel = 'Pembayaran';
    protected static ?string $navigationGroup = 'Manajemen';
    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('paid_by_user_id')
                ->label('Dibayar Oleh')
                ->relationship('payer', 'name')
                ->searchable()
                ->required(),

            Forms\Components\Select::make('schedule_id')
                ->label('Untuk Jadwal')
                ->relationship('schedule', 'date')
                ->searchable()
                ->required(),

            Forms\Components\TextInput::make('total_paid')
                ->label('Total Bayar')
                ->numeric()
                ->required(),

            Forms\Components\FileUpload::make('image')
                ->label('Bukti Transfer')
                ->image()
                ->disk('public')
                ->directory('bukti-pembayaran')
                ->required(),

            Forms\Components\Select::make('status_id')
                ->label('Status')
                ->relationship('status', 'name')
                ->required(),

            Forms\Components\Textarea::make('notes')
                ->label('Catatan')
                ->rows(3)
                ->nullable(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('schedule.date')->label('Tanggal'),
            Tables\Columns\TextColumn::make('payer.name')->label('Pembayar'),
            Tables\Columns\TextColumn::make('total_paid')->label('Total')->money('IDR'),
            Tables\Columns\TextColumn::make('status.name')->label('Status'),
            Tables\Columns\ImageColumn::make('image')->label('Bukti'),
            Tables\Columns\TextColumn::make('created_at')->label('Waktu')->dateTime(),
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
            'index' => Pages\ListTransactions::route('/'),
            'create' => Pages\CreateTransaction::route('/create'),
            'edit' => Pages\EditTransaction::route('/{record}/edit'),
        ];
    }
}
