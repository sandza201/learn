<?php

namespace Database\Seeders;

use App\Models\ShipmentContent;
use Illuminate\Database\Seeder;

class ShipmentContentSeeder extends Seeder
{
    public function run(): void
    {
        ShipmentContent::factory()->count(3)->create();
    }
}
