<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\Schedule;
use App\Models\Transaction;
use App\Models\TransactionStatus;
use Illuminate\Http\Request;

class UserBillingController extends Controller
{
    public function show(Schedule $schedule)
    {
        $user = auth()->user();

        $bills = Bill::with('componentType')
            ->where('user_id', $user->id)
            ->where('schedule_id', $schedule->id)
            ->get();

        $total = $bills->sum(fn($bill) => $bill->is_custom ? $bill->custom_amount : $bill->amount);

        return view('user.payment', compact('schedule', 'bills', 'total'));
    }

    public function submitPayment(Request $request, Schedule $schedule)
    {
        $user = auth()->user();

        $request->validate([
            'image' => 'required|image|max:2048',
        ]);

        $imagePath = $request->file('image')->store('bukti-pembayaran', 'public');

        $statusId = TransactionStatus::where('code', 'pending')->value('id');

        $transaction = Transaction::create([
            'paid_by_user_id' => $user->id,
            'schedule_id' => $schedule->id,
            'total_paid' => $request->input('total'),
            'image' => $imagePath,
            'status_id' => $statusId,
        ]);

        $userBillIds = Bill::where('user_id', $user->id)
            ->where('schedule_id', $schedule->id)
            ->pluck('id')
            ->toArray();

        $transaction->bills()->sync($userBillIds);

        return redirect()->back()->with('success', 'Bukti pembayaran berhasil dikirim. Menunggu konfirmasi admin.');
    }
}
