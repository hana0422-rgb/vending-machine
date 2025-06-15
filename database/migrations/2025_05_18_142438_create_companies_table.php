<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
    public function up(): void
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id(); // ID
            $table->string('company_name'); // 会社名
            $table->string('street_address'); // 住所
            $table->string('representative_name'); // 代表者名
            $table->string('contact_number'); // 電話番号
            $table->string('email')->unique(); // メールアドレス
            $table->timestamps();
        });
    }

        // マイグレーション時にデフォルトの会社データを挿入
        DB::table('companies')->insert([
            [
                'company_name' => 'A株式会社',
                'address' => '東京都港区1-1-1',
                'tel' => '03-1111-1111',
                'email' => 'a@example.com',
                'url' => 'https://a.example.com',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'company_name' => 'B株式会社',
                'address' => '大阪市中央区2-2-2',
                'tel' => '06-2222-2222',
                'email' => 'b@example.com',
                'url' => 'https://b.example.com',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('companies');
    }

