<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('company_name');
            $table->string('street_address')->nullable();
            $table->string('representative_name')->nullable();
            $table->timestamps(); // created_at, updated_at を自動で追加
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
