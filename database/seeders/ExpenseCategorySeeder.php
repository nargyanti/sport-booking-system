<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ExpenseCategory;

class ExpenseCategorySeeder extends Seeder
{
    public function run(): void
    {
        ExpenseCategory::insert([
            ['name' => 'Shuttlecock', 'code' => 'shuttlecock'],
            ['name' => 'DP Lapangan', 'code' => 'court_deposit'],
            ['name' => 'Lainnya', 'code' => 'other'],
        ]);
    }
}
