<?php

namespace App\Filament\Widgets;

use App\Models\Expense;
use App\Models\Transaction;
use App\Models\TransactionStatus;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;

class WeeklyFinanceChart extends ChartWidget
{
    protected static ?string $heading = 'Histori Kas per Minggu';
    protected static ?string $pollingInterval = null;
    protected static ?string $maxHeight = '300px';
    protected int|string|array $columnSpan = 'full';

    protected function getData(): array
    {
        $acceptedStatusId = TransactionStatus::where('code', 'accepted')->value('id');

        $weeks = collect(range(0, 7))->map(function ($i) use ($acceptedStatusId) {
            $start = Carbon::now()->startOfWeek()->subWeeks($i);
            $end = $start->copy()->endOfWeek();

            $income = Transaction::where('status_id', $acceptedStatusId)
                ->whereBetween('created_at', [$start, $end])
                ->sum('total_paid');

            $expense = Expense::whereBetween('created_at', [$start, $end])
                ->sum('amount');

            return [
                'label' => $start->format('d M') . ' - ' . $end->format('d M'),
                'income' => $income,
                'expense' => $expense,
                'net' => $income - $expense,
            ];
        })->reverse()->values();

        return [
            'datasets' => [
                [
                    'label' => 'Kas Masuk',
                    'data' => $weeks->pluck('income'),
                    'borderColor' => 'rgb(34 197 94)', // green
                    'backgroundColor' => 'rgba(34,197,94,0.2)',
                ],
                [
                    'label' => 'Pengeluaran',
                    'data' => $weeks->pluck('expense'),
                    'borderColor' => 'rgb(239 68 68)', // red
                    'backgroundColor' => 'rgba(239,68,68,0.2)',
                ],
                [
                    'label' => 'Saldo Bersih',
                    'data' => $weeks->pluck('net'),
                    'borderColor' => 'rgb(59 130 246)', // blue
                    'backgroundColor' => 'rgba(59,130,246,0.2)',
                ],
            ],
            'labels' => $weeks->pluck('label')->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
