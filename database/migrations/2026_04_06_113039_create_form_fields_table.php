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
       Schema::create('form_fields', function (Blueprint $table){
            $table->id();
            $table->foreignId('form_id')->constrained()->cascadeOnDelete();
            $table->string('label');
            $table->string('type'); // text, email, number, date, dropdown, checkbox
            $table->boolean('required')->default(false);
            $table->text('options')->nullable(); // JSON for dropdown or checkbox
            $table->integer('order')->default(0);
            $table->string('validation')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('form_fields');
    }
};
