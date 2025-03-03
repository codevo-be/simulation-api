<?php

namespace Diji\Billing\Helpers;

class PricingHelper
{
    public static function getPricingDetails($subtotal = 0, $vat = 21)
    {
        $tax = $subtotal * ($vat / 100);
        $total = $subtotal + $tax;

        return [
            "subtotal" => $subtotal,
            "tax" => $tax,
            "total" => $total
        ];
    }

    public static function formatCurrency(float $value): string
    {
        return number_format($value, 2, ',', ' ') . '€';
    }
}
