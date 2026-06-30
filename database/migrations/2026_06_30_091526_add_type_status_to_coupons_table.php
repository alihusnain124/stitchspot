<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('coupons', function (Blueprint $table) {
            $table->string('type')->default('flat')->after('value');
            $table->integer('status')->default(1)->after('is_one_time');
        });
    }

    public function down()
    {
        Schema::table('coupons', function (Blueprint $table) {
            $table->dropColumn(['type', 'status']);
        });
    }
};
