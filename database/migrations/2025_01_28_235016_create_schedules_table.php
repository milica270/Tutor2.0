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
            $table->id(); 
            $table->unsignedBigInteger('tutor_id'); 
            $table->unsignedBigInteger('user_id');
            $table->date('date'); 
            $table->unsignedInteger('hour_id'); 
            $table->unsignedBigInteger('subject_id');
            $table->text('details')->nullable(); 
            $table->timestamps(); 

            
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
