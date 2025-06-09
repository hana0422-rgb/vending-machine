<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\CompanySeeder;
use Database\Seeders\ProductSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Call individual seeders here
        $this->call([
            CompanySeeder::class,
            ProductSeeder::class,
        ]);
    }
}
