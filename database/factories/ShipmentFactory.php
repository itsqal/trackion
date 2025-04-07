<?php

namespace Database\Factories;

use App\Models\Truck;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Shipment>
 */
class ShipmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'truck_id' => Truck::factory(),
            'delivery_order_price' => fake()->numberBetween(1000000, 10000000),
            'client' => fake()->company(),
            'load_type' => fake()->randomElement(['retail', 'electronics', 'furniture', 'machines', 'foods']),
            'departure_waybill_number' => fake()->numerify('TUC-####-####'),
            'return_waybill_number' => fake()->numerify('RET-####-####'),
            'departure_latitude' => fake()->latitude(),
            'departure_longitude' => fake()->longitude(),
            'status' => fake()->randomElement(['perjalanan', 'selesai'])
        ];
    }
}