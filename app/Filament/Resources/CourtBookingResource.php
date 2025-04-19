<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CourtBookingResource\Pages;
use App\Filament\Resources\CourtBookingResource\RelationManagers;
use App\Models\CourtBooking;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CourtBookingResource extends Resource
{
    protected static ?string $model = CourtBooking::class;
    protected static ?string $navigationLabel = 'Data Lapangan';
    protected static ?string $navigationGroup = 'Manajemen';
    protected static ?string $navigationIcon = 'heroicon-o-map-pin';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('schedule_id')
                ->label('Jadwal')
                ->relationship('schedule', 'date')
                ->searchable()
                ->required(),

            Forms\Components\TextInput::make('court_name')
                ->label('Nama Lapangan')
                ->required(),

            Forms\Components\TimePicker::make('start_time')
                ->label('Jam Mulai')
                ->required(),

            Forms\Components\TimePicker::make('end_time')
                ->label('Jam Selesai')
                ->required(),

            Forms\Components\TextInput::make('cost')
                ->label('Biaya')
                ->prefix('Rp')
                ->numeric()
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('schedule.date')->label('Tanggal'),
            Tables\Columns\TextColumn::make('court_name')->label('Lapangan'),
            Tables\Columns\TextColumn::make('start_time')->label('Mulai'),
            Tables\Columns\TextColumn::make('end_time')->label('Selesai'),
            Tables\Columns\TextColumn::make('cost')->label('Biaya')->money('IDR'),
        ])->filters([])
            ->actions([Tables\Actions\EditAction::make()])
            ->bulkActions([Tables\Actions\DeleteBulkAction::make()]);
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
            'index' => Pages\ListCourtBookings::route('/'),
            'create' => Pages\CreateCourtBooking::route('/create'),
            'edit' => Pages\EditCourtBooking::route('/{record}/edit'),
        ];
    }
}
