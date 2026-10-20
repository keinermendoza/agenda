<?php

namespace Database\Factories;

use App\Models\Reserva;
use App\Models\ReservaStatus;
use App\Models\Cliente;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Reserva>
 */
class ReservaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $começo = fake()->dateTimeBetween('now', '2 month');
        $preço = fake()->randomElement([55, 60, 85, 95, 110, 135]);

        $status = ReservaStatus::inRandomOrder()->first();
        $valor_pago = 0;
        if ($status->tipo != 'pendente')
        {
            $valor_pago = $preço / 2;
        }
        return [
            'começo' => $começo,
            'fim' => fake()->dateTimeBetween($começo, (clone $começo)->modify('+2 days')),
            'preço' => $preço,
            'valor_pago' => $valor_pago,
            'reserva_status_id' => $status->id,
            'personalizado' => fake()->boolean(),
            'cliente_id' => Cliente::inRandomOrder()->first()->id
        ];
    }
}
