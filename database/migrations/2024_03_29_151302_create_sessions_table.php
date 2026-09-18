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
        // See the password_resets migration: a string primary key would otherwise
        // be added by a follow-up ALTER, which sql_require_primary_key rejects.
        if (DB::connection()->getDriverName() !== 'mysql') {
            Schema::create('sessions', function (Blueprint $table) {
                $table->string('id')->primary();
                $table->foreignId('user_id')->nullable()->index();
                $table->string('ip_address', 45)->nullable();
                $table->text('user_agent')->nullable();
                $table->longText('payload');
                $table->integer('last_activity')->index();
            });

            return;
        }

        $charset = DB::connection()->getConfig('charset') ?: 'utf8mb4';
        $collation = DB::connection()->getConfig('collation') ?: 'utf8mb4_unicode_ci';

        DB::statement("
            create table `sessions` (
                `id` varchar(255) not null,
                `user_id` bigint unsigned null,
                `ip_address` varchar(45) null,
                `user_agent` text null,
                `payload` longtext not null,
                `last_activity` int not null,
                primary key (`id`),
                key `sessions_user_id_index` (`user_id`),
                key `sessions_last_activity_index` (`last_activity`)
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
        Schema::dropIfExists('sessions');
    }
};
