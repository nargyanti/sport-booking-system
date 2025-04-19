<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ScheduleResource\Pages;
use App\Models\Schedule;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ScheduleResource extends Resource
{
    protected static ?string $model = Schedule::class;
    protected static ?string $navigationLabel = 'Jadwal';
    protected static ?string $navigationGroup = 'Manajemen';
    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\DatePicker::make('date')->label('Tanggal')->required(),
                Forms\Components\TimePicker::make('start_time')->label('Jam Mulai')->required(),
                Forms\Components\TimePicker::make('end_time')->label('Jam Selesai')->nullable(),
                Forms\Components\TextInput::make('location')->label('Lokasi')->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('date')->label('Tanggal')->sortable(),
                Tables\Columns\TextColumn::make('start_time')->label('Mulai'),
                Tables\Columns\TextColumn::make('end_time')->label('Selesai'),
                Tables\Columns\TextColumn::make('location')->label('Lokasi'),
                Tables\Columns\TextColumn::make('created_at')->label('Dibuat')->dateTime()->toggleable(),
            ])
            ->defaultSort('date', 'desc')
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
            'index' => Pages\ListSchedules::route('/'),
            'create' => Pages\CreateSchedule::route('/create'),
            'edit' => Pages\EditSchedule::route('/{record}/edit'),
            // 'generate-bills' => GenerateBills::route('/{record}/generate-bills'),
        ];
    }
}
