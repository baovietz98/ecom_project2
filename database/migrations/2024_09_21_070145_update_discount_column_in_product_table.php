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
            $table->decimal('discount', 8, 2)->nullable()->change(); // Đảm bảo cột discount có thể nhận giá trị null
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product', function (Blueprint $table) {
            //
            $table->decimal('discount', 8, 2)->nullable(false)->change(); // Khôi phục lại nếu cần
        });
    }
};
