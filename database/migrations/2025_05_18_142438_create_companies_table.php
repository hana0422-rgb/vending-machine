<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');
            $table->string('product_name');
            $table->string('maker_name')->nullable();
            $table->integer('price');
            $table->integer('stock');
            $table->text('comment')->nullable();
            $table->string('image_path')->nullable();
            $table->timestamps();

            // 🔽 外部キー制約（忘れがち）
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
};
