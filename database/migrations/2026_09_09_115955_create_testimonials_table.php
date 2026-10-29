<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('designation')->nullable();
            $table->text('description');
            $table->integer('rating')->default(5);
            $table->string('ip')->nullable();
            $table->string('photo')->nullable();
            $table->timestamps();
            $table->boolean('status')->default(1);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('testimonials');
    }
};