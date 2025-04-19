@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto space-y-6">
        <h2 class="text-xl font-bold">Tagihan {{ $schedule->date }}</h2>

        <ul class="border rounded p-4 bg-white space-y-2">
            @foreach ($bills as $bill)
                <li>
                    {{ $bill->componentType->name }}:
                    Rp{{ number_format($bill->is_custom ? $bill->custom_amount : $bill->amount) }}
                </li>
            @endforeach
        </ul>

        <p class="font-semibold">Total: Rp{{ number_format($total) }}</p>

        <form method="POST" action="{{ route('user.billing.submit', $schedule) }}" enctype="multipart/form-data"
            class="space-y-4">
            @csrf
            <input type="hidden" name="total" value="{{ $total }}">

            <div>
                <label>Bukti Pembayaran (gambar)</label>
                <input type="file" name="image" accept="image/*" required class="block mt-1">
            </div>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
                Kirim Bukti
            </button>
        </form>

        @if (session('success'))
            <div class="text-green-600">{{ session('success') }}</div>
        @endif
    </div>
@endsection
