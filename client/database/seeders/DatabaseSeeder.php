<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\{Company, User, Client, Vehicle, Admin};
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        if (!Company::where('email', 'admin@test.com')->orWhere('name', 'my company')->limit(1)->first()) {
            $Company = Company::create([
                'name' => 'my company',
                'email' => 'admin@test.com',
                'phone' => '212999999999',

                'ice_number' => 'XXXXXXXXXX',
                'license_number' => 'XXXXXXXXXX',

                'city' => 'marrakesh',
                'zipcode' => '40000',
                'address' => 'XXXXXXXXXX',

                'mileage_per_day' => 100,
                'status' => 'active'
            ]);

            $User = User::create([
                'company' => $Company->id,
                'first_name' => 'mohamed',
                'last_name' => 'kamal',
                'email' => 'admin@test.com',
                'phone' => '212999999999',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'
            ]);

            $User->Setting()->create([
                'language' => 'fr',
                'currency' => 'MAD',
                'report_frequency' => 'week',
                'date_format' => 'YYYY-MM-DD',
                'theme_color' => 'ocean tide',
            ]);

            Client::create([
                'identity_type' => 'cin',
                'identity_number' => 'I9887',
                'identity_issued_in' => 'beni mellal',
                'identity_issued_at' => now(),

                'license_number' => '65135678',
                'license_issued_in' => 'beni mellal',
                'license_issued_at' => '2017-08-16',

                "first_name" => "Mohamed",
                "last_name" => "Elkor",
                "phone" => "0666299469",
                "email" => "elkor@hotmail.co.jp",
                "nationality" => "moroccan",

                "gender" => "male",
                "birth_date" => "1984-05-15",
                'city' => 'beni mellal',
                'zipcode' => 'XXXXXXX',
                "address" => "16 bloc 5 hay rmila",

                'company' => $Company->id,
            ]);

            Vehicle::create([
                'registration_type' => 'WW',
                'registration_number' => 'WW-12345',
                'brand' => 'smart',
                'model' => 'cabrio',
                'year' => '2010',
                'daily_rate' => 350,

                'passenger_capacity' => 4,
                'mileage' => 10500,
                'number_of_doors' => 5,
                'cargo_capacity' => 4,
                'transmission_type' => 'manual',
                'fuel_type' => 'diesel',

                'registration_date' => now(),
                'horsepower' => 'less than 8 cv',
                'horsepower_tax' => 700,
                'insurance_company' => 'company 1',
                'insurance_issued_at' => now(),
                'insurance_cost' => 5000,

                'company' => $Company->id,
            ]);
        }

        if (!Admin::where('email', 'super@test.com')->orWhere('phone', '212999999991')->limit(1)->first()) {
            $Admin = Admin::create([
                'first_name' => 'admin',
                'last_name' => 'admin',
                'email' => 'super@test.com',
                'phone' => '212999999991',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'
            ]);

            $Admin->Setting()->create([
                'language' => 'fr',
                'currency' => 'MAD',
                'report_frequency' => 'week',
                'date_format' => 'YYYY-MM-DD',
                'theme_color' => 'ocean tide',
            ]);
        }
    }
}
