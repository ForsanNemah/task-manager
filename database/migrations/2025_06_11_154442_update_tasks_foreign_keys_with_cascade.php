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
        //


         Schema::table('tasks', function (Blueprint $table) {
        // حذف العلاقات القديمة
        $table->dropForeign(['sender_id']);
        $table->dropForeign(['receiver_id']);

        // إعادة إضافتها مع onDelete('cascade')
        $table->foreign('sender_id')->references('id')->on('users')->onDelete('cascade');
        $table->foreign('receiver_id')->references('id')->on('users')->onDelete('cascade');
    });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
