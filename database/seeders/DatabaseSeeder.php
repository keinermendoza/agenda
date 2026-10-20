<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Cliente;
use App\Models\Endereço;
use App\Models\Reserva;
use App\Models\ReservaStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\ReservaStatusSeeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => '1234'
        ]);


        $clientes = Cliente::factory()->count(10)->create();

        foreach($clientes as $cliente) {
            $endereço = Endereço::factory()->create();
            $endereço->clientes()->attach($cliente->id);
        }

        ReservaStatus::create(['tipo' => 'pendente']);
        ReservaStatus::create(['tipo' => 'confirmado']);
        ReservaStatus::create(['tipo' => 'arte pronta']);
        ReservaStatus::create(['tipo' => 'retiró decoração']);

        Reserva::factory()->count(24)->create();

    }
}
