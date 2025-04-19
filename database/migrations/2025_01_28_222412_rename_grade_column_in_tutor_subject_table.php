<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('tutor_subject', function (Blueprint $table) {
            $table->renameColumn('grade', 'subject_grade'); // Renaming 'grade' to 'subject_grade'
        });
    }

    public function down()
    {
        Schema::table('tutor_subject', function (Blueprint $table) {
            $table->renameColumn('subject_grade', 'grade'); 
        });
    }
};
