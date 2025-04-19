<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\BillComponent;

class BillComponentSeeder extends Seeder
{
    public function run(): void
    {
        BillComponent::insert([
            ['name' => 'Lapangan', 'code' => 'court'],
            ['name' => 'Kas', 'code' => 'community_fee'],
        ]);
    }
}
