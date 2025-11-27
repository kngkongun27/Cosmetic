<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCapacityAndCodeToProductDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_details', function (Blueprint $table) {
            $table->string('capacity', 50)->nullable()->after('size');
            $table->string('code', 100)->nullable()->after('capacity');
        });
    }

    public function down()
    {
        Schema::table('product_details', function (Blueprint $table) {
            $table->dropColumn(['capacity', 'code']);
        });
    }
}
