<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColorAndVolumeToOrderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('order_details', function (Blueprint $table) {
            $table->string('color')->nullable()->after('product_id')->comment('Lưu màu sản phẩm makeup');
            $table->string('volume')->nullable()->after('color')->comment('Lưu dung tích sản phẩm skin care');
        });
    }

    public function down(): void
    {
        Schema::table('order_details', function (Blueprint $table) {
            $table->dropColumn(['color', 'volume']);
        });
    }
}
