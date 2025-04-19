<?php

namespace App\Filament\Resources\ScheduleResource\Pages;

use App\Filament\Resources\ScheduleResource;
use App\Models\Schedule;
use App\Models\Attendance;
use App\Models\Bill;
use App\Models\CourtBooking;
use App\Models\BillComponent;
use Filament\Resources\Pages\Page;
use Filament\Notifications\Notification;

class GenerateBills extends Page
{
    public Schedule $record;

    protected static string $resource = ScheduleResource::class;
    protected static string $view = 'filament.resources.schedule-resource.pages.generate-bills';

    public function mount($record): void
    {
        $this->record = Schedule::findOrFail($record);
    }

    public function generate()
    {
        $schedule = $this->record;

        $attendances = Attendance::where('schedule_id', $schedule->id)
            ->where('is_present', true)
            ->pluck('user_id')
            ->toArray();

        $totalLapangan = CourtBooking::where('schedule_id', $schedule->id)->sum('cost');
        $componentCourt = BillComponent::where('code', 'court')->firstOrFail();
        $componentKas = BillComponent::where('code', 'community_fee')->firstOrFail();

        $kasPerUser = 5000; // contoh tetap, bisa dari field jadwal kalau mau fleksibel
        $count = count($attendances);

        foreach ($attendances as $userId) {
            // Lapangan
            Bill::updateOrCreate(
                ['user_id' => $userId, 'schedule_id' => $schedule->id, 'component_type_id' => $componentCourt->id],
                ['amount' => $count ? $totalLapangan / $count : 0]
            );

            // Kas
            Bill::updateOrCreate(
                ['user_id' => $userId, 'schedule_id' => $schedule->id, 'component_type_id' => $componentKas->id],
                ['amount' => $kasPerUser]
            );
        }

        Notification::make()
            ->title('Tagihan berhasil dibuat!')
            ->success()
            ->send();

        return redirect()->route('filament.admin.resources.schedules.index');
    }
}
