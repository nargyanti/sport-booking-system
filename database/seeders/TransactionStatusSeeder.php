<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TransactionStatus;

class TransactionStatusSeeder extends Seeder
{
    public function run(): void
    {
        TransactionStatus::insert([
            ['name' => 'Pending', 'code' => 'pending'],
            ['name' => 'Diterima', 'code' => 'accepted'],
            ['name' => 'Ditolak', 'code' => 'rejected'],
        ]);
    }
}
