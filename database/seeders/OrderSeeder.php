<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderContent;
use App\Models\Product;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        Order::factory()
            ->count(50)
            ->has(OrderContent::factory()
                ->count(5)
                ->has(Product::factory())
            )
            ->create();
    }
}
