<?php

require __DIR__ . '/vendor/autoload.php';

use Sandis\Practice\Parcel;
use Sandis\Practice\Product;

class ShippingCalculator
{
    public function calculateParcelCost($totalWeight, $parcelPricingTable)
    {
        $totalCost = 0;
        $remainingWeight = $totalWeight;

        // Sort pricing table by weight range (ascending)
        usort($parcelPricingTable, function ($a, $b) {
            return $a['max_weight'] <=> $b['max_weight'];
        });

        foreach ($parcelPricingTable as $range) {
            if ($remainingWeight <= 0) break;

            $maxWeight = $range['max_weight'];
            $price = $range['price'];

            if ($remainingWeight >= $maxWeight) {
                $parcels = floor($remainingWeight / $maxWeight);
                $totalCost += $parcels * $price;
                $remainingWeight -= $parcels * $maxWeight;
            }
        }

        // Handle remaining weight (if any)
        if ($remainingWeight > 0) {
            $totalCost += end($parcelPricingTable)['price'];
        }

        return $totalCost;
    }

    public function calculatePalletCost($totalWeight, $palletTypes)
    {
        $minCost = PHP_FLOAT_MAX;

        // Sort pallet types by max_weight (ascending)
        usort($palletTypes, function ($a, $b) {
            return $a['max_weight'] <=> $b['max_weight'];
        });

        // Try all combinations of pallet types
        foreach ($palletTypes as $pallet) {
            $maxWeight = $pallet['max_weight'];
            $price = $pallet['price'];

            $palletsNeeded = ceil($totalWeight / $maxWeight);
            $totalCost = $palletsNeeded * $price;

            if ($totalCost < $minCost) {
                $minCost = $totalCost;
            }
        }

        return $minCost;
    }

    public function calculateMixedCost($totalWeight, $parcelPricingTable, $palletTypes)
    {
        $minCost = PHP_FLOAT_MAX;

        // Try all combinations of pallet types
        foreach ($palletTypes as $pallet) {
            $maxPalletWeight = $pallet['max_weight'];
            $palletPrice = $pallet['price'];

            // Try different numbers of this pallet type
            for ($pallets = 0; $pallets <= ceil($totalWeight / $maxPalletWeight); $pallets++) {
                $palletWeight = $pallets * $maxPalletWeight;
                $remainingWeight = $totalWeight - $palletWeight;

                if ($remainingWeight < 0) continue;

                // Calculate parcel cost for the remaining weight
                $parcelCost = $this->calculateParcelCost($remainingWeight, $parcelPricingTable);
                $palletCost = $pallets * $palletPrice;

                $totalCost = $parcelCost + $palletCost;

                if ($totalCost < $minCost) {
                    $minCost = $totalCost;
                }
            }
        }

        return $minCost;
    }

    function calculateCheapestShipping($totalWeight, $parcelPricingTable, $palletTypes)
    {
        // Calculate parcel-only cost
        $parcelOnlyCost = $this->calculateParcelCost($totalWeight, $parcelPricingTable);

        // Calculate pallet-only cost (for all pallet types)
        $palletOnlyCost = $this->calculatePalletCost($totalWeight, $palletTypes);

        // Calculate mixed configuration cost
        $mixedCost = $this->calculateMixedCost($totalWeight, $parcelPricingTable, $palletTypes);

        // Return the cheapest option
        return min($parcelOnlyCost, $palletOnlyCost, $mixedCost);
    }
}

$totalWeight = 300; // Example total weight in kg

$parcelPricingTable = [
    ['max_weight' => 10, 'price' => 5],
    ['max_weight' => 20, 'price' => 10],
    // Add more ranges
];

$palletTypes = [
    ['type' => 'A', 'max_weight' => 100, 'price' => 50],
    ['type' => 'B', 'max_weight' => 200, 'price' => 80],
    ['type' => 'C', 'max_weight' => 500, 'price' => 150],
];

$shippingCalculator = new ShippingCalculator();
$cheapestCost = $shippingCalculator->calculateCheapestShipping($totalWeight, $parcelPricingTable, $palletTypes);

echo "Cheapest shipping cost: $cheapestCost";
