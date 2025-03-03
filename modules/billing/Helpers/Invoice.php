<?php

namespace Diji\Billing\Helpers;

class Invoice {
    public static function generateStructuredCommunication(int $invoice_identifier)
    {
        $currentDate = \Carbon\Carbon::now()->format('ymd');

        $cleanedIdentifier = preg_replace('/\D/', '', $invoice_identifier);
        $cleanedIdentifier = str_pad(substr($cleanedIdentifier, 0, 4), 4, '0', STR_PAD_LEFT);

        $base = $cleanedIdentifier . $currentDate;

        $modulus = $base % 97;
        $modulus = ($modulus > 0) ? $modulus : 97;

        return $base . str_pad($modulus, 2, '0', STR_PAD_LEFT);
    }

    public static function formatStructuredCommunication(string $value): string
    {
        return "+++" . substr($value, 0, 3) . '/' . substr($value, 3, 4) . '/' . substr($value, 7) . "+++";
    }
}
