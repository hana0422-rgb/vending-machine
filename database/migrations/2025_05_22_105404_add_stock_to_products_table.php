<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (!Schema::hasColumn('products', 'stock')) {
                $table->integer('stock')->default(0)->after('price');
            }

            if (!Schema::hasColumn('products', 'comment')) {
                $table->text('comment')->nullable()->after('stock');
            }

            if (!Schema::hasColumn('products', 'image_path')) {
                $table->string('image_path')->nullable()->after('comment');
            }
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {

            $table->dropColumn(['stock', 'comment', 'image_path']);
        });
    }
};
