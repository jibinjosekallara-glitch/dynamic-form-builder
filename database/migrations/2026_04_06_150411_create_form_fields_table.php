<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('form_fields', function (Blueprint $table) {
            $table->id();
            $table->foreignId('form_id')->constrained('forms')->onDelete('cascade'); // link to forms
            $table->string('label'); // field label
            $table->string('type'); // text, number, email, date, dropdown, checkbox
            $table->boolean('required')->default(false); // required flag
            $table->string('validation')->nullable(); // e.g., email, numeric
            $table->json('options')->nullable(); // for dropdown/checkbox options
            $table->integer('order')->default(0); // display order
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('form_fields');
    }
};