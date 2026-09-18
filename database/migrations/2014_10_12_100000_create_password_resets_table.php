<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        // A fluent ->primary() on a string column makes Laravel issue the CREATE
        // TABLE first and add the primary key in a follow-up ALTER. Managed MySQL
        // hosts such as Aiven run with sql_require_primary_key=ON and reject that
        // intermediate table, so on MySQL the key has to be declared inline.
        if (DB::connection()->getDriverName() !== 'mysql') {
            Schema::create('password_resets', function (Blueprint $table) {
                $table->string('email')->primary();
                $table->string('token');
                $table->timestamp('created_at')->nullable();
            });

            return;
        }

        $charset = DB::connection()->getConfig('charset') ?: 'utf8mb4';
        $collation = DB::connection()->getConfig('collation') ?: 'utf8mb4_unicode_ci';

        DB::statement("
            create table `password_resets` (
                `email` varchar(255) not null,
                `token` varchar(255) not null,
                `created_at` timestamp null,
                primary key (`email`)
            ) default character set {$charset} collate '{$collation}'
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('password_resets');
    }
};
