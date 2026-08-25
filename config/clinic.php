<?php

/*
|--------------------------------------------------------------------------
| Clinic Configuration — Prime Smiles Dental Clinic
|--------------------------------------------------------------------------
|
| Single source of truth for clinic-specific identity and business rules.
| Do NOT hardcode clinic details in Blade templates or controllers — read
| them from here via config('clinic.*'), or the clinic() helper.
|
| Values marked "TODO: supplied by clinic" are placeholders. Replace them
| with the real Prime Smiles Dental Clinic information (or set the matching env var)
| before going to production. Never commit real secrets here.
|
*/

return [

    // ----- Identity -----------------------------------------------------
    'name'        => env('CLINIC_NAME', 'Prime Smiles Dental Clinic'),
    'short_name'  => env('CLINIC_SHORT_NAME', 'Prime Smiles'),
    'legal_name'  => env('CLINIC_LEGAL_NAME', 'Prime Smiles Dental Clinic Inc.'),
    'tagline'     => env('CLINIC_TAGLINE', 'Your smile, our passion.'),

    // Asset paths (relative to /public). Replace with real brand assets.
    'logo'        => env('CLINIC_LOGO', 'img/logo.svg'),
    'logo_dark'   => env('CLINIC_LOGO_DARK', 'img/logo.svg'),
    'favicon'     => env('CLINIC_FAVICON', 'favicon.ico'),

    // ----- AI assistant -------------------------------------------------
    'assistant'   => [
        'name' => env('CLINIC_ASSISTANT_NAME', 'Prime AI'),
    ],

    // ----- Contact & location ------------------------------------------
    // TODO: supplied by clinic
    'email'       => env('CLINIC_EMAIL', 'info@primesmiles.example'),
    'phone'       => env('CLINIC_PHONE', '+63 000 000 0000'),
    'address'     => [
        'line1'   => env('CLINIC_ADDRESS_LINE1', 'TODO: supplied by clinic'),
        'line2'   => env('CLINIC_ADDRESS_LINE2', ''),
        'city'    => env('CLINIC_ADDRESS_CITY', ''),
        'province'=> env('CLINIC_ADDRESS_PROVINCE', ''),
        'country' => env('CLINIC_ADDRESS_COUNTRY', 'Philippines'),
        'postal'  => env('CLINIC_ADDRESS_POSTAL', ''),
    ],
    // Google Maps embed URL for the location section (optional).
    'map_embed_url' => env('CLINIC_MAP_EMBED_URL', ''),

    // ----- Web & social -------------------------------------------------
    'website'     => env('CLINIC_WEBSITE', 'https://primesmiles.example'),
    'social'      => [
        'facebook'  => env('CLINIC_FACEBOOK', ''),
        'instagram' => env('CLINIC_INSTAGRAM', ''),
        'tiktok'    => env('CLINIC_TIKTOK', ''),
    ],

    // ----- Operating hours ---------------------------------------------
    // Human-readable per day. TODO: supplied by clinic.
    'hours' => [
        'monday'    => env('CLINIC_HOURS_MON', '9:00 AM – 6:00 PM'),
        'tuesday'   => env('CLINIC_HOURS_TUE', '9:00 AM – 6:00 PM'),
        'wednesday' => env('CLINIC_HOURS_WED', '9:00 AM – 6:00 PM'),
        'thursday'  => env('CLINIC_HOURS_THU', '9:00 AM – 6:00 PM'),
        'friday'    => env('CLINIC_HOURS_FRI', '9:00 AM – 6:00 PM'),
        'saturday'  => env('CLINIC_HOURS_SAT', '9:00 AM – 3:00 PM'),
        'sunday'    => env('CLINIC_HOURS_SUN', 'Closed'),
    ],

    // ----- Regional -----------------------------------------------------
    'timezone'    => env('CLINIC_TIMEZONE', 'Asia/Manila'),
    'currency'    => [
        'code'   => env('CLINIC_CURRENCY_CODE', 'PHP'),
        'symbol' => env('CLINIC_CURRENCY_SYMBOL', '₱'),
    ],

    // ----- Appointment settings ----------------------------------------
    'appointments' => [
        // Default appointment slot length in minutes.
        'default_duration'      => (int) env('CLINIC_APPT_DURATION', 30),
        // Spacing between selectable booking times, in minutes.
        'slot_interval'         => (int) env('CLINIC_APPT_SLOT_INTERVAL', 15),
        // Earliest/latest bookable times (24h HH:MM).
        'day_start'             => env('CLINIC_APPT_DAY_START', '09:00'),
        'day_end'               => env('CLINIC_APPT_DAY_END', '18:00'),
        // Minimum lead time (hours) before an appointment can be booked.
        'min_lead_time_hours'   => (int) env('CLINIC_APPT_MIN_LEAD', 2),
        // Whether an optional down payment is offered at booking.
        'require_down_payment'  => (bool) env('CLINIC_APPT_REQUIRE_DP', false),
        // Down payment percentage when offered.
        'down_payment_percent'  => (int) env('CLINIC_APPT_DP_PERCENT', 20),
    ],

    // ----- Payment settings --------------------------------------------
    // Secret keys live in .env only — never in this file.
    'payments' => [
        'enabled'  => (bool) env('CLINIC_PAYMENTS_ENABLED', true),
        'provider' => env('CLINIC_PAYMENTS_PROVIDER', 'paymongo'),
        // Which PayMongo methods to offer.
        'methods'  => [
            'gcash'  => (bool) env('CLINIC_PAY_GCASH', true),
            'paymaya'=> (bool) env('CLINIC_PAY_PAYMAYA', true),
            'card'   => (bool) env('CLINIC_PAY_CARD', true),
        ],
    ],

    // ----- SEO / metadata ----------------------------------------------
    'seo' => [
        'title'       => env('CLINIC_SEO_TITLE', 'Prime Smiles Dental Clinic'),
        'description' => env('CLINIC_SEO_DESCRIPTION', 'Prime Smiles Dental Clinic — gentle, modern dental care. Book your appointment online.'),
        'keywords'    => env('CLINIC_SEO_KEYWORDS', 'dental clinic, dentist, teeth cleaning, Prime Smiles'),
        'og_image'    => env('CLINIC_SEO_OG_IMAGE', 'img/logo.svg'),
    ],

];
