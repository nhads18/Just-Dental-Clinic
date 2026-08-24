<?php

use Illuminate\Support\Arr;

if (! function_exists('clinic')) {
    /**
     * Read a clinic configuration value.
     *
     *   clinic()             => the clinic name (string)
     *   clinic('email')      => config('clinic.email')
     *   clinic('hours.monday')
     */
    function clinic(?string $key = null, mixed $default = null): mixed
    {
        if ($key === null) {
            return config('clinic.name');
        }

        return config('clinic.'.$key, $default);
    }
}

if (! function_exists('clinic_address')) {
    /**
     * Build a single-line clinic address from the configured parts,
     * skipping any empty/placeholder segments.
     */
    function clinic_address(string $separator = ', '): string
    {
        $parts = array_filter(
            Arr::flatten((array) config('clinic.address', [])),
            fn ($p) => is_string($p) && $p !== '' && ! str_starts_with($p, 'TODO')
        );

        return implode($separator, $parts);
    }
}

if (! function_exists('clinic_time_slots')) {
    /**
     * Generate bookable time slots ("HH:MM") from the clinic's configured
     * day_start, day_end and slot_interval — so booking hours are driven by
     * config/env, never hardcoded.
     */
    function clinic_time_slots(): array
    {
        $start    = (string) config('clinic.appointments.day_start', '09:00');
        $end      = (string) config('clinic.appointments.day_end', '18:00');
        $interval = max(5, (int) config('clinic.appointments.slot_interval', 15));

        try {
            $cursor = \Carbon\Carbon::createFromFormat('H:i', $start);
            $limit  = \Carbon\Carbon::createFromFormat('H:i', $end);
        } catch (\Throwable $e) {
            return [];
        }

        $slots = [];
        while ($cursor < $limit) {
            $slots[] = $cursor->format('H:i');
            $cursor->addMinutes($interval);
        }

        return $slots;
    }
}

if (! function_exists('peso')) {
    /**
     * Format an amount using the clinic currency symbol (₱ by default).
     */
    function peso(int|float|string|null $amount, int $decimals = 2): string
    {
        $symbol = config('clinic.currency.symbol', '₱');

        return $symbol.number_format((float) $amount, $decimals);
    }
}
