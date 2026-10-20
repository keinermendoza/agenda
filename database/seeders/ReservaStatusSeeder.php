<?php

namespace Database\Seeders;

use App\Models\ReservaStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReservaStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ReservaStatus::create(['tipo' => 'pendente']);
        ReservaStatus::create(['tipo' => 'confirmado']);
        ReservaStatus::create(['tipo' => 'arte pronta']);
        ReservaStatus::create(['tipo' => 'retiró decoração']);
    }
}
