<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('products')->insert([
            [
                'product_name' => 'お茶',
                'maker_name' => 'あ', 
                'price' => 120,
                'stock' => 10,
                'comment' => 'さっぱりした味',
                'company_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'product_name' => 'コーヒー',
                'maker_name' => 'い', 
                'price' => 150,
                'stock' => 5,
                'comment' => '苦味あり',
                'company_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'product_name' => 'スポーツドリンク',
                'maker_name' => 'う', 
                'price' => 130,
                'stock' => 20,
                'comment' => 'スポーツ後に',
                'company_id' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
