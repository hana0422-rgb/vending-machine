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
            $table->string('representative_name')->nullable(); // 代表者名
            $table->timestamps(); 
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
}
