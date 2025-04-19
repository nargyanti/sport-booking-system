<?php

namespace App\Filament\Widgets;

use App\Models\Expense;
use App\Models\Transaction;
use App\Models\TransactionStatus;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class FinanceOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $acceptedStatusId = TransactionStatus::where('code', 'accepted')->value('id');

        $totalMasuk = Transaction::where('status_id', $acceptedStatusId)->sum('total_paid');
        $totalKeluar = Expense::sum('amount');
        $saldo = $totalMasuk - $totalKeluar;

        return [
            Stat::make('Kas Masuk', 'Rp' . number_format($totalMasuk))
                ->description('Dari transaksi yang diterima')
                ->color('success'),

            Stat::make('Pengeluaran', 'Rp' . number_format($totalKeluar))
                ->description('Semua pengeluaran')
                ->color('danger'),

            Stat::make('Saldo Kas', 'Rp' . number_format($saldo))
                ->description('Saldo saat ini')
                ->color($saldo >= 0 ? 'primary' : 'warning'),
        ];
    }
}
