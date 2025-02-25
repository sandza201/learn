<?php

namespace Database\Factories;

use App\Models\ShipmentContent;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ShipmentContentFactory extends Factory
{
    protected $model = ShipmentContent::class;

    public function definition(): array
    {
        return [
            'product_name' => $this->faker->name(),
            'product_id' => $this->faker->randomNumber(),
            'quantity' => $this->faker->word(),
            'weight' => $this->faker->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
