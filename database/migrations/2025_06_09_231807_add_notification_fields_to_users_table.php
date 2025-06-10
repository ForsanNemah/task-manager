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
        Schema::table('users', function (Blueprint $table) {
            //

             $table->string('phone')->nullable()->after('password');
        $table->string('group_id')->nullable()->after('phone');
        $table->boolean('send_noti_in_privete')->default(true)->after('group_id');
        $table->boolean('send_noti_in_group')->default(true)->after('send_noti_in_privete');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
