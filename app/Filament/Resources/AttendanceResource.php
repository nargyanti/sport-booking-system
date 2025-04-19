<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AttendanceResource\Pages;
use App\Filament\Resources\AttendanceResource\RelationManagers;
use App\Models\Attendance;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AttendanceResource extends Resource
{
    protected static ?string $model = Attendance::class;
    protected static ?string $navigationLabel = 'Kehadiran';
    protected static ?string $navigationGroup = 'Manajemen';
    protected static ?string $navigationIcon = 'heroicon-o-check-circle';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('schedule_id')
                ->label('Jadwal')
                ->relationship('schedule', 'date')
                ->searchable()
                ->required(),

            Forms\Components\Select::make('user_id')
                ->label('Pemain')
                ->relationship('user', 'name')
                ->searchable()
                ->required(),

            Forms\Components\Toggle::make('is_present')->label('Hadir'),

            Forms\Components\TimePicker::make('arrival_time')->label('Jam Datang')->nullable(),

            Forms\Components\TimePicker::make('leave_time')->label('Jam Pulang')->nullable(),

            Forms\Components\Textarea::make('note')->label('Catatan')->rows(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('schedule.date')->label('Tanggal'),
            Tables\Columns\TextColumn::make('user.name')->label('Pemain'),
            Tables\Columns\IconColumn::make('is_present')->boolean()->label('Hadir'),
            Tables\Columns\TextColumn::make('arrival_time')->label('Datang'),
            Tables\Columns\TextColumn::make('leave_time')->label('Pulang'),
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
            'index' => Pages\ListAttendances::route('/'),
            'create' => Pages\CreateAttendance::route('/create'),
            'edit' => Pages\EditAttendance::route('/{record}/edit'),
        ];
    }
}
