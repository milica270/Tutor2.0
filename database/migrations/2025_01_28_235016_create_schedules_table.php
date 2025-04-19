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
        Schema::create('schedules', function (Blueprint $table) {
            $table->id(); // Auto-incrementing primary key.
            $table->unsignedBigInteger('tutor_id'); // Foreign key referencing users (tutor).
            $table->unsignedBigInteger('user_id'); // Foreign key referencing users (student).
            $table->date('date'); // The date when the session will be held.
            $table->unsignedInteger('hour_id'); // Foreign key for the available hour (linked to time slots).
            $table->unsignedBigInteger('subject_id'); // Foreign key referencing the subject table.
            $table->text('details')->nullable(); // Details provided by the student.
            $table->timestamps(); // Created at and updated at.

            // Foreign key constraints
            $table->foreign('tutor_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('hour_id')->references('id')->on('appointments')->onDelete('cascade'); // This assumes a separate appointments table for hours.
            $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('cascade');
       
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
