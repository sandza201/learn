<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\OrderContent;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class OrderContentFactory extends Factory
{
    protected $model = OrderContent::class;

    public function definition(): array
    {
        return [
            'quantity' => $this->faker->randomNumber(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'order_id' => Order::factory(),
            'product_id' => Product::factory(),
        ];
    }
}
