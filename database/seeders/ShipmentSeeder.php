<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ShipmentSeeder extends Seeder
{
    public function run(): void
    {

        //        // Create 10 parent shipments
        //        Shipment::factory()->count(10)->create();
        //
        //        // Create 20 child shipments with random parent_shipment_id
        //        Shipment::factory()->count(20)->create([
        //            'parent_shipment_id' => Shipment::inRandomOrder()->first()->id,
        //        ]);

        //        Delivery::factory()
        //            ->count(5)
        //            ->has(Shipment::factory()->count(3)) // Each delivery has 3 shipments
        //            ->create();

        Product::factory()->count(10)->create();
    }
}
