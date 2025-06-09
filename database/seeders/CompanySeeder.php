<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompanySeeder extends Seeder
{
    public function run()
    {
       
        DB::table('companies')->insert([
            [
                'company_name' => 'A株式会社',
                'street_address' => '東京都新宿区1-1-1',
                'representative_name' => '田中 一郎',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'company_name' => 'B株式会社',
                'street_address' => '大阪府大阪市中央区2-2-2',
                'representative_name' => '佐藤 花子',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

    }
}
