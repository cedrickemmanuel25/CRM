<?php

if (!function_exists('currency_symbol')) {
    /**
     * Get the currency symbol from settings
     *
     * @return string
     */
    function currency_symbol()
    {
        $currency = \App\Models\Setting::get('currency', 'EUR');
        
        return match($currency) {
            'USD' => '$',
            'EUR' => '€',
            'GBP' => '£',
            default => '€',
        };
    }
}

if (!function_exists('company_name')) {
    /**
     * Get the company name from settings
     *
     * @return string
     */
    function company_name()
    {
        return \App\Models\Setting::get('company_name', 'CRM Pro');
    }
}

if (!function_exists('format_currency')) {
    /**
     * Format a number as currency with the configured symbol
     *
     * @param float $amount
     * @param int $decimals
     * @return string
     */
    function format_currency($amount, $decimals = 0)
    {
        $formatted = number_format($amount, $decimals, ',', ' ');
        $symbol = currency_symbol();
        
        // USD uses prefix, EUR uses suffix
        $currency = \App\Models\Setting::get('currency', 'EUR');
        if ($currency === 'USD') {
            return $symbol . $formatted;
        }
        
        return $formatted . ' ' . $symbol;
    }
}

if (!function_exists('format_phone')) {
    /**
     * Format a phone number for display
     * Separates country code and adds spacing
     *
     * @param string|null $phone
     * @return string|null
     */
    function format_phone($phone)
    {
        if (empty($phone)) {
            return $phone;
        }

        // Clean formatting but keep +
        $clean = preg_replace('/[^0-9+]/', '', $phone);
        
        // Check for common country codes
        // Cote d'Ivoire (+225)
        if (str_starts_with($clean, '+225')) {
            $rest = substr($clean, 4);
            // Format rest as chunks of 2 if possible, or leave as is
            $formatted = trim(chunk_split($rest, 2, ' '));
            return '+225 ' . $formatted;
        }
        
        // France (+33)
        if (str_starts_with($clean, '+33')) {
            $rest = substr($clean, 3);
            // Standard format: +33 6 12 34 56 78 (9 digits)
            if (strlen($rest) === 9) {
                 return '+33 ' . $rest[0] . ' ' . trim(chunk_split(substr($rest, 1), 2, ' '));
            }
            $formatted = trim(chunk_split($rest, 2, ' '));
            return '+33 ' . $formatted;
        }

        // Generic formatting: split after 4 chars and space the rest if it starts with +
        if (str_starts_with($clean, '+')) {
            return substr($clean, 0, 4) . ' ' . trim(chunk_split(substr($clean, 4), 2, ' '));
        }

        return $phone;
    }
}
