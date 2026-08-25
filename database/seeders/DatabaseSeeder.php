<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Default seed = SAFE demo data only.
        $this->call([
            UserSeeder::class,             // clearly-labelled demo accounts
            ProcedurePricesSeeder::class,  // demo service catalog / placeholder pricing
            InventorySeeder::class,        // demo inventory stock
        ]);

        // The seeders below fabricate patient medical records, appointments and
        // public reviews. They are intentionally DISABLED for Prime Smiles Dental Clinic:
        // fabricated medical records must never be mistaken for real patient data,
        // and testimonials must be genuine. Enable only for isolated local testing.
        //
        // $this->call([
        //     DentalRecordsSeeder::class,
        //     AppointmentsSeeder::class,
        //     RatingsSeeder::class,
        // ]);
    }
}
