<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('product', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('brand_id')->nullable(); // Cột cho ID hãng

            // Thêm cột product_code
            $table->string('product_code')->unique(); // Cột mã sản phẩm, đảm bảo là duy nhất

            // Khóa ngoại cho brand_id
            $table->foreign('brand_id')->references('id')->on('brands')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product', function (Blueprint $table) {
            // Xóa khóa ngoại trước khi xóa cột
            $table->dropForeign(['brand_id']);
            $table->dropColumn('brand_id'); // Xóa cột brand_id
            $table->dropColumn('product_code'); // Xóa cột product_code
        });
    }
};
