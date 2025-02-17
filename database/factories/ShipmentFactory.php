<?php

namespace Database\Factories;

use App\Models\Shipment;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ShipmentFactory extends Factory
{
    protected $model = Shipment::class;

    public function definition(): array
    {
        // Randomly choose between 'pallet' and 'parcel'
        $type = $this->faker->randomElement(['pallet', 'parcel']);

        // If the type is 'parcel', assign a random parent_shipment_id (if available)
        $parentShipmentId = null;
        if ($type === 'parcel') {
            $parentShipmentId = Shipment::where('type', 'parcel')->inRandomOrder()->first()?->id;
        }

        return [
            'type' => $type,
            'weight' => $this->faker->randomFloat(2, 0.1, 1000), // Random float with 2 decimal places, between 0.1 and 1000
            'parent_shipment_id' => $parentShipmentId, // Set to null for pallets, or a valid parent for parcels
            'delivery_id' => null,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
