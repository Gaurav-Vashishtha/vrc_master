<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reminders', function (Blueprint $table) {
            $table->id();

            $table->string('reminder_type')->default('general');

            $table->string('title');

            $table->text('description')->nullable();

            $table->decimal('amount', 10, 2)->nullable();

            $table->date('reminder_date');

            $table->unsignedInteger('remind_before_days')->default(0);

            $table->string('repeat_type')->default('none');

            $table->enum('status', [
                'pending',
                'completed',
                'cancelled'
            ])->default('pending');

            $table->timestamp('completed_at')->nullable();

            $table->unsignedBigInteger('created_by')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reminders');
    }
};