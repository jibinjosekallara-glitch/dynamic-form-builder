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
       Schema::table('submissions', function (Blueprint $table) {
    $table->unsignedBigInteger('form_id')->after('id');
    $table->string('user_name')->nullable()->after('form_id');
    $table->string('user_email')->nullable()->after('user_name');
    $table->json('data')->after('user_email');

    $table->foreign('form_id')->references('id')->on('forms')->onDelete('cascade');
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('submissions', function (Blueprint $table) {
            //
        });
    }
};
