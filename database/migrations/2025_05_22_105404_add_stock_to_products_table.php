<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // すでに存在していないカラムのみ追加
            if (!Schema::hasColumn('products', 'stock')) {
                $table->integer('stock')->default(0)->after('price');
            }

            if (!Schema::hasColumn('products', 'comment')) {
                $table->text('comment')->nullable()->after('stock');
            }

            if (!Schema::hasColumn('products', 'image_path')) {
                $table->string('image_path')->nullable()->after('comment');
            }

            // company_id はすでにあるのでコメントアウト（または削除）
            /*
            if (!Schema::hasColumn('products', 'company_id')) {
                $table->unsignedBigInteger('company_id')->nullable()->after('image_path');
                $table->foreign('company_id')->references('id')->on('companies')->onDelete('set null');
            }
            */
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // 外部キーは削除されていないので safe に実行できるようコメントアウトするのもOK
            // $table->dropForeign(['company_id']);
            $table->dropColumn(['stock', 'comment', 'image_path']);
        });
    }
};
