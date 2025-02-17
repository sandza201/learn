<?php

namespace App\Http\Controllers;

use App\Models\Delivery;
use Illuminate\Http\Request;

class ShipmentController extends Controller
{
    // Display the form
    public function create()
    {
        // Retrieve parcels and pallets from the session (or initialize empty arrays)
        $delivery = Delivery::with('shipments.parcels')->find(3);

        $parcels = $delivery->shipments()->where('type', 'parcel')->with('pallet')->get();
        $pallets = $delivery->shipments()->where('type', 'pallet')->with('parcels')->get();
//        dd($parcels, $pallets);

        return view('shipment.create', compact('parcels', 'pallets', 'delivery'));
    }

    // Save shipment information
    public function store(Request $request, Delivery $delivery)
    {
        $validated = $request->validate([
            'parcels' => 'required|array|min:1', // Ensure parcels array exists
            'parcels.*.weight' => 'required|numeric|gt:0', // Validate parcel weights
            'pallets' => 'nullable|array',
            'pallets.*.weight' => 'required|numeric|gt:0', // Validate pallet weights
            'pallets.*.parcels' => 'required|array|min:1', // Ensure pallets contain at least one parcel
            'pallets.*.parcels.*' => [
                'required',
            ],
        ]);

        $delivery->shipments()->delete();

        if (!empty($validated['pallets'])) {
            $pallets = array_map(function ($pallet) use (&$validated, $delivery) {
                $parcelsInPallet = array_intersect(array_keys($pallet['parcels']), array_keys($validated['parcels']));
                $validated['parcels'] = array_diff_key($validated['parcels'], array_flip($parcelsInPallet));

                $pallet['parcels'] = array_map(function ($parcel) use ($delivery) {
                    $parcel['type'] = 'parcel';
                    $parcel['delivery_id'] = $delivery->id;
                    return $parcel;
                }, $pallet['parcels']);

                return [
                    'weight' => array_sum(array_column($pallet['parcels'], 'weight')),
                    'parcels' => $pallet['parcels'],
                    'type' => 'pallet',
                ];
            }, $validated['pallets']);

            foreach ($pallets as $pallet) {
                $createdPallet = $delivery->shipments()->create($pallet);
                $createdPallet->parcels()->createMany($pallet['parcels']);
            }
        }

        $parcels = array_map(function ($parcel) {
            return [
                'weight' => $parcel['weight'],
                'type' => 'parcel',
            ];
        }, $validated['parcels']);

        $delivery->shipments()->createMany($parcels);

        return redirect()->route('shipment.create')->with('success', 'Shipments saved successfully!');
    }
}
