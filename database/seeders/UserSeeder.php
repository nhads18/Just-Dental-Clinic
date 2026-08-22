<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Seed demo accounts for Just Dental Clinic.
     *
     * These are clearly-labelled DEMO accounts for local/testing use only.
     * Do NOT ship these credentials to production — create real accounts and
     * remove/disable the demo ones. None of these represent real people.
     */
    public function run(): void
    {
        // Demo administrator
        DB::table('users')->updateOrInsert(
            ['email' => 'admin@justdental.example'],
            [
                'name' => 'Demo Admin',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'usertype' => 'admin',
                'bio' => 'Demo administrator account for '.config('clinic.name').'.',
                'avatar' => 'img/default-dp.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        // Demo patients — obviously fictional records (see spec: no fake real PII)
        $demoPatients = [
            ['name' => 'Juan Demo',   'email' => 'juan.demo@justdental.example'],
            ['name' => 'Maria Sample','email' => 'maria.sample@justdental.example'],
            ['name' => 'Test Patient','email' => 'test.patient@justdental.example'],
        ];

        foreach ($demoPatients as $p) {
            DB::table('users')->updateOrInsert(
                ['email' => $p['email']],
                [
                    'name' => $p['name'],
                    'email_verified_at' => now(),
                    'password' => Hash::make('password'),
                    'usertype' => 'user',
                    'bio' => 'Demo patient account (fictional).',
                    'avatar' => 'img/default-dp.jpg',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}
