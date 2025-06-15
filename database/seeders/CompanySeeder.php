<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompanySeeder extends Seeder
{
   public function run()
{
    if (DB::table('companies')->count() === 0) {
        DB::table('companies')->insert([
            [
                'company_name' => 'A株式会社',
                'street_address' => '東京都港区1-1-1',
                'representative_name' => '田中一郎',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'company_name' => 'B株式会社',
                'street_address' => '大阪市中央区2-2-2',
                'representative_name' => '佐藤花子',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'company_name' => 'C株式会社',
                'street_address' => '名古屋市中区3-3-3',
                'representative_name' => '鈴木次郎',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

}
